# Dogger

製品版は[こちら](https://dogger.cloud)からアクセスできます。

## プロジェクトの実行方法

まず、すべての依存関係をインストールする必要があります。

### `npm install`

### `composer install`

次に、'.env.example' ファイルをコピーして '.env' に名前を変更し、あなたの情報で編集します。

データベースの設定を行った後（このコマンドを実行する前に空のデータベースを作成する必要があります）。

### `php artisan migrate:fresh --seed`

最後に、アプリをビルドします。

### `npm run dev`

変更を加えるとページがリロードされます。

また、コンソールで lint エラーを確認することもできます。

または、アプリを本番用にビルドします。

### `npm run build`

サーバーを起動します（Valet や Herd がない場合）。

### `php artisan serve`

ブラウザで [http://localhost:8000](http://localhost:8000) を開きます。

macOS を使用している場合は、Laravel Valet（または Herd）を使用して、ローカルでアプリを提供し、プリティなドメイン名（例：http://dogger.test）で表示できます。

プロジェクトを SSR（Server Side Rendering）で実行したい場合は、次のコマンドを実行する必要があります（ビルド後のみ利用可能）。

### `php artisan inertia:start-ssr`

## 使い方

公式の Dogger SDK を使用するか、あなたのコードベースから直接 API エンドポイントを呼び出すことができます。

## Dogger SDK

JavaScript SDK は NPN の[こちら](https://www.npmjs.com/package/dogger-sdk)から利用できます。または、コマンドラインからプロジェクトに追加することもできます：`npm i dogger-sdk`

php SDK は Packagist の[こちら](https://packagist.org/packages/dogger/dogger-sdk)から利用できます。または、コマンドラインからプロジェクトに追加することもできます：`composer require dogger/dogger-sdk`

### インポート

プロジェクトに dogger をインポートするには、次のように使用します：`import { init as initDogger } from "dogger-sdk";`

### 初期化と使用

Dogger を初期化するには、init 関数を呼び出す必要があります：

```js
initDogger({
    url: 'https://my-hosted-application', // アプリケーションをホストしている場合は、ここにエンドポイントを指定します
    key: 'DOGGER-PROJECT-KEY', // 生成された秘密のプロジェクトキー
    env: '開発', // または：prod | dev | custom-env
    isClient: true  // true または false、アプリケーションがクライアント側かサーバー側かを示します
});
```

key パラメータは、ワークスペースをリンクしたいプロジェクトを指定します。

アプリ上でプロジェクトを作成した後、ユニークなプロジェクトキーが生成されます。このキーを init 関数にコピーペーストできます。

**注**：セキュリティ上の問題を避けるため、秘密キーは .env ファイルに配置することを推奨します。

また、init 関数内でプロジェクトの環境（例：'dev'、'prod'、カスタム）を文字列として指定することもできます。

エラーが発生すると、ダッシュボードに自動的に表示されます。

### 手動トリガー

また、``logErrorToDogger()`` メソッドを使用して手動でエラーをトリガーすることもできます：
```js
    const doggerInstance = initDogger({
      url: 'https://my-hosted-application',
      key: 'DOGGER-PROJECT-KEY',
      env: 'development',
      isClient: true,
    });

    // 常に Dogger エラーをトリガーします
    doggerInstance.logErrorToDogger({
      message: 'これはエラーです',
      status: 500,
      stack: 'Error: これはエラーです\n    at Object.<anonymous> (/Projects/dogger-sdk/src/index.ts:11:1)\n    at Module._compile (internal/modules/cjs/loader.js:1072:14)\n    at Object.Module._extensions..js (internal/modules/cjs/loader.js:1101:10)\n    at Module.load (internal/modules/cjs/loader.js:937:32)\n    at Function.Module._load (internal/modules/cjs/loader.js:778:12)\n    at Function.executeUserEntryPoint [as runMain] (internal/modules/run_main.js:76:12)\n    at internal/main/run_main_module.js:17:47',
      name: 'Error'
    });
  ```

これは、呼び出されると常に Dogger エラーをトリガーします

### パフォーマンスメトリクス
Dogger を使用して、関数のパフォーマンスを監視することができます。

``startRecord()`` と ``stopRecord()`` メソッドを使用して、レコーディングを開始し終了することができます。

パフォーマンスに識別子を提供する必要があります。また、最小の閾値を設定することもできます（経過時間が閾値以下の場合、パフォーマンスはトリガーされません）

   ```js
 const doggerInstance = initDogger({
   url: 'https://my-hosted-application', // アプリケーションをホストしている場合は、ここにエンドポイントを指定します
   key: 'DOGGER-PROJECT-KEY', // 生成された秘密のプロジェクトキー
   env: '開発', // または：prod | dev | custom-env
   isClient: true  // true または false、アプリケーションがクライアント側かサーバー側かを示します
 });

    const testPerformance = () => {
      doggerInstance.startRecord('test1');
      doggerInstance.startRecord('test2');
      doggerInstance.startRecord('test3');
      setTimeout(() => {
        doggerInstance.stopRecord('test1', 10000); // これは閾値のため無視されます
        doggerInstance.stopRecord('test2', 3000);
      }, 5000);
      doggerInstance.stopRecord('test3');
    };

    testPerformance();
```