import enLocales from '@/locales/en/index.js'
import frLocales from '@/locales/fr/index.js'
import deLocales from '@/locales/de/index.js'
import ruLocales from '@/locales/ru/index.js'
import zhLocales from '@/locales/zh/index.js'
import jaLocales from '@/locales/ja/index.js'

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

function loadLocaleMessages() {
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

export { dateTimeFormats, loadLocaleMessages }