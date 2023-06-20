<script setup>

import Item from './Item.vue';

import { ref, } from 'vue'
import { useCookies } from "vue3-cookies";
const { cookies } = useCookies();

var orders = cookies.keys();

const count = ref(0)
</script>

<template>
	<div class="w-32">
		<aside class="fixed top-1/3 flex flex-col items-center space-y-4 p-4 rounded-xl bg-gray-50">
			<Item path="/" icon="fa-solid fa-house" />	
			<Item path="/cart" :quant="orders.length" icon="fa-solid fa-cart-shopping" />	
			<Item path="/add" icon="fa-solid fa-plus" />	
		</aside> 
	</div>	
</template>


