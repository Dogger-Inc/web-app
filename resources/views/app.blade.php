<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Open Graph (OG) -->
        {{-- <meta property="og:type" content="website">
        <meta property="og:url" content="">
        <meta property="og:image" content="">
        <meta property="og:image:type" content="image/png" />
        <meta property="og:image:width" content="1200" />
        <meta property="og:image:height" content="630" />
        <meta property="og:image:alt" content="Dogger logo" />
        <meta property="og:locale" content="fr_FR" />
        <meta property="og:site_name" content="Dogger" /> --}}

        <!-- Twitter -->
        {{-- <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="">
        <meta name="twitter:image:src" content=""> --}}

        <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png">
        <link rel="manifest" crossorigin="use-credentials" href="/favicons/site.webmanifest">
        <link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#100b09">
        <link rel="shortcut icon" href="/favicons/favicon.ico">
        <meta name="msapplication-TileColor" content="#100b09">
        <meta name="msapplication-config" content="/favicons/browserconfig.xml">
        <meta name="theme-color" content="#100b09">
        <meta name="author" content="Dogger">
        <meta name="robots" content="index, follow">
        <meta http-equiv="content-language" content="fr-FR">

        <!-- Other meta tag is available in Layouts for dymanic purpose -->

        <!-- Scripts -->
        @vite(['resources/js/app.js'])
        @inertiaHead

        @if(config('app.debug') === false)
            <script>
                if ('serviceWorker' in navigator) {
                    window.addEventListener('load', () => {
                        navigator.serviceWorker.register('/sw.js');
                            // .then(registration => {
                            //     console.log('Service worker registered:', registration);
                            // })
                            // .catch(error => {
                            //     console.error('Service worker registration failed:', error);
                            // });
                    });
                }
            </script>
        @endif
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
