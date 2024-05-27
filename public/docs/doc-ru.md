# Dogger

Вы можете получить доступ к производственной среде [здесь](https://dogger.cloud).

## Как запустить проект

Сначала вам нужно установить все зависимости.

### `npm install`

### `composer install`

Далее скопируйте файл `.env.example` и переименуйте его в `.env`, отредактируйте его с вашей информацией.

После этого настройте базу данных (необходимо создать пустую базу данных перед выполнением этой команды).

### `php artisan migrate:fresh --seed`

Наконец, соберите приложение.

### `npm run dev`

Страница будет перезагружаться при внесении изменений.
Вы также можете увидеть любые ошибки lint в консоли.

Или соберите приложение для продакшена.

### `npm run build`

Запустите сервер (если у вас нет Valet или Herd)

### `php artisan serve`

Откройте [http://localhost:8000](http://localhost:8000), чтобы просмотреть его в вашем браузере.

Если вы используете macOS, вы можете использовать Laravel Valet (или Herd) для локального сервирования вашего приложения с красивым доменным именем (например, http://dogger.test).

Если вы хотите запустить проект с SSR (Server Side Rendering), вам нужно выполнить следующую команду (доступна только после сборки).

### `php artisan inertia:start-ssr`

## Как использовать

Вы можете использовать официальный Dogger SDK или вызывать конечную точку API напрямую из вашего кода.

## Dogger SDK

JavaScript SDK доступен на NPM [здесь](https://www.npmjs.com/package/dogger-sdk) или вы можете добавить его в свой проект через командную строку: `npm i dogger-sdk`

PHP SDK доступен на Packagist [здесь](https://packagist.org/packages/dogger/dogger-sdk) или вы можете добавить его в свой проект через командную строку: `composer require dogger/dogger-sdk`

### Импорт

Чтобы импортировать Dogger в ваш проект, вы можете использовать: `import { init as initDogger } from "dogger-sdk";`

### Инициализация и использование

Чтобы инициализировать Dogger, вам нужно вызвать функцию init:

```js
initDogger({
    url: 'https://my-hosted-application', // если вы хостите приложение, укажите здесь ваш эндпоинт
    key: 'DOGGER-PROJECT-KEY', // сгенерированный секретный ключ проекта
    env: 'developpement', // или: prod | dev | custom-env
    isClient: true  // true или false, указывает, является ли приложение клиентским или серверным
});
```

Параметр `key` указывает, к какому проекту вы хотите привязать ваше рабочее пространство.

После создания проекта в приложении генерируется уникальный ключ проекта. Вы можете скопировать и вставить этот ключ в функцию инициализации.

**Примечание**: рекомендуется разместить ваш секретный ключ в файле .env, чтобы избежать проблем с безопасностью.

Вы также можете указать среду проекта (например, 'dev', 'prod' или custom) в виде строки внутри функции инициализации.

Когда возникает ошибка, она автоматически появляется на вашей панели управления.

### Ручной триггер

Вы также можете вручную вызвать ошибку, используя метод `logErrorToDogger()`:

```js
const doggerInstance = initDogger({
    url: 'https://my-hosted-application',
    key: 'DOGGER-PROJECT-KEY',
    env: 'development',
    isClient: true,
});

// Всегда вызывайте ошибку Dogger
doggerInstance.logErrorToDogger({
    message: 'This is an error',
    status: 500,
    stack: 'Error: This is an error\n    at Object.<anonymous> (/Projects/dogger-sdk/src/index.ts:11:1)\n    at Module._compile (internal/modules/cjs/loader.js:1072:14)\n    at Object.Module._extensions..js (internal/modules/cjs/loader.js:1101:10)\n    at Module.load (internal/modules/cjs/loader.js:937:32)\n    at Function.Module._load (internal/modules/cjs/loader.js:778:12)\n    at Function.executeUserEntryPoint [as runMain] (internal/modules/run_main.js:76:12)\n    at internal/main/run_main_module.js:17:47',
    name: 'Error'
});
```

Это всегда вызовет ошибку Dogger при вызове.

### Метрики производительности

Вы можете использовать Dogger для мониторинга производительности ваших функций.

Вы можете использовать методы `startRecord()` и `stopRecord()`, чтобы начать и завершить запись.

Вам нужно предоставить идентификатор для вашей производительности, вы также можете установить минимальный порог (если время выполнения ниже порога, производительность не будет зафиксирована).

```js
const doggerInstance = initDogger({
    url: 'https://my-hosted-application', // если вы хостите приложение, укажите здесь ваш эндпоинт
    key: 'DOGGER-PROJECT-KEY', // сгенерированный секретный ключ проекта
    env: 'developpement', // или: prod | dev | custom-env
    isClient: true  // true или false, указывает, является ли приложение клиентским или серверным
});

const testPerformance = () => {
    doggerInstance.startRecord('test1');
    doggerInstance.startRecord('test2');
    doggerInstance.startRecord('test3');
    setTimeout(() => {
        doggerInstance.stopRecord('test1', 10000); // это будет проигнорировано из-за порога
        doggerInstance.stopRecord('test2', 3000);
    }, 5000);
    doggerInstance.stopRecord('test3');
};

testPerformance();
```