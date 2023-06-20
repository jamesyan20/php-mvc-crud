

import { createApp } from 'vue'
//import App from './App.vue'
import Nav from './components/Navbar/Navbar.vue'
import Add from './components/Add/Add.vue'
import Search from './components/Search/Search.vue'
import Cart from './components/Cart/Cart.vue'
import Product from './components/Product/Product.vue'

import Vue3Lottie from 'vue3-lottie'
import 'vue3-lottie/dist/style.css'

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

const app = createApp({
	delimiters: ['${', '}']
})

app.use(Vue3Lottie)
app.use(VueSweetalert2);


app.component('product',Product)
app.component('navbar',Nav)
app.component('add',Add)
app.component('search',Search)
app.component('cart',Cart)

app.mount('#app')
