import Vue from 'vue'
import Vuetify from 'vuetify'
import VueRouter from 'vue-router'
import axios from 'axios'
import Navbar from './components/includes/NavBar'
import 'vuetify/dist/vuetify.min.css'

const BASE_URL = process.env.MIX_API_ENDPOINT ||  'https://gnum.mskh.am';
console.log(process.env);

window.axios = axios

Vue.config.productionTip = false

Vue.use(VueRouter)
Vue.use(Vuetify)

Vue.component('Navbar', Navbar)

Vue.directive('focus', {
	inserted (el) {
		el.focus()
	}
})

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
axios.defaults.headers.common['Authorization'] = 'Bearer ' + window.localStorage.token
axios.defaults.baseURL = `${BASE_URL}/api/`
