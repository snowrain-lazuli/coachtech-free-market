<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Message;
use App\Models\Profile;
use App\Models\Payment;
use App\Models\Image;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Http\Requests\MessageRequest;

class PurchaseController extends Controller
{
    public function purchase(Request $request, $item_id)
    {
        $id = Auth::id();
        $contact = Item::with('image')->findOrFail($item_id);
        $profile = Profile::where('user_id', $id)->first();

        if ($profile->post_code) {
            $profile->post_code = substr($profile->post_code, 0, 3) . '-' . substr($profile->post_code, 3);
        }

        return view('purchase', compact('contact', 'profile'));
    }

    public function purchasePost(Request $request, $item_id)
    {
        $id = Auth::id();
        $payment_method = $request->input('payment_method');

        if ($payment_method === '1') {
            $payment = Payment::create([
                'user_id' => $id,
                'item_id' => $item_id,
                'paid_at' => now(),
                'trading' => 0,
                'stripe_payment_intent_id' => null
            ]);
            return redirect()->route('purchase.chat', ['payment_id' => $payment->id]);
        }

        if ($payment_method === '2') {
            return redirect()->route('payment.stripe', ['item_id' => $item_id]);
        }

        return back()->with('error', '支払い方法を選択してください');
    }

    public function address($item_id)
    {
        $id = Auth::id();
        $profile = Profile::where('user_id', $id)->first();
        return view('address', compact('profile', 'item_id'));
    }

    public function createPaymentIntent($item_id)
    {
        $id = Auth::id();
        $contact = Item::findOrFail($item_id);

        Stripe::setApiKey(config('services.stripe.secret'));
        $paymentIntent = PaymentIntent::create([
            'amount' => $contact->price * 100,
            'currency' => 'jpy',
            'metadata' => [
                'user_id' => $id,
                'item_id' => $item_id
            ],
        ]);

        return response()->json(['clientSecret' => $paymentIntent->client_secret]);
    }

    public function paymentSuccess(Request $request)
    {
        $id = Auth::id();
        $item_id = $request->input('item_id');
        $paymentIntentId = $request->input('payment_intent_id');

        $payment = Payment::create([
            'user_id' => $id,
            'item_id' => $item_id,
            'paid_at' => now(),
            'trading' => 0,
            'stripe_payment_intent_id' => $paymentIntentId
        ]);

        return response()->json(['success' => true, 'redirect' => route('purchase.chat', ['payment_id' => $payment->id])]);
    }

    public function showStripePayment($item_id)
    {
        $contact = Item::findOrFail($item_id);
        return view('payment.stripe', compact('contact'));
    }

    public function chat($paymentId)
    {
        $id = Auth::id();

        $payment = Payment::with([
            'user.image',
            'item.user.image',
            'item.image',
            'messages.user.image',
        ])->findOrFail($paymentId);

        // 自分のロール判定
        if ($payment->user_id === $id) {
            $role = 'buyer';
            $partner = $payment->item->user;
        } else {
            $role = 'seller';
            $partner = $payment->user;
        }

        // サイドバー
        $other_trades = Payment::with(['item.image', 'item.user', 'user'])
            ->where(function ($q) use ($id) {
                $q->where('user_id', $id)
                    ->orWhereHas('item', fn($q2) => $q2->where('user_id', $id));
            })
            // 自分がレビュー済みのものを除外
            ->whereDoesntHave('review', fn($q) => $q->where('user_id', $id))
            ->withMax('messages', 'created_at')
            ->orderByDesc('messages_max_created_at')
            ->get();

        $messages = $payment->messages()->with('user.image')->where('sender', '!=', '2')->orderBy('created_at')->get();
        // 取引完了判定
        $chatCompleted = $payment->messages()->where('content', 'completed')->exists();

        // モーダル表示フラグ判定
        $showModal = $payment->messages()
            ->where('content', 'completed')
            ->exists() // completed メッセージがある
            && !Review::where('payment_id', $payment->id)
                ->where('user_id', $id)
                ->exists(); // 自分のレビューがまだない


        // レビュー済み判定
        $reviewed = Review::where('payment_id', $payment->id)->exists();

        return view('purchase.chat', compact(
            'payment',
            'role',
            'partner',
            'other_trades',
            'messages',
            'chatCompleted',
            'reviewed',
            'showModal'
        ));
    }

    public function complete($payment_id)
    {
        $payment = Payment::findOrFail($payment_id);
        $userId = Auth::id();

        // すでにcompletedがあるか確認（念のため二重登録防止）
        $completedExists = $payment->messages()->where('content', 'completed')->exists();

        if (!$completedExists) {
            // 取引完了メッセージを追加
            Message::create([
                'payment_id' => $payment->id,
                'user_id'    => $userId,
                'message'    => '取引を完了しました',
                'sender'     => '2',
                'content'    => 'completed',
            ]);
        }

        // モーダル表示フラグ判定
        $showModal = $payment->messages()
            ->where('content', 'completed')
            ->exists() // completed メッセージがある
            && !Review::where('payment_id', $payment->id)
                ->where('user_id', $userId)
                ->exists(); // 自分のレビューがまだない

        // フラグをセッションに入れてリダイレクト
        return redirect()->back()->with('show_review_modal', $showModal);
    }
    
    public function store(MessageRequest $request, $paymentId)
    {
        $id = Auth::id();
        $payment = Payment::with('item')->findOrFail($paymentId);

        // メッセージ作成
        $message = Message::create([
            'payment_id' => $payment->id,
            'user_id'    => $id,
            'message'    => $request->message,
        ]);

        // 画像がアップロードされていれば保存
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            // 元の拡張子取得（png, jpgなど）
            $extension = $file->getClientOriginalExtension();
            $extension = in_array(strtolower($extension), ['jpg', 'jpeg', 'png']) ? $extension : 'png';

            // ファイル名を生成（例: message_123_20250826_121530.png）
            $filename = 'message_' . $message->id . '_' . date('Ymd_His') . '.' . $extension;

            // storage/app/public/messages に保存
            $path = $file->storeAs('messages', $filename, 'public');

            // images テーブルに保存
            Image::create([
                'user_id' => null,
                'item_id' => null,
                'message_id' => $message->id,
                'img_url'    => $path,
            ]);
        }

        return back()->with('success', '送信しました');
    }


    public function update(Request $request, $messageId)
    {
        $message = Message::findOrFail($messageId);
        $message->update([
            'message' => $request->message,
        ]);

        return back()->with('success', 'メッセージを更新しました');
    }

    public function destroy(Request $request, $messageId)
    {
        $message = Message::findOrFail($messageId);
        $message->delete();
        return back()->with('success', 'メッセージを削除しました');
    }

//チャット保存用

    public function save(Request $request)
    {
        $paymentId = $request->input('payment_id');
        $message = $request->input('message');

        session()->put("chat_draft.{$paymentId}", $message);

        return response()->json(['status' => 'ok']);
    }

    public function load($paymentId)
    {
        $message = session("chat_draft.{$paymentId}", '');
        return response()->json(['message' => $message]);
    }
}