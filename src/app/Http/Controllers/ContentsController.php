<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\SellRequest;
use App\Http\Requests\CommentRequest;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Image;
use App\Models\Profile;
use App\Models\User;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Comment;
use App\Models\Payment;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\PaymentIntent;


class ContentsController extends Controller
{
    public function index(Request $request)
    {
        // ログインユーザーID取得
        $id = Auth::id();

        // POSTリクエストの場合、GETにリダイレクト
        if ($request->isMethod('post')) {
            $page = $request->page;
            // リダイレクト後はGETリクエストとして処理される
            return redirect()->route('index', ['page' => $page]);
        }

        // GETリクエストの場合、クエリパラメータ 'page' を取得
        $page = $request->query('page', null);

        //'page' パラメータに応じて処理を分ける
        if (!Auth::check() || $page === null) {
            $excludedItemIds = Payment::pluck('item_id'); // payments にある item_id を取得

            $contacts = Item::where('user_id', '!=', $id)
                ->whereNotIn('id', $excludedItemIds) // 除外条件
                ->with(['image' => function ($query) {
                    $query->select('item_id', 'img_url');
                }])
                ->inRandomOrder()
                ->paginate(8);
        } elseif ($page == 'mylist' && Auth::check()) {
            $contacts = Item::whereHas('favorites', function ($query) use ($id) {
                $query->where('user_id', $id);
            })->with(['image' => function ($query) {
                $query->select('item_id', 'img_url');
            }])->paginate(8);
        }

        return view('index', compact('contacts'));
    }

    public function toggleFavorite(Request $request, $item_id)
    {

        $id = Auth::id();
        $item = Item::findOrFail($item_id);

        // 既にお気に入りに登録されているか確認
        $favorite = Favorite::where('user_id', $id)->where('item_id', $item_id)->first();

        if ($favorite) {
            // お気に入りを削除
            $favorite->delete();
        } else {
            // お気に入りに追加
            Favorite::create([
                'user_id' => $id,
                'item_id' => $item_id
            ]);
        }

        // 元のページにリダイレクト
        return redirect()->route('item', ['item_id' => $item_id]);
    }

