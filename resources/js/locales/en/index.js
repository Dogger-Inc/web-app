import dashboard from './dashboard'
import projects from './projects'
import general from './general'
import homepage from './homepage'
import companies from './companies'
import navbar from './navbar'
import profile from './profile'
import issues from './issues'
import lang from './lang'
import login from './login'
import performances from './performances'
import register from './register'
import forgotPassword from './forgotPassword'

export default {
    ...dashboard,
    ...general,
    ...homepage,
    ...companies,
    ...navbar,
    ...profile,
    ...lang,
    ...login,
    ...register,
    ...forgotPassword,
    ...projects,
    ...issues,
    ...performances,
}
