# Dogger

Sie können auf die Produktionsumgebung [hier](https://dogger.cloud) zugreifen.

## So führen Sie das Projekt aus

Zuerst müssen Sie alle Abhängigkeiten installieren.

### `npm install`

### `composer install`

Kopieren Sie als nächstes die Datei `.env.example` und benennen Sie sie in `.env` um, bearbeiten Sie sie mit Ihren Informationen.

Richten Sie danach die Datenbank ein (Sie müssen eine leere Datenbank erstellen, bevor Sie diesen Befehl ausführen).

### `php artisan migrate:fresh --seed`

Bauen Sie schließlich die Anwendung.

### `npm run dev`

Die Seite wird neu geladen, wenn Sie Änderungen vornehmen.
Sie können auch alle Lint-Fehler in der Konsole sehen.

Oder bauen Sie die Anwendung für die Produktion.

### `npm run build`

Starten Sie den Server (falls Sie Valet oder Herd nicht haben).

### `php artisan serve`

Öffnen Sie [http://localhost:8000](http://localhost:8000), um es in Ihrem Browser zu sehen.

Wenn Sie macOS verwenden, können Sie Laravel Valet (oder Herd) verwenden, um Ihre Anwendung lokal mit einem schönen Domainnamen (z. B. http://dogger.test) bereitzustellen.

Wenn Sie das Projekt mit SSR (Server Side Rendering) ausführen möchten, müssen Sie den folgenden Befehl ausführen (nur nach einem Build verfügbar).

### `php artisan inertia:start-ssr`

## So verwenden Sie

Sie können entweder das offizielle Dogger SDK verwenden oder den API-Endpunkt direkt aus Ihrem Code aufrufen.

## Dogger SDK

Das JavaScript SDK ist auf NPM [hier](https://www.npmjs.com/package/dogger-sdk) verfügbar, oder Sie können es über die Befehlszeile zu Ihrem Projekt hinzufügen: `npm i dogger-sdk`

Das PHP SDK ist auf Packagist [hier](https://packagist.org/packages/dogger/dogger-sdk) verfügbar, oder Sie können es über die Befehlszeile zu Ihrem Projekt hinzufügen: `composer require dogger/dogger-sdk`

### Importieren

Um Dogger in Ihr Projekt zu importieren, können Sie verwenden: `import { init as initDogger } from "dogger-sdk";`

### Initialisierung und Verwendung

Um Dogger zu initialisieren, müssen Sie die init-Funktion aufrufen:

```js
initDogger({
    url: 'https://my-hosted-application', // Wenn Sie die Anwendung hosten, geben Sie hier Ihren Endpunkt an
    key: 'DOGGER-PROJECT-KEY', // Generierter geheimer Projektschlüssel
    env: 'developpement', // oder: prod | dev | custom-env
    isClient: true  // true oder false, gibt an, ob die Anwendung client- oder serverseitig ist
});
```

Der Parameter `key` gibt an, mit welchem Projekt Sie Ihren Arbeitsbereich verknüpfen möchten.

Nachdem Sie das Projekt in der App erstellt haben, wird ein eindeutiger Projektschlüssel generiert. Sie können den Schlüssel in die init-Funktion kopieren und einfügen.

**Hinweis**: Es wird empfohlen, Ihren geheimen Schlüssel in einer .env-Datei zu platzieren, um Sicherheitsprobleme zu vermeiden.

Sie können auch die Umgebung des Projekts (z. B. 'dev', 'prod' oder benutzerdefiniert) als Zeichenfolge in der init-Funktion angeben.

Wenn ein Fehler auftritt, wird er automatisch in Ihrem Dashboard angezeigt.

### Manuelles Auslösen

Sie können auch einen manuellen Fehler mit der Methode `logErrorToDogger()` auslösen:

```js
const doggerInstance = initDogger({
    url: 'https://my-hosted-application',
    key: 'DOGGER-PROJECT-KEY',
    env: 'development',
    isClient: true,
});

// Immer einen Dogger-Fehler auslösen
doggerInstance.logErrorToDogger({
    message: 'This is an error',
    status: 500,
    stack: 'Error: This is an error\n    at Object.<anonymous> (/Projects/dogger-sdk/src/index.ts:11:1)\n    at Module._compile (internal/modules/cjs/loader.js:1072:14)\n    at Object.Module._extensions..js (internal/modules/cjs/loader.js:1101:10)\n    at Module.load (internal/modules/cjs/loader.js:937:32)\n    at Function.Module._load (internal/modules/cjs/loader.js:778:12)\n    at Function.executeUserEntryPoint [as runMain] (internal/modules/run_main.js:76:12)\n    at internal/main/run_main_module.js:17:47',
    name: 'Error'
});
```

Dies wird immer einen Dogger-Fehler auslösen, wenn es aufgerufen wird.

### Leistungsmetriken

Sie können die Leistung Ihrer Funktionen mit Dogger überwachen.

Sie können die Methoden `startRecord()` und `stopRecord()` verwenden, um eine Aufzeichnung zu starten und zu beenden.

Sie müssen Ihrer Leistung eine Kennung geben und können auch einen minimalen Schwellenwert festlegen (die Leistung wird nicht ausgelöst, wenn die Zeit unter dem Schwellenwert liegt).

```js
const doggerInstance = initDogger({
    url: 'https://my-hosted-application', // Wenn Sie die Anwendung hosten, geben Sie hier Ihren Endpunkt an
    key: 'DOGGER-PROJECT-KEY', // Generierter geheimer Projektschlüssel
    env: 'developpement', // oder: prod | dev | custom-env
    isClient: true  // true oder false, gibt an, ob die Anwendung client- oder serverseitig ist
});

const testPerformance = () => {
    doggerInstance.startRecord('test1');
    doggerInstance.startRecord('test2');
    doggerInstance.startRecord('test3');
    setTimeout(() => {
        doggerInstance.stopRecord('test1', 10000); // Dies wird aufgrund des Schwellenwerts ignoriert
        doggerInstance.stopRecord('test2', 3000);
    }, 5000);
    doggerInstance.stopRecord('test3');
};

testPerformance();
```