    public function item(Request $request, $item_id)
    {
        // ログインユーザーID取得
        $id = Auth::id();

        //情報取得
        $contact = Item::with(['image', 'categories'])->find($item_id);
        $comments = $contact->comments()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
        $count_data = [
            'comment' => $comments->count(),
            'favorite' => Favorite::where('item_id', $item_id)->count()
        ];
        $profiles = User::where('id', $contact->user_id)
            ->with('image')
            ->first();
        $isPurchased = Payment::where('user_id', $id)
            ->where('item_id', $item_id)
            ->exists();

        //コメント送信時
        if ($request->isMethod('post')) {
            $commentRequest = new CommentRequest();
            $validated = $request->validate($commentRequest->rules(), $commentRequest->messages());

            if ($validated) {
                $comment = Comment::create([
                    'user_id' => $id,
                    'item_id' => $contact->id,
                    'content' => $request->input('content'),
                ]);
            }

            $comments = $contact->comments()
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        //表示内容の変換
        $conditionMap = ['良好', '目立った傷や汚れなし', 'やや傷や汚れあり', '状態が悪い'];
        $contact->condition = $conditionMap[$contact->condition - 1];
        $contact->price = number_format($contact->price);

        $comments->map(function ($comment) {
            $comment->name_content = $comment->user->name . ' : ' . $comment->content;
            return $comment;
        });

        return view('item', compact('contact', 'comments', 'count_data', 'profiles', 'isPurchased'));
    }

    public function mypage(Request $request)
    {
        $id = Auth::id();

        // ログインユーザーの画像と名前
        $profiles = User::with('image')->find($id);

        // ログインユーザーの評価
        $receivedReviews = Review::where('user_id', '!=', $id)
            ->whereHas('payment', function ($q) use ($id) {
                $q->where('user_id', $id)               // 自分が購入者
                    ->orWhereHas('item', fn($q2) => $q2->where('user_id', $id)); // 自分が出品者
            })
            ->get();

        $averageRating = round($receivedReviews->avg('rating'));

        // POSTの場合はGETにリダイレクト
        if ($request->isMethod('post')) {
            $page = $request->page;
            return redirect()->route('mypage', ['page' => $page]);
        }

        $page = $request->query('page');

        // ----- 全商品の総未読件数を先に計算 -----
        $allContacts = Item::whereHas('payments', function ($q) use ($id) {
            $q->where('user_id', $id)
                ->whereDoesntHave('review', fn($q2) => $q2->where('user_id', $id));
        })
            ->orWhereHas('payments', function ($q) use ($id) {
                $q->whereHas('item', function ($q2) use ($id) {
                    $q2->where('user_id', $id);
                })
                    ->whereDoesntHave('review', fn($q2) => $q2->where('user_id', $id));
            })
            ->with(['payments.messages'])
            ->get();


        $total_unread = 0;
        foreach ($allContacts as $item) {
            foreach ($item->payments as $payment) {
                $lastMyMessage = $payment->messages()
                    ->where('user_id', $id)
                    ->orderByDesc('created_at')
                    ->first();

                $lastMyTime = $lastMyMessage ? $lastMyMessage->created_at : null;

                $unreadCount = $payment->messages()
                    ->where('user_id', '!=', $id)
                    ->when($lastMyTime, fn($q) => $q->where('created_at', '>', $lastMyTime))
                    ->count();

                $total_unread += $unreadCount;
            }
        }
        // ---------------------------------------------

        // 'page' に応じて表示する商品を取得
        switch ($page) {
            case 'buy':
                $contacts = Item::whereIn('id', function ($query) use ($id) {
                    $query->select('item_id')
                        ->from('payments')
                        ->where('user_id', $id);
                })
                    ->with(['image', 'payments'])
                    ->get();
                break;
            case 'trade':
                $contacts = $allContacts;
                foreach ($contacts as $item) {
                    // 自分がレビュー済みの payment は除外
                    $filteredPayments = $item->payments->filter(function ($payment) use ($id) {
                        return !$payment->review()->where('user_id', $id)->exists();
                    });

                    $itemUnread = 0;

                    foreach ($filteredPayments as $payment) {
                        $lastMyMessage = $payment->messages()
                            ->where('user_id', $id)
                            ->orderByDesc('created_at')
                            ->first();
                        $lastMyTime = $lastMyMessage ? $lastMyMessage->created_at : null;

                        $unreadCount = $payment->messages()
                            ->where('user_id', '!=', $id)
                            ->when($lastMyTime, fn($q) => $q->where('created_at', '>', $lastMyTime))
                            ->count();

                        $itemUnread += $unreadCount;
                    }

                    $item->unread_count = $itemUnread;
                    // レビュー済みは除外した filteredPayments に置き換える
                    $item->payments = $filteredPayments;
                }
                break;

            default:
                $contacts = Item::where('user_id', $id)
                    ->with(['image', 'payments'])
                    ->paginate(8);
                break;
        }

        if ($contacts->isEmpty()) {
            $contacts = null;
        }

        // 取引中件数
        $tradeCount = $allContacts->count();

        return view('mypage', compact('profiles', 'contacts', 'tradeCount', 'page', 'total_unread', 'averageRating'));
    }


    public function search(Request $request)
    {
        // ログインユーザーID取得
        $id = Auth::id();

        // リクエストから検索パラメータを取得
        $search = $request->input('search');

        // アイテムのクエリビルダーを準備
        $query = Item::with(['image' => function ($query) {
            $query->select('item_id', 'img_url');
        }]);

        // ログインしている場合、user_idが一致するアイテムを除外
        if ($id) {
            $query->where('user_id', '!=', $id);
        }

        // searchパラメータが空でない場合
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        } else {
            // ログインしていない場合はランダム順に並べ替え
            if (!$id) {
                $query->inRandomOrder();
            }
        }

        // アイテムを取得
        $contacts = $query->paginate(8);

        // 結果をビューに渡す
        return view('index', compact('contacts'));
    }

