# Review Rating App

Laravelで開発したレビュー・評価アプリです。

ユーザーが登録された投稿（商品・サービスなど）に対して、星による評価とコメント付きのレビューを投稿できるアプリケーションです。

## 機能

- ユーザー登録・ログイン
- プロフィール編集
- プロフィール画像の変更・削除
- レビュー対象の一覧表示
- レビュー詳細・評価の表示
- レビュー投稿
- 星による評価（1〜5）
- 自分のレビューの編集・削除
- レビュー一覧のページネーション
- 管理者機能
- ユーザー管理
- レビュー管理

## 使用技術

- PHP 8.4
- Laravel 12
- MariaDB / MySQL
- Blade
- Bootstrap
- JavaScript / jQuery
- Composer
- Vite

## 環境構築

### 1. リポジトリをクローン

```bash
git clone https://github.com/shirolog/lara11-review-rating.git
cd lara11-review-rating
```

### 2. Composerパッケージをインストール

```bash
composer install
```

### 3. 環境設定ファイルを作成

```bash
cp .env.example .env
```

### 4. アプリケーションキーを生成

```bash
php artisan key:generate
```

### 5. データベースを作成・設定

`.env` のデータベース設定を自分の環境に合わせて変更してください。

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=review-rating
DB_USERNAME=root
DB_PASSWORD=
```

※ MariaDBを使用する場合も、通常は `DB_CONNECTION=mysql` の設定で接続できます。

### 6. マイグレーションを実行

```bash
php artisan migrate
```

### 7. レビュー対象の初期データを登録

```bash
php artisan db:seed --class=PostSeeder
```

`PostSeeder` では、レビュー対象となる投稿のタイトルと画像を登録します。

### 8. フロントエンドの依存パッケージをインストール

```bash
npm install
```

### 9. 開発サーバーを起動

```bash
npm run dev
```

別のターミナルでLaravelの開発サーバーを起動します。

```bash
php artisan serve
```

ブラウザで以下にアクセスします。

```text
http://127.0.0.1:8000
```

## 注意事項

- このアプリはローカル開発環境を想定しています。
- `.env` などの環境依存ファイルはGitHubには含めていません。
- データベースの接続情報は各自の環境に合わせて設定してください。
- `PostSeeder` の実行後、レビュー対象の初期データが登録されます。