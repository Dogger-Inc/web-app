# Dogger

Vous pouvez accéder à la production [ici](https://dogger.cloud).

## Comment exécuter le projet

D'abord, vous devez installer toutes les dépendances.

### `npm install`

### `composer install`

Ensuite, copiez le fichier '.env.example' et renommez-le en '.env', modifiez-le avec vos informations.

Après avoir configuré la base de données (vous devez créer une base de données vide avant d'exécuter cette commande).

### `php artisan migrate:fresh --seed`

Enfin, construisez l'application.

### `npm run dev`

La page se rechargera lorsque vous ferez des modifications.
Vous pouvez également voir les erreurs de lint dans la console.

ou construisez l'application pour la production.

### `npm run build`

Exécutez le serveur (si vous n'avez pas Valet ou Herd)

### `php artisan serve`

Ouvrez [http://localhost:8000](http://localhost:8000) pour le voir dans votre navigateur.

Si vous êtes sur macOS, vous pouvez utiliser Laravel Valet (ou Herd) pour servir votre application localement avec un joli nom de domaine (comme http://dogger.test).

Si vous voulez exécuter le projet avec SSR (Server Side Rendering), vous devez exécuter la commande suivante (disponible uniquement après une construction).

### `php artisan inertia:start-ssr`

## Comment utiliser

Vous pouvez soit utiliser le SDK officiel de Dogger, soit appeler directement le point de terminaison de l'API depuis votre base de code.

## SDK Dogger

Le SDK JavaScript est disponible sur NPN [ici](https://www.npmjs.com/package/dogger-sdk) ou vous pouvez l'ajouter à votre projet via la ligne de commande : `npm i dogger-sdk`

Le SDK php est disponible sur Packagist [ici](https://packagist.org/packages/dogger/dogger-sdk) ou vous pouvez l'ajouter à votre projet via la ligne de commande : `composer require dogger/dogger-sdk`

### Importation

Pour importer dogger dans votre projet, vous pouvez utiliser : `import { init as initDogger } from "dogger-sdk";`

### Initialisation et utilisation

Pour initialiser Dogger, vous devez appeler la fonction init :

```js
initDogger({
    url: 'https://my-hosted-application', // si vous hébergez l'application, indiquez votre point de terminaison ici
    key: 'DOGGER-PROJECT-KEY', // clé de projet secrète générée
    env: 'developpement', // ou : prod | dev | custom-env
    isClient: true  // true ou false, indique si l'application est côté client ou côté serveur
});
```

Le paramètre key indique à quel projet vous voulez lier votre espace de travail.

Après avoir créé le projet sur l'application, une clé de projet unique est générée. Vous pouvez copier-coller la clé dans la fonction init.

**Note** : il est recommandé de placer votre clé secrète dans un fichier .env pour éviter les problèmes de sécurité.

Vous pouvez également spécifier l'environnement du projet (par exemple, 'dev', 'prod' ou personnalisé) sous forme de chaîne à l'intérieur de la fonction init.

Lorsqu'une erreur se produit, elle apparaîtra automatiquement dans votre tableau de bord.

### Déclenchement manuel

Vous pouvez également déclencher une erreur manuelle en utilisant la méthode ``logErrorToDogger()`` :
```js
    const doggerInstance = initDogger({
      url: 'https://my-hosted-application',
      key: 'DOGGER-PROJECT-KEY',
      env: 'development',
      isClient: true,
    });

    // Toujours déclencher une erreur Dogger
    doggerInstance.logErrorToDogger({
      message: 'Ceci est une erreur',
      status: 500,
      stack: 'Error: Ceci est une erreur\n    at Object.<anonymous> (/Projects/dogger-sdk/src/index.ts:11:1)\n    at Module._compile (internal/modules/cjs/loader.js:1072:14)\n    at Object.Module._extensions..js (internal/modules/cjs/loader.js:1101:10)\n    at Module.load (internal/modules/cjs/loader.js:937:32)\n    at Function.Module._load (internal/modules/cjs/loader.js:778:12)\n    at Function.executeUserEntryPoint [as runMain] (internal/modules/run_main.js:76:12)\n    at internal/main/run_main_module.js:17:47',
      name: 'Error'
    });
  ```

Cela déclenchera toujours une erreur Dogger lorsqu'il est appelé

### Mesures de performance
Vous pouvez surveiller la performance de vos fonctions avec Dogger.

Vous pouvez utiliser les méthodes ``startRecord()`` et ``stopRecord()`` pour commencer et arrêter un enregistrement.

Vous devez fournir un identifiant à votre performance et vous pouvez également définir un seuil minimum (la performance ne se déclenchera pas si le temps écoulé est inférieur au seuil)

   ```js
 const doggerInstance = initDogger({
   url: 'https://my-hosted-application', // si vous hébergez l'application, indiquez votre point de terminaison ici
   key: 'DOGGER-PROJECT-KEY', // clé de projet secrète générée
   env: 'developpement', // ou : prod | dev | custom-env
   isClient: true  // true ou false, indique si l'application est côté client ou côté serveur
 });

    const testPerformance = () => {
      doggerInstance.startRecord('test1');
      doggerInstance.startRecord('test2');
      doggerInstance.startRecord('test3');
      setTimeout(() => {
        doggerInstance.stopRecord('test1', 10000); // ceci sera ignoré à cause du seuil
        doggerInstance.stopRecord('test2', 3000);
      }, 5000);
      doggerInstance.stopRecord('test3');
    };

    testPerformance();
```