    // プロフィール編集ページを表示する（GETメソッド）
    public function showProfile()
    {
        // ログインユーザーID取得
        $id = Auth::id();

        // 現在のプロフィール情報を取得
        $profiles = User::where('id', $id)
            ->with(['image', 'profile'])
            ->first();

        // プロフィールが存在しない場合は初期データを入れて返す
        $profile = $profiles->profile ?? null;

        // nameは必ずUserから取り出し、デフォルトは空にしない
        return view('profile', compact('profiles', 'profile'));
    }

    // プロフィール情報を更新する（POSTメソッド）
    public function updateProfile(Request $request)
    {
        // ログインユーザーID取得
        $id = Auth::id();

        // バリデーション実行
        $profileRequest = new ProfileRequest();
        $validated = $request->validate($profileRequest->rules());

        // 入力データを取得
        $contact = $request->only(['post_code', 'address', 'building']);
        $name = $request->input('name');
        $image = $request->file('image');

        // 現在のプロフィール情報を取得
        $profile = Profile::where('user_id', $id)->first();
        $user = User::find($id);
        $imageRecord = Image::where('user_id', $id)->first();

        // 初回登録
        if (!$profile) {
            // ユーザー名が変更されていれば、ユーザー情報を更新
            if ($name !== $user->name) {
                $user->update(['name' => $name]);
            }

            // プロフィール作成
            Profile::create([
                'user_id' => $id,
                'post_code' => $contact['post_code'],
                'address' => $contact['address'],
                'building' => $contact['building'] ?? null
            ]);

            $imagePath = $image->store('', 'public');

            // 画像を保存
            $imageRecord = Image::create(
                [
                    'user_id' => $id,
                    'img_url' => $imagePath
                ]
            );
        } else {
            // 既存のプロフィールがある場合は、変更された項目のみ更新
            if ($name !== $user->name) {
                $user->update(['name' => $name]);
            }

            // 住所や建物情報が変更されていれば更新
            if (
                $contact['post_code'] !== $profile->post_code ||
                $contact['address'] !== $profile->address ||
                $contact['building'] !== $profile->building
            ) {
                $profile->update([
                    'post_code' => $contact['post_code'],
                    'address' => $contact['address'],
                    'building' => $contact['building']
                ]);
            }
            if ($image) {
                // 新しい画像を保存
                $imagePath = $image->store('', 'public');

                // 既存の画像を削除（必要に応じて）
                if ($imageRecord) {
                    $imageRecord->delete();
                }

                // 新しい画像レコードを作成
                $imageRecord = Image::create([
                    'user_id' => $id,
                    'img_url' => 'storage/' . $imagePath
                ]);
            }

            // プロフィール情報を取得
            $profiles = User::where('id', $id)
                ->with(['image', 'profile'])
                ->first();

            return redirect()->route('index');
            // 更新後に再度プロファイルページを表示
            //return view('profile', compact('profiles'));
        }
    }

    public function sell(Request $request)
    {
        // ログインユーザーID取得
        $id = Auth::id();

        $categories = Category::all();

        return view('sell', compact('categories'));
    }

    public function createSell(SellRequest $request)
    {
        // ログインユーザーID取得
        $id = Auth::id();

        $categories = Category::all();

        //入力データを取得
        $contact = $request->only(['condition', 'name', 'brand', 'details', 'price']);
        $item_categories = $request->only(['categories']);
        $image = $request->file('image');
        //ファイルの保存
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $imagePath = $image->storeAs('public', $imageName);

        // 新規作成
        $item = Item::create([
            'user_id' => $id,
            'condition' => $contact['condition'],
            'name' => $contact['name'],
            'brand' => $contact['brand'],
            'details' => $contact['details'],
            'price' => $contact['price'],
        ]);

        $imageRecord = Image::create([
            'item_id' => $item->id,
            'img_url' => '/storage/' . $imageName
        ]);

        $categoryIds = $item_categories['categories'];

        // ItemとCategoryを中間テーブルに関連付ける
        $item->categories()->attach($categoryIds);

        return view('sell', compact('categories'));
    }

}