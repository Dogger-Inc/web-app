# Dogger

School project with [Vue 3](https://vuejs.org/), [Laravel 10](https://laravel.com/) and [Inertia.js](https://inertiajs.com/).

You can access to the production here [https://dogger.host](https://dogger.host).

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
