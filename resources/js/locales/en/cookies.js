export default {
    "consent_modal": {
        "title": "We use cookies",
        "description": "Our Dogger application uses cookies to ensure you the best user experience! <button type=\"button\" data-cc=\"c-settings\" class=\"cc-link\">Let me choose</button>",
        "primary_btn": {
            "text": "I accept !",
            "role": "accept_all"
        },
        "secondary_btn": {
            "text": "Necessary cookies",
            "role": "accept_necessary"
        }
    },
    "settings_modal": {
        "title": "Cookie preference",
        "save_settings_btn": "Save",
        "accept_all_btn": "Accept all cookies",
        "reject_all_btn": "Only necessary cookies",
        "close_btn_label": "Close",
        "cookie_table_headers": [
            {
                "col1": "Name"
            },
            {
                "col2": "Domain"
            },
            {
                "col3": "Expiry"
            },
            {
                "col4": "Description"
            }
        ],
        "blocks": [
            {
                "title": "Use of cookies 📢",
                "description": "We use cookies to provide basic functionality of the website and to improve your online experience.  <a href=\"/politique-de-confidentialite\" class=\"cc-link\">Privacy Policy</a>."
            },
            {
                "title": "Necessary cookies 🍪",
                "description": "These cookies are essential for the proper functioning of my website. ",
                "toggle": {
                    "value": "necessary",
                    "enabled": true,
                    "readonly": true
                },
                "cookie_table": [
                    {
                        "col1": "cc_cookie",
                        "col2": ".dogger.host",
                        "col3": "1 year",
                        "col4": "Cookie to save cookie preferences",
                        "is_regex": true
                    },
                    {
                        "col1": "XSRF-TOKEN",
                        "col2": "dogger.host",
                        "col3": "2 hours",
                        "col4": "Session token",
                        "is_regex": true
                    }
                ]
            },
            {
                "title": "Analysis cookies 📊",
                "description": "These cookies allow us to track and monitor traffic on our site, in order to help us improve our services. ",
                "toggle": {
                    "value": "analytics",
                    "enabled": false,
                    "readonly": false
                },
                "cookie_table": [
                    {
                        "col1": "^_pk_id, ^_pk_ses",
                        "col2": "analytics.dogger.host",
                        "col3": "1 year",
                        "col4": "Matomo analytics",
                        "is_regex": true
                    }
                ]
            },
            {
                "title": "More information",
                "description": "For any questions relating to our cookie policy and your choices, please <a class=\"cc-link\" href=\"/contact\">Contact us</a>."
            }
        ]
    }
}