export default {
    "consent_modal": {
        "title": "Мы используем файлы cookie",
        "description": "Наше приложение Dogger использует файлы cookie, чтобы обеспечить вам максимальное удобство использования! <button type=\"button\" data-cc=\"c-settings\" class=\"cc-link\">Позвольте мне выбрать</button>",
        "primary_btn": {
            "text": "Я принимаю !",
            "role": "accept_all"
        },
        "secondary_btn": {
            "text": "Необходимые файлы cookie",
            "role": "accept_necessary"
        }
    },
    "settings_modal": {
        "title": "Предпочтения в отношении файлов cookie",
        "save_settings_btn": "Сохранять",
        "accept_all_btn": "Принять все файлы cookie",
        "reject_all_btn": "Только необходимые файлы cookie",
        "close_btn_label": "Закрывать",
        "cookie_table_headers": [
            {
                "col1": "Имя"
            },
            {
                "col2": "Домен"
            },
            {
                "col3": "Срок действия"
            },
            {
                "col4": "Описание"
            }
        ],
        "blocks": [
            {
                "title": "Использование файлов cookie 📢",
                "description": "Мы используем файлы cookie, чтобы обеспечить базовую функциональность веб-сайта и улучшить вашу работу в Интернете.  <a href=\"/politique-de-confidentialite\" class=\"cc-link\">политика конфиденциальности</a>."
            },
            {
                "title": "Необходимое печенье 🍪",
                "description": "Эти файлы cookie необходимы для правильного функционирования моего веб-сайта. ",
                "toggle": {
                    "value": "необходимый",
                    "enabled": true,
                    "readonly": true
                },
                "cookie_table": [
                    {
                        "col1": "cc_cookie",
                        "col2": ".dogger.cloud",
                        "col3": "1 год",
                        "col4": "Файл cookie для сохранения настроек файлов cookie",
                        "is_regex": true
                    },
                    {
                        "col1": "XSRF-TOKEN",
                        "col2": "dogger.cloud",
                        "col3": "2 часа",
                        "col4": "Токен сеанса",
                        "is_regex": true
                    }
                ]
            },
            {
                "title": "Аналитические файлы cookie 📊",
                "description": "Эти файлы cookie позволяют нам отслеживать и контролировать трафик на нашем сайте, чтобы помочь нам улучшить наши услуги. ",
                "toggle": {
                    "value": "аналитика",
                    "enabled": false,
                    "readonly": false
                },
                "cookie_table": [
                    {
                        "col1": "^_pk_id, ^_pk_ses",
                        "col2": "analytics.dogger.cloud",
                        "col3": "1 год",
                        "col4": "Матомо аналитика",
                        "is_regex": true
                    }
                ]
            },
            {
                "title": "Больше информации",
                "description": "По любым вопросам, касающимся нашей политики использования файлов cookie и вашего выбора, пожалуйста, <a class=\"cc-link\" href=\"/contact\">Связаться с нами</a>."
            }
        ]
    }
}