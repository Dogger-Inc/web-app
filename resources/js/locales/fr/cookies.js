export default {
    "consent_modal": {
        "title": "Nous utilisons des cookies",
        "description": "Notre application Dogger utilise des cookies afin de vous fournir une expérience d'utilisation toujours au top ! <button type=\"button\" data-cc=\"c-settings\" class=\"cc-link\">Laissez moi choisir</button>",
        "primary_btn": {
            "text": "J'accepte !",
            "role": "accept_all"
        },
        "secondary_btn": {
            "text": "Les cookies nécessaires",
            "role": "accept_necessary"
        }
    },
    "settings_modal": {
        "title": "Préférence des cookies",
        "save_settings_btn": "Sauvegarder",
        "accept_all_btn": "Accepter tous les cookies",
        "reject_all_btn": "Seulement les cookies nécessaires",
        "close_btn_label": "Fermer",
        "cookie_table_headers": [
            { "col1": "Nom" },
            { "col2": "Domaine" },
            { "col3": "Expiration" },
            { "col4": "Description" }
        ],
        "blocks": [
            {
                "title": "Utilisation des cookies 📢",
                "description": "Nous utilisons des cookies pour assurer les fonctionnalités de base du site Web et pour améliorer votre expérience en ligne. Vous pouvez choisir pour chaque catégorie de vous inscrire ou de vous désinscrire quand vous le souhaitez. Pour plus de détails relatifs aux cookies et autres données sensibles, veuillez lire l'intégralité de <a href=\"/politique-de-confidentialite\" class=\"cc-link\">politique de confidentialité</a>."
            },
            {
                "title": "Les cookies nécessaires 🍪",
                "description": "Ces cookies sont indispensables au bon fonctionnement de mon site internet. Sans ces cookies, le site Web ne fonctionnerait pas correctement",
                "toggle": {
                    "value": "necessary",
                    "enabled": true,
                    "readonly": true
                },
                "cookie_table": [
                    {
                        "col1": "cc_cookie",
                        "col2": ".dogger.host",
                        "col3": "1 an",
                        "col4": "Cookie de sauvegarde des préférences de cookies",
                        "is_regex": true
                    },
                    {
                        "col1": "XSRF-TOKEN",
                        "col2": "dogger.host",
                        "col3": "2 heures",
                        "col4": "Token de session",
                        "is_regex": true
                    }
                ]
            },
            {
                "title": "Cookies d'analyse 📊",
                "description": "Ces cookies nous permettent de suivre et monitorer le traffic sur notre site, afin de nous aider à améliorer nos services. Ces cookies ne contiennent aucune information personnelle.",
                "toggle": {
                    "value": "analytics",
                    "enabled": false,
                    "readonly": false
                },
                "cookie_table": [
                    {
                        "col1": "^_pk_id, ^_pk_ses",
                        "col2": "analytics.dogger.host",
                        "col3": "1 an",
                        "col4": "Matomo analytics",
                        "is_regex": true
                    }
                ]
            },
            {
                "title": "Plus d'informations",
                "description": "Pour toute question relative à notre politique en matière de cookies et à vos choix, veuillez <a class=\"cc-link\" href=\"/contact\">nous contacter</a>."
            }
        ]
    }
}