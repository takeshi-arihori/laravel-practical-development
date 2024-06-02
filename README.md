## ディレクトリ構成

```
.
├── README.md
├── infra
│   ├── mysql
│   │   ├── Dockerfile
│   │   └── my.cnf
│   ├── nginx
│   │   └── default.conf
│   └── php
│       ├── Dockerfile
│       └── php.ini
├── docker-compose.yml
└── src
    └── Laravelをインストールするディレクトリ

```

## 参考

- (【超入門】20 分で Laravel 開発環境を爆速構築する Docker ハンズオン)[https://qiita.com/ucan-lab/items/56c9dc3cf2e6762672f4]
- (最強の Laravel 開発環境を Docker を使って構築する)[https://qiita.com/ucan-lab/items/5fc1281cd8076c8ac9f4]

## git clone 後のプロジェクト新規作成

## Laravel インストール

- app コンテナに入ります。

```
docker compose exec app bash
```

- 書き込み権限がないとキャッシュやログにエラーを書き込めないので、権限を付与しておきます。

```
chmod -R 777 storage bootstrap/cache
```

- vendor ディレクトリへライブラリ群をインストールします。
  composer.lock ファイルを参照します。

```
composer install
```

- 画面を開いて確認します。

```
http://localhost:8080
```

- 500 SERVER ERROR -> ログファイルを見てエラーを確認します。

```
cat storage/logs/laravel.log
```

- .env ファイルを作成します。

```
cp .env.example .env
```

- アプリケーションキーを生成します。

```
php artisan key:generate
```

- public/storage から storage/app/public へのシンボリックリンクを張ります。

```
php artisan storage:link
```

- 最後にマイグレーションを実行して適用されれば OK です。

```
php artisan migrate
```

- エラー対応

```
Illuminate\Database\QueryException
SQLSTATE[HY000] [2002] php_network_getaddresses: getaddrinfo for db failed: Name or service not known
```

このエラーが発生した場合は my.cnf を作成する前に docker compose up -d でビルドしてしまった可能性が高いです。
設定ファイルがない状態で MySQL の初期化が行われたでデータが永続化されてしまってるので一度ボリューム毎削除してビルドし直す。

```
docker compose down --volumes --rmi all
docker compose up -d --build
```
