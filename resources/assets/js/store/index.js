import Vue from 'vue'
import Vuetify from 'vuetify'
import Vuex from 'vuex'

import auth from './auth'

Vue.use(Vuex)
Vue.use(Vuetify)
import 'vuetify/dist/vuetify.min.css'
export default new Vuex.Store({
	modules: {
		auth
	}
})