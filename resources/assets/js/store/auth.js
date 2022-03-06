import router from '../router'
import axios from 'axios'

const types = {
	LOGIN: 'LOGIN',
	LOGOUT: 'LOGOUT'
}

const state = {
	logged: !!window.localStorage.getItem('token')
}

const mutations = {
	[types.LOGIN] (state) {
		state.logged = true
	},

	[types.LOGOUT] (state) {
		state.logged = false
	}
}

const getters = {
	isLogged: state => state.logged
}

const actions = {
	login ({ commit }, data) {
		commit(types.LOGIN);
        // console.log('token',data);
		// window.localStorage.setItem('token', data.access_token)
		window.localStorage.setItem('token', data.Authorization);
		window.localStorage.setItem('userId', data.user_id);
		// axios.defaults.headers.common['Authorization'] = 'Bearer ' + data.access_token
		axios.defaults.headers.common['Authorization'] = 'Bearer ' + data.Authorization;

		// router.push({name: 'Dashboard'})
		router.push({name: 'Home'})

	},

	logout ({ commit }) {
        // debugger
        var url = "auth/logout";
        // axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token').Authorization;
        axios.post(
            url,
        )
        .then((response) => {
            alert(1111);
            console.log(response);
        })
        .catch((e) => {
            console.log("exception", e);
        });

		commit(types.LOGOUT);
		window.localStorage.removeItem('token');
		// window.localStorage.removeItem('userId');
		delete axios.defaults.headers.common['Authorization'];
        window.localStorage.removeItem('user');

		// router.push({name: 'Home'});
	}
}

export default {
	state,
	mutations,
	getters,
	actions
}