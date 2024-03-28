import "vanilla-cookieconsent/dist/cookieconsent";
import cookiesFR from './locales/fr/cookies'
import cookiesEN from './locales/en/cookies'
import cookiesDE from './locales/de/cookies'
import cookiesJA from './locales/ja/cookies'
import cookiesRU from './locales/ru/cookies'
import cookiesZH from './locales/zh/cookies'

// obtain plugin
// eslint-disable-next-line no-undef
let cc = initCookieConsent();

// run plugin with your configuration
cc.run({
    current_lang: localStorage.getItem('locale') || "en",
    autoclear_cookies: true,                   // default: false
    page_scripts: true,                        // default: false

    // mode: 'opt-in'                          // default: 'opt-in'; value: 'opt-in' or 'opt-out'
    // delay: 0,                               // default: 0
    // auto_language: '',                      // default: null; could also be 'browser' or 'document'
    // autorun: true,                          // default: true
    // force_consent: false,                   // default: false
    hide_from_bots: true,                  // default: false
    // remove_cookie_tables: false             // default: false
    // cookie_name: 'cc_cookie',               // default: 'cc_cookie'
    // cookie_expiration: 182,                 // default: 182 (days)
    // cookie_necessary_only_expiration: 182   // default: disabled
    // cookie_domain: location.hostname,       // default: current domain
    // cookie_path: '/',                       // default: root
    // cookie_same_site: 'Lax',                // default: 'Lax'
    // use_rfc_cookie: false,                  // default: false
    // revision: 0,                            // default: 0

    languages: {
        "fr": cookiesFR,
        "en": cookiesEN,
        "de": cookiesDE,
        "ja": cookiesJA,
        "ru": cookiesRU,
        "zh": cookiesZH
    }
});

export { cc };