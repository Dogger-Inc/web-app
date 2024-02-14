import dashboard from './dashboard'
import projects from './projects'
import general from './general'
import homepage from './homepage'
import lang from './lang'

export default {
    ...dashboard,
    ...general,
    ...homepage,
    ...lang,
    ...projects
}
