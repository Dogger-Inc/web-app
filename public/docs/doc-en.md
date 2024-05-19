# Dogger

You can access to the production here [https://dogger.cloud](https://dogger.cloud).

## How to run the project

First you need to install all depedancies.

### `npm install`
### `composer install`

Next copy the '.env.example' file and rename it to '.env', edit them with your informations.
After setup the database (you need to create an empty database before run this command).

### `php artisan migrate:fresh --seed`

Finally build the app.

### `npm run dev`

The page will reload when you make changes.\
You may also see any lint errors in the console.

or build the app for production.

### `npm run build`

Run the server (if you don't have Valet or Herd)

### `php artisan serve`

Open [http://localhost:8000](http://localhost:8000) to view it in your browser.
If you're on macOS you can use Laravel Valet (or Herd) to serve your app locally with a pretty domain name (like http://dogger.test).

If you wan't to run the project with SSR (Server Side Rendering) you need to run the following command (available only after a build).

### `php artisan inertia:start-ssr`

## How to use

You can either use the official Dogger SDK or call the API endpoint directly from your codebase.

## Dogger SDK
The SDK is availible on NPN [here](https://www.npmjs.com/package/dogger-sdk) or you can add it to your project via the command line:  `npm i dogger-sdk`

### Import
To import dogger in your project you can use: `import { init as initDogger } from "dogger-sdk";`
### Initialisation and usage
To initialise Dogger, you need to call the init function:
```js
initDogger({
    key: "DOGGER-PROJECT-KEY",
    'env' => 'dev' // or: prod | dev | custom-env
});
```
The key parameter indicates which project you want to link your workspace to. 
After you create the project on the app, a uniuqe project key is generated. You can copy-paste the key in the init function.
**Note**: it is recommended to place your secret key in a .env file to avoid security issues. 

You can also specify the project's environment (eg. 'dev', 'prod' or custom) as a string inside the init  function.

When an error occurs, it will appear automatically in your dashboard.
