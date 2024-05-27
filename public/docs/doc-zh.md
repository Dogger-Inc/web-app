# Dogger

你可以在[这里](https://dogger.cloud)访问生产环境。

## 如何运行项目

首先你需要安装所有依赖。

### `npm install`

### `composer install`

接下来复制`.env.example`文件并重命名为`.env`，用你的信息编辑它们。

然后设置数据库（在运行此命令之前需要创建一个空的数据库）。

### `php artisan migrate:fresh --seed`

最后构建应用。

### `npm run dev`

当你进行更改时，页面会重新加载。
你也可以在控制台中看到任何lint错误。

或者为生产环境构建应用。

### `npm run build`

运行服务器（如果你没有Valet或Herd）

### `php artisan serve`

打开[http://localhost:8000](http://localhost:8000)在浏览器中查看。

如果你在macOS上，可以使用Laravel Valet（或Herd）在本地用一个漂亮的域名（如http://dogger.test）来服务你的应用。

如果你想用SSR（服务器端渲染）运行项目，你需要运行以下命令（仅在构建后可用）。

### `php artisan inertia:start-ssr`

## 如何使用

你可以使用官方的Dogger SDK或者直接从你的代码库调用API端点。

## Dogger SDK

JavaScript SDK可在NPM上获取[这里](https://www.npmjs.com/package/dogger-sdk)或者你可以通过命令行将其添加到你的项目中：`npm i dogger-sdk`

PHP SDK可在Packagist上获取[这里](https://packagist.org/packages/dogger/dogger-sdk)或者你可以通过命令行将其添加到你的项目中：`composer require dogger/dogger-sdk`

### 导入

要在你的项目中导入Dogger，可以使用：`import { init as initDogger } from "dogger-sdk";`

### 初始化和使用

要初始化Dogger，你需要调用init函数：
```js
initDogger({
    url: 'https://my-hosted-application', // 如果你托管了应用程序，在此处指明你的端点
    key: 'DOGGER-PROJECT-KEY', // 生成的秘密项目密钥
    env: 'developpement', // 或者：prod | dev | custom-env
    isClient: true  // true 或 false，指示应用程序是客户端还是服务器端
});
```

`key`参数指示你想将工作区链接到哪个项目。

在应用上创建项目后，会生成一个唯一的项目密钥。你可以在init函数中复制粘贴该密钥。

**注意**：建议将你的秘密密钥放在.env文件中以避免安全问题。

你还可以在init函数中指定项目的环境（例如'dev'，'prod'或自定义）。

当出现错误时，它会自动出现在你的仪表板上。

### 手动触发

你也可以使用`logErrorToDogger()`方法手动触发错误：

```js
const doggerInstance = initDogger({
    url: 'https://my-hosted-application',
    key: 'DOGGER-PROJECT-KEY',
    env: 'development',
    isClient: true,
});


// 总是触发Dogger错误
doggerInstance.logErrorToDogger({
    message: 'This is an error',
    status: 500,
    stack: 'Error: This is an error\n    at Object.<anonymous> (/Projects/dogger-sdk/src/index.ts:11:1)\n    at Module._compile (internal/modules/cjs/loader.js:1072:14)\n    at Object.Module._extensions..js (internal/modules/cjs/loader.js:1101:10)\n    at Module.load (internal/modules/cjs/loader.js:937:32)\n    at Function.Module._load (internal/modules/cjs/loader.js:778:12)\n    at Function.executeUserEntryPoint [as runMain] (internal/modules/run_main.js:76:12)\n    at internal/main/run_main_module.js:17:47',
    name: 'Error'
});
```

这将总是在调用时触发Dogger错误。

### 性能指标

你可以使用Dogger监控你的函数性能。

你可以使用`startRecord()`和`stopRecord()`方法来开始和结束记录。

你需要为你的性能提供一个标识符，你也可以设置一个最小阈值（如果时间低于阈值，性能将不会触发）。

```js
const doggerInstance = initDogger({
    url: 'https://my-hosted-application', // 如果你托管了应用程序，在此处指明你的端点
    key: 'DOGGER-PROJECT-KEY', // 生成的秘密项目密钥
    env: 'developpement', // 或者：prod | dev | custom-env
    isClient: true  // true 或 false，指示应用程序是客户端还是服务器端
});

const testPerformance = () => {
    doggerInstance.startRecord('test1');
    doggerInstance.startRecord('test2');
    doggerInstance.startRecord('test3');
    setTimeout(() => {
        doggerInstance.stopRecord('test1', 10000); // 由于阈值，这将被忽略
        doggerInstance.stopRecord('test2', 3000);
    }, 5000);
    doggerInstance.stopRecord('test3');
};

testPerformance();
```