import dashboard from './dashboard'
import general from './general'
import homepage from './homepage'
import companies from './companies'
import profile from './profile'
import lang from './lang'
import login from './login'
import register from './register'

export default {
    ...dashboard,
    ...general,
    ...homepage,
    ...lang,
    ...login,
    ...register,
    ...companies,
    ...profile,
}