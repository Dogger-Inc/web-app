export default {
    "consent_modal": {
        "title": "我们使用cookies",
        "description": "我们的 Dogger 应用程序使用 cookie 以确保您获得最佳的用户体验！ <button type=\"button\" data-cc=\"c-settings\" class=\"cc-link\">让我选择</button>",
        "primary_btn": {
            "text": "我接受 ！",
            "role": "accept_all"
        },
        "secondary_btn": {
            "text": "必要的cookie",
            "role": "accept_necessary"
        }
    },
    "settings_modal": {
        "title": "Cookie 偏好",
        "save_settings_btn": "节省",
        "accept_all_btn": "接受所有cookie",
        "reject_all_btn": "仅必要的cookie",
        "close_btn_label": "关闭",
        "cookie_table_headers": [
            {
                "col1": "姓名"
            },
            {
                "col2": "领域"
            },
            {
                "col3": "到期"
            },
            {
                "col4": "描述"
            }
        ],
        "blocks": [
            {
                "title": "使用 cookie 📢",
                "description": "我们使用 cookie 来提供网站的基本功能并改善您的在线体验。  <a href=\"/politique-de-confidentialite\" class=\"cc-link\">隐私政策</a>。"
            },
            {
                "title": "必要的饼干🍪",
                "description": "这些 cookie 对于我的网站的正常运行至关重要。 ",
                "toggle": {
                    "value": "必要的",
                    "enabled": true,
                    "readonly": true
                },
                "cookie_table": [
                    {
                        "col1": "cc_cookie",
                        "col2": ".dogger.host",
                        "col3": "1年",
                        "col4": "Cookie 保存 cookie 偏好设置",
                        "is_regex": true
                    },
                    {
                        "col1": "XSRF-TOKEN",
                        "col2": "dogger.host",
                        "col3": "2小时",
                        "col4": "会话令牌",
                        "is_regex": true
                    }
                ]
            },
            {
                "title": "分析 cookie 📊",
                "description": "这些 cookie 使我们能够跟踪和监控我们网站上的流量，以帮助我们改进我们的服务。 ",
                "toggle": {
                    "value": "分析",
                    "enabled": false,
                    "readonly": false
                },
                "cookie_table": [
                    {
                        "col1": "^_pk_id, ^_pk_ses",
                        "col2": "analytics.dogger.host",
                        "col3": "1年",
                        "col4": "马托莫分析",
                        "is_regex": true
                    }
                ]
            },
            {
                "title": "更多信息",
                "description": "如果对我们的 cookie 政策和您的选择有任何疑问，请 <a class=\"cc-link\" href=\"/contact\">联系我们</a>。"
            }
        ]
    }
}