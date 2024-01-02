import enLocales from '@/locales/en.json'
import frLocales from '@/locales/fr.json'
import deLocales from '@/locales/de.json'
import ruLocales from '@/locales/ru.json'
import zhLocales from '@/locales/zh.json'
import jaLocales from '@/locales/ja.json'

const dateTimeFormats = {
    'en-US': {
      short: {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
      },
      long: {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        weekday: 'short',
        hour: 'numeric',
        minute: 'numeric'
      }
    },
    'fr-FR': {
      short: {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
      },
      long: {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        weekday: 'short',
        hour: 'numeric',
        minute: 'numeric'
      }
    }
  }

  function loadLocaleMessages () {
    const messages = {
      en: enLocales,
      fr: frLocales,
      de: deLocales,
      ru: ruLocales,
      zh: zhLocales,
      ja: jaLocales,
    }
    return messages
  }

  export {dateTimeFormats, loadLocaleMessages}