# coachtech フリマアプリ

## 環境構築
**Dockerビルド**
1. `git clone git@github.com:snowrain-lazuli/coachtech-free-market.git`
2. DockerDesktopアプリを立ち上げる
3. `docker-compose up -d --build`

> *MacのM1・M2チップのPCの場合、`no matching manifest for linux/arm64/v8 in the manifest list entries`のメッセージが表示されビルドができないことがあります。
エラーが発生する場合は、docker-compose.ymlファイルの「mysql」内に「platform」の項目を追加で記載してください*
``` bash
mysql:
    platform: linux/x86_64(この文追加)
    image: mysql:9.0.1
    environment:
```

**Laravel環境構築**
1. `docker-compose exec php bash`
2. `composer install`
3. 「.env.example」ファイルを 「.env」ファイルに命名を変更。または、新しく.envファイルを作成
4. .envに以下の環境変数を追加
``` text
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass

STRIPE_KEY=
STRIPE_SECRET=
```

5. アプリケーションキーの作成
``` bash
php artisan key:generate
```

6. 管理用のStripeの作成・ログイン
- ログインURL：https://dashboard.stripe.com/login
- 登録URL：https://dashboard.stripe.com/register

7. APIキーの確認
- 確認用URL：https://dashboard.stripe.com/test/apikeys
- 公開可能キーを4で記載したSTRIPE_KEY=に、
- シークレットキーを4で記載したSTRIPE_SECRET=に記載する

8. マイグレーションの実行
``` bash
php artisan migrate
```

9. シーディングの実行
``` bash
php artisan db:seed
```

## 使用技術(実行環境)
- PHP8.4.2
- Laravel8.83.29
- MySQL9.0.1
- Node.js18.20.6
- stripe

## ER図
![alt](erd.png)

## URL
- 開発環境：http://localhost/
- phpMyAdmin:：http://localhost:8080/
