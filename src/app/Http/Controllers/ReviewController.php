<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Message;
use App\Models\Profile;
use App\Models\Payment;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class ReviewController extends Controller
{
    public function store(Request $request, $payment_id)
    {
        $id = Auth::id();
        $payment = Payment::findOrFail($payment_id);

        // 自分がレビュー済みならトップへ
        if (Review::where('payment_id', $payment_id)
            ->where('user_id', Auth::id())
            ->exists()
        ) {
            return redirect('/');
        }

        Review::create([
            'payment_id' => $payment_id,
            'user_id'  => $id,
            'rating'     => $request->rating,
        ]);

        return redirect('/')->with('status', 'レビューを投稿しました');
    }
}