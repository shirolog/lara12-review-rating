# Review Rating App

Laravelで開発したレビュー・評価アプリです。

ユーザーが商品やサービスに対してレビューを投稿し、評価を登録できるアプリケーションです。

## 機能

* ユーザー登録・ログイン
* レビュー投稿
* レビュー編集・削除
* 星による評価
* レビュー一覧表示
* ページネーション
* 管理者機能
* ユーザー管理
* レビュー管理

## 使用技術

* PHP 8.2
* Laravel 11
* MySQL
* Blade
* Bootstrap
* JavaScript / jQuery
* XAMPP

## 環境構築

```bash
git clone https://github.com/shirolog/lara11-review-rating.git
cd lara11-review-rating

composer install

cp .env.example .env

php artisan key:generate

php artisan migrate

php artisan serve
```

ブラウザで以下にアクセスします。

```text
http://127.0.0.1:8000
```

## データベース

`.env` のデータベース設定を、自分の環境に合わせて変更してください。

```env
DB_DATABASE=review-rating
DB_USERNAME=root
DB_PASSWORD=
```

## 注意事項

このアプリはローカル開発環境を想定しています。

`.env` ファイルなどの環境依存ファイルはGitHubには含めていません。
