import VueRouter from 'vue-router';
import store from '../store';
import Home from '../components/Home.vue';
import Register from '../components/Register.vue';
import Login from '../components/Login.vue';
import Dashboard from '../components/Dashboard.vue';
import CustomOrder from '../components/CustomOrder.vue';
import Cart from '../components/Cart.vue';
import Orders from '../components/Orders.vue';
import MyFurniture from '../components/MyFurniture.vue';
import MyUsers from "../components/MyUsers";
import OrdersFurniture from "../components/OrdersFurniture";
const router = new VueRouter({
	routes: [
		{
			path: '/',
			name: 'Home',
			component: Home, 
			meta: {
				auth: false
			}
		},
		{
			path: '/register',
			name: 'Register',
			component: Register,
			meta: {
				auth: false
			}
		},

		{
			path: '/login',
			name: 'Login',
			component: Login,
			meta: {
				auth: false
			}
		},
        {
            path: '/order',
            name: 'Order',
            component: CustomOrder,
            meta: {
                auth: false
            }
        },
		{
			path: '/furnitures',
			name: 'Furniture',
			component: MyFurniture,
			meta: {
				auth: false
			}
		},
		{
			path: '/users',
			name: 'Users',
			component: MyUsers,
			meta: {
				auth: false
			}
		},
		{
			path: '/ordersFurniture',
			name: 'OrdersFurniture',
			component: OrdersFurniture,
			meta: {
				auth: false
			}
		},
		{
			path: '/ordersFurniture',
			name: 'OrdersFurniture',
			component: OrdersFurniture,
			meta: {
				auth: false
			}
		},
        {
            path: '/cart',
            name: 'Cart',
            component: Cart,
            meta: {
                auth: true
            }
        },
        {
            path: '/history',
            name: 'Orders',
            component: Orders,
            meta: {
                auth: true
            }
        },
        {
            path: '/history',
            name: 'Orders',
            component: Orders,
            meta: {
                auth: true
            }
        },
		{
			path: '/dashboard',
			name: 'Dashboard',
			component: Dashboard,
			meta: {
				auth: true
			}
		},
		{
			path: '*',
			redirect: '/'
		}
	]
});

router.beforeEach((to, from, next) => {
	if (!store.getters.isLogged && to.meta.auth) {
		return next('/login')
	}

	if (store.getters.isLogged && to.name === 'Login') {
		return next('/')
	}

	next()
});

export default router