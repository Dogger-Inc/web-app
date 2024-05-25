#  Dogger

  

You can access to the production [here](https://dogger.cloud).

  

##  How to run the project

  

First you need to install all depedancies.

  

###  `npm install`

###  `composer install`

  

Next copy the '.env.example' file and rename it to '.env', edit them with your informations.

After setup the database (you need to create an empty database before run this command).

  

###  `php artisan migrate:fresh --seed`

  

Finally build the app.

  

###  `npm run dev`

  

The page will reload when you make changes.\

You may also see any lint errors in the console.

  

or build the app for production.

  

###  `npm run build`

  

Run the server (if you don't have Valet or Herd)

  

###  `php artisan serve`

  

Open [http://localhost:8000](http://localhost:8000) to view it in your browser.

If you're on macOS you can use Laravel Valet (or Herd) to serve your app locally with a pretty domain name (like http://dogger.test).

  

If you wan't to run the project with SSR (Server Side Rendering) you need to run the following command (available only after a build).

  

###  `php artisan inertia:start-ssr`

  

##  How to use

  

You can either use the official Dogger SDK or call the API endpoint directly from your codebase.

  

##  Dogger SDK

The JavaScript SDK is available on NPN [here](https://www.npmjs.com/package/dogger-sdk) or you can add it to your project via the command line: `npm i dogger-sdk`

The php  SDK is available on Packagist [here](https://packagist.org/packages/dogger/dogger-sdk) or you can add it to your project via the command line: `composer require dogger/dogger-sdk`

  

###  Import

To import dogger in your project you can use: `import { init as initDogger } from "dogger-sdk";`

###  Initialisation and usage

To initialise Dogger, you need to call the init function:

```js

initDogger({
	url: 'https://my-hosted-application', // if you host the application, indicate your endpoint here 
	key: 'DOGGER-PROJECT-KEY', // generated secret project key
	env: 'developpement', // or: prod | dev | custom-env
	isClient: true  // true or false, indicates if the application is client or server side
});

```

The key parameter indicates which project you want to link your workspace to.

After you create the project on the app, a uniuqe project key is generated. You can copy-paste the key in the init function.

**Note**: it is recommended to place your secret key in a .env file to avoid security issues.

  
You can also specify the project's environment (eg. 'dev', 'prod' or custom) as a string inside the init function.

When an error occurs, it will appear automatically in your dashboard.

### Manual Trigger

You can also trigger a manual error using the ``logErrorToDogger()`` method:
```js
    const doggerInstance = initDogger({
      url: 'https://my-hosted-application',
      key: 'DOGGER-PROJECT-KEY',
      env: 'development',
      isClient: true,
    });

    // Always trigger a Dogger error 
    doggerInstance.logErrorToDogger({
      message: 'This is an error',
      status: 500,
      stack: 'Error: This is an error\n    at Object.<anonymous> (/Projects/dogger-sdk/src/index.ts:11:1)\n    at Module._compile (internal/modules/cjs/loader.js:1072:14)\n    at Object.Module._extensions..js (internal/modules/cjs/loader.js:1101:10)\n    at Module.load (internal/modules/cjs/loader.js:937:32)\n    at Function.Module._load (internal/modules/cjs/loader.js:778:12)\n    at Function.executeUserEntryPoint [as runMain] (internal/modules/run_main.js:76:12)\n    at internal/main/run_main_module.js:17:47',
      name: 'Error'
    });
  ```

This will always trigger a Dogger error when called

###  Performance metrics
You can monitor the performance of your functions with Dogger.

You can employ the ``startRecord()`` and ``stopRecord()`` methods to start and and a recording.

You need to provide an identifier you your performance an you can also set a minimum treshold (the performance will not trigger it the time elapsed is below the treshold)

   ```js
 const doggerInstance = initDogger({
   url: 'https://my-hosted-application', // if you host the application, indicate your endpoint here 
   key: 'DOGGER-PROJECT-KEY', // generated secret project key
   env: 'developpement', // or: prod | dev | custom-env
   isClient: true  // true or false, indicates if the application is client or server side
 });

    const testPerformance = () => {
      doggerInstance.startRecord('test1');
      doggerInstance.startRecord('test2');
      doggerInstance.startRecord('test3');
      setTimeout(() => {
        doggerInstance.stopRecord('test1', 10000); // this will be ignored due to the treshold
        doggerInstance.stopRecord('test2', 3000);
      }, 5000);
      doggerInstance.stopRecord('test3');
    };

    testPerformance();
```
