import Vue from 'vue'
import Vuex from 'vuex'
import user from './store_modules/user'
import users from './store_modules/users'
import departments from './store_modules/departments'
import companies from './store_modules/companies'
import ui from './store_modules/ui'
// eslint-disable-next-line camelcase
import alert_message from './store_modules/alert_message'
Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    ui, alert_message, user, users, departments, companies,
  },
})
