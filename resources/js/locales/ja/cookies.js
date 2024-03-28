export default {
    "consent_modal": {
        "title": "クッキーを使用します",
        "description": "Dogger アプリケーションは最高のユーザー エクスペリエンスを保証するために Cookie を使用しています。 <button type=\"button\" data-cc=\"c-settings\" class=\"cc-link\">選ばせてください</button>",
        "primary_btn": {
            "text": "承諾します ！",
            "role": "accept_all"
        },
        "secondary_btn": {
            "text": "必要なクッキー",
            "role": "accept_necessary"
        }
    },
    "settings_modal": {
        "title": "クッキーの設定",
        "save_settings_btn": "保存",
        "accept_all_btn": "すべての Cookie を受け入れる",
        "reject_all_btn": "必要なクッキーのみ",
        "close_btn_label": "近い",
        "cookie_table_headers": [
            {
                "col1": "名前"
            },
            {
                "col2": "ドメイン"
            },
            {
                "col3": "有効期限"
            },
            {
                "col4": "説明"
            }
        ],
        "blocks": [
            {
                "title": "クッキーの使用📢",
                "description": "当社は、Web サイトの基本機能を提供し、オンライン エクスペリエンスを向上させるために Cookie を使用します。  <a href=\"/politique-de-confidentialite\" class=\"cc-link\">プライバシーポリシー</a>。"
            },
            {
                "title": "必要なクッキー🍪",
                "description": "これらの Cookie は、私の Web サイトが適切に機能するために不可欠です。 ",
                "toggle": {
                    "value": "必要",
                    "enabled": true,
                    "readonly": true
                },
                "cookie_table": [
                    {
                        "col1": "cc_cookie",
                        "col2": ".dogger.cloud",
                        "col3": "1年",
                        "col4": "Cookie の設定を保存するための Cookie",
                        "is_regex": true
                    },
                    {
                        "col1": "XSRF-TOKEN",
                        "col2": "dogger.cloud",
                        "col3": "2時間",
                        "col4": "セッショントークン",
                        "is_regex": true
                    }
                ]
            },
            {
                "title": "分析クッキー 📊",
                "description": "これらの Cookie を使用すると、サービスの向上に役立てるため、サイト上のトラフィックを追跡および監視できます。 ",
                "toggle": {
                    "value": "分析",
                    "enabled": false,
                    "readonly": false
                },
                "cookie_table": [
                    {
                        "col1": "^_pk_id, ^_pk_ses",
                        "col2": "analytics.dogger.cloud",
                        "col3": "1年",
                        "col4": "Matomo analytics",
                        "is_regex": true
                    }
                ]
            },
            {
                "title": "詳しくは",
                "description": "当社の Cookie ポリシーおよびお客様の選択に関するご質問については、こちらまでお問い合わせください。 <a class=\"cc-link\" href=\"/contact\">お問い合わせ</a>。"
            }
        ]
    }
}