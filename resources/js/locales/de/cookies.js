export default {
    "consent_modal": {
        "title": "Wir verwenden Cookies",
        "description": "Unsere Dogger-Anwendung verwendet Cookies, um Ihnen das beste Benutzererlebnis zu gewährleisten! <button type=\"button\" data-cc=\"c-settings\" class=\"cc-link\">Lass mich aussuchen</button>",
        "primary_btn": {
            "text": "Ich akzeptiere !",
            "role": "accept_all"
        },
        "secondary_btn": {
            "text": "Notwendige Cookies",
            "role": "accept_necessary"
        }
    },
    "settings_modal": {
        "title": "Cookie-Präferenz",
        "save_settings_btn": "Speichern",
        "accept_all_btn": "Akzeptieren Sie alle Cookies",
        "reject_all_btn": "Nur notwendige Cookies",
        "close_btn_label": "Schließen",
        "cookie_table_headers": [
            {
                "col1": "Name"
            },
            {
                "col2": "Domain"
            },
            {
                "col3": "Ablauf"
            },
            {
                "col4": "Beschreibung"
            }
        ],
        "blocks": [
            {
                "title": "Verwendung von Cookies 📢",
                "description": "Wir verwenden Cookies, um grundlegende Funktionen der Website bereitzustellen und Ihr Online-Erlebnis zu verbessern.  <a href=\"/politique-de-confidentialite\" class=\"cc-link\">Datenschutzrichtlinie</a>."
            },
            {
                "title": "Notwendige Kekse 🍪",
                "description": "Diese Cookies sind für das ordnungsgemäße Funktionieren meiner Website unerlässlich. ",
                "toggle": {
                    "value": "necessary",
                    "enabled": true,
                    "readonly": true
                },
                "cookie_table": [
                    {
                        "col1": "cc_cookie",
                        "col2": ".dogger.host",
                        "col3": "1 Jahr",
                        "col4": "Cookie zum Speichern der Cookie-Einstellungen ",
                        "is_regex": true
                    },
                    {
                        "col1": "XSRF-TOKEN",
                        "col2": "dogger.host",
                        "col3": "2 Stunden",
                        "col4": "Sitzungstoken",
                        "is_regex": true
                    }
                ]
            },
            {
                "title": "Analyse-Cookies 📊",
                "description": "Mit diesen Cookies können wir den Verkehr auf unserer Website verfolgen und überwachen, um unsere Dienste zu verbessern. ",
                "toggle": {
                    "value": "analytics",
                    "enabled": false,
                    "readonly": false
                },
                "cookie_table": [
                    {
                        "col1": "^_pk_id, ^_pk_ses",
                        "col2": "analytics.dogger.host",
                        "col3": "1 Jahr",
                        "col4": "Matomo analytics",
                        "is_regex": true
                    }
                ]
            },
            {
                "title": "Mehr Informationen",
                "description": "Bei Fragen zu unserer Cookie-Richtlinie und Ihren Auswahlmöglichkeiten wenden Sie sich bitte an uns <a class=\"cc-link\" href=\"/contact\">Kontaktiere</a>."
            }
        ]
    }
}