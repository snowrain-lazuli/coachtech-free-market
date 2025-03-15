<?php


namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Favorite;
use App\Models\Profile;
use App\Models\Image;
use App\Models\Category;
use App\Models\Payment;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class ContentsTest extends TestCase
{

    // プロパティとして宣言
    protected $user;
    protected $item;

    public function setUp(): void
    {
        parent::setUp();

        // 外部キー制約を無効化
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        User::truncate();
        Profile::truncate();
        Category::truncate();
        Item::truncate();
        Image::truncate();
        Comment::truncate();
        Payment::truncate();
        Favorite::truncate();

        // seederを実行してデータを作成
        Artisan::call('db:seed');

        // 初期ユーザーとアイテムをシーダーから作成されることを前提にします
        $this->user = User::first();  // シーダーで作成された最初のユーザーを取得
        $this->item = Item::first();  // シーダーで作成された最初のアイテムを取得 

        // ログイン処理
        Auth::login($this->user);
    }

    public function tearDown(): void
    {
        // 外部キー制約を有効化
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        parent::tearDown();
    }

    /** @test */
    public function it_can_redirect_on_post_request_in_index_method()
    {
        $response = $this->post(route('index'), ['page' => null]);

        $response->assertRedirect(route('index', ['page' => null]));
    }

    /** @test */
    public function it_can_display_items_in_index_method()
    {
        $response = $this->get(route('index'));

        $response->assertStatus(200);
        $response->assertViewHas('contacts');
    }

    /** @test */
    public function it_can_toggle_favorite()
    {
        // お気に入り追加
        $response = $this->post(route('item.favorite', ['item_id' => $this->item->id]));
        $response->assertRedirect(route('item', ['item_id' => $this->item->id]));
        $this->assertDatabaseHas('favorites', ['user_id' => $this->user->id, 'item_id' => $this->item->id]);

        // お気に入り削除
        $response = $this->post(route('item.favorite', ['item_id' => $this->item->id]));
        $response->assertRedirect(route('item', ['item_id' => $this->item->id]));
        $this->assertDatabaseMissing('favorites', ['user_id' => $this->user->id, 'item_id' => $this->item->id]);
    }

    /** @test */
    public function it_can_show_item_details_in_item_method()
    {
        $response = $this->get(route('item', ['item_id' => $this->item->id]));

        $response->assertStatus(200);
        $response->assertViewHas('contact');
        $response->assertViewHas('comments');
    }

    /** @test */
    public function it_can_create_comment_on_item()
    {
        $commentData = ['content' => 'Great item!'];

        $response = $this->post(route('item', ['item_id' => $this->item->id]), $commentData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('comments', ['content' => 'Great item!', 'item_id' => $this->item->id, 'user_id' => $this->user->id]);
    }

    /** @test */
    public function it_can_show_mypage_with_items()
    {
        $response = $this->get(route('mypage'));

        $response->assertStatus(200);
        $response->assertViewHas('profiles');
        $response->assertViewHas('contacts');
    }

    /** @test */
    public function it_can_search_items()
    {

        $response = $this->post(route('search', ['item' => $this->item->name]));

        $response->assertStatus(200);
        $response->assertViewHas('contacts');
    }

    /** @test */
    public function it_can_update_profile()
    {
        $profileData = [
            'name' => 'New Name',
            'post_code' => '1234567',
            'address' => 'New Address',
            'building' => 'New Building',
            'image' => UploadedFile::fake()->create('avatar.jpg', 100)
        ];

        // リクエスト送信
        $response = $this->post(route('updateProfile'), $profileData);

        // 保存されたファイルのパスを取得
        $imagePath = 'storage/' . basename($profileData['image']->store('', 'public'));

        // テストのアサーション
        $response->assertRedirect(route('index'));
        $this->assertDatabaseHas('profiles', ['post_code' => '1234567', 'address' => 'New Address']);
        $this->assertDatabaseHas('images', ['img_url' => $imagePath]);
    }




    /** @test */
    public function test_sell_creates_item_and_image_and_attaches_categories()
    {
        // ユーザーがログインしているか確認
        $this->assertAuthenticatedAs($this->user);

        // 既存のカテゴリを取得
        $categories = Category::all();

        // テスト用の画像を準備
        $imageFile = UploadedFile::fake()->create('avatar.jpg', 100); // 偽の画像ファイルを作成

        // ストレージを仮想化
        Storage::fake('public');

        // POSTリクエストのデータを設定
        $data = [
            'condition' => '1',
            'name' => 'Test Item',
            'brand' => 'Test Brand',
            'details' => 'Test details',
            'price' => 1000,
            'categories' => $categories->pluck('id')->toArray(),
            'image' => $imageFile,
        ];

        // リクエストを送信
        $response = $this->post(route('sell'), $data);

        // ステータスコードが 200 であることを確認
        $response->assertStatus(200);

        // 商品が作成されていることを確認
        $item = Item::where('name', 'Test Item')->first();
        $this->assertNotNull($item, 'Item was not created');

        // 画像ファイルの保存
        $imageFileName = $imageFile->getClientOriginalName();
        $imagePath = $imageFile->storeAs('public', $imageFileName); // 仮想ストレージに画像を保存

        // 商品に画像を関連付ける
        $image = Image::create([
            'item_id' => $item->id,
            'img_url' => '/storage/' . $imageFileName, // 画像の保存パス
        ]);

        // 画像がデータベースに保存されていることを確認
        $this->assertDatabaseHas('images', ['img_url' => '/storage/' . $imageFileName]);

        // 商品とカテゴリが関連付けられていることを確認
        foreach ($categories as $category) {
            $this->assertTrue($item->categories->contains($category));
        }
    }



    public function test_sell_shows_categories_page()
    {
        // ユーザーがログインしているか確認
        $this->assertAuthenticatedAs($this->user);

        // 既存のカテゴリを取得
        $categories = Category::all();

        // sellページにアクセス
        $response = $this->get(route('sell'));

        // ステータスコードが 200 であることを確認
        $response->assertStatus(200);

        // カテゴリが表示されていることを確認
        foreach ($categories as $category) {
            $response->assertSee($category->name);
        }
    }





    /** @test */
    public function it_can_purchase_item_in_purchase_method()
    {
        $purchaseData = [
            'post_code' => '1234567',
            'address' => 'User Address',
            'building' => 'User Building',
        ];

        $response = $this->post(route('purchase', ['item_id' => $this->item->id]), $purchaseData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('profiles', ['post_code' => '1234567']);
    }

    /** @test */
    public function it_can_process_payment_in_payment_method()
    {
        $response = $this->post(route('payment', ['item_id' => $this->item->id]));

        $response->assertStatus(200);
        $this->assertDatabaseHas('payments', ['user_id' => $this->user->id, 'item_id' => $this->item->id]);
    }
}