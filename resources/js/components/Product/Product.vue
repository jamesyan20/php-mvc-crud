<script setup>

import Item from './Item.vue';
import { ref, computed, reactive, inject } from 'vue'

import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'

import axios from 'axios';

import {useToast} from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

import { useCookies } from "vue3-cookies";
const { cookies } = useCookies();

const $toast = useToast()
const swal = inject('$swal')

const props = defineProps({
	product:{
		type:String,
		default:''
	}
})

var key = ref(1)

var in_cart = ref(cookies.get(`order_${props.product.id}`) == null ? false : true);

props.product.count = ref(0);

const addCart = () =>{

	console.log(props.product);

	if(in_cart.value){
		cookies.remove(`order_${props.product.id}`);		
		$toast.open({
			message: "Produto removido do carrinho!",
			type: "success",
		});	
	}else{
		cookies.set(`order_${props.product.id}`, JSON.stringify(props.product));		
		$toast.open({
			message: "Produto adicionado ao carrinho!",
			type: "success",
		});	
	}

	in_cart.value = !in_cart.value;
	key.value = key.value+1;
}

</script>

<template>
	<div class="w-full grid grid-cols-1 lg:grid-cols-3 items-center gap-8">
		<section class="col-span-2 flex w-full flex-col space-y-4">
			<div class="text-2xl font-medium">
				{{product.name}}
			</div>
			<Carousel v-if="product.images.length > 1">
				<Slide v-for="(image,index) in product.images" :key="index">
					<img :src="image.uri" class="rounded-xl object-cover w-full h-96" /> 
				</Slide>

				<template #addons>
					<Navigation />
					<Pagination />
				</template>
			</Carousel>
			<img v-else :src="product.images.length == 0 ? 'https://static.vecteezy.com/system/resources/previews/004/141/669/large_2x/no-photo-or-blank-image-icon-loading-images-or-missing-image-mark-image-not-available-or-image-coming-soon-sign-simple-nature-silhouette-in-frame-isolated-illustration-vector.jpg' : product.images[0].uri" class="rounded-xl object-cover w-full h-96" /> 

			<div class="text-gray-800 text-xl pt-4">
				{{product.description}}
			</div>
		</section>
		<section class="flex flex-col space-y-4 w-full">
			<div class="font-bold mb-4 text-2xl">Adicionar ao carrinho</div>
			<div class="flex flex-row space-x-2 items-center justify-between">
				<div class="text-3xl font-medium">R${{product.price}},00</div>
			
				<div class="flex flex-row">
					<button type="button" @click="props.product.count.value > 0 && props.product.count <= props.product.quantity ? props.product.count.value-- : ''" class="flex items-center flex-shrink-0 justify-center h-14 w-14 rounded-l-xl bg-gray-200">
						<i class="fa-solid fa-minus"></i>	
					</button>
					<input v-model="props.product.count.value" type="number" name="quantity" class="w-14 outline-none focus:outline-none text-center bg-gray-100 font-semibold text-md hover:text-black focus:text-black  md:text-basecursor-default flex items-center text-gray-700  outline-none"/>
					<button type="button" @click="props.product.count.value < props.product.quantity ? props.product.count.value++ : ''" class="flex items-center flex-shrink-0 justify-center h-14 w-14 rounded-r-xl bg-gray-200">
						<i class="fa-solid fa-plus"></i>	
					</button>
				</div>
				</div>
				<div class="text-gray-700">
					Em estoque ({{product.quantity}}) unidades
				</div>
			<button :key="key.value" @click="addCart()" class="flex items-center justify-center text-center text-white w-full text-xl p-2 bg-green-500 rounded-md">
						<div v-if="in_cart ==false ">
							<i class="fa-solid fa-cart-shopping"></i>
						</div>
						<div v-else class="flex flex-row space-x-2 items-center">
							<i class="fa-solid fa-check"></i>	
							<span class="font-medium">No carrinho</span>
						</div>
					</button>

		</section>
	</div>	
</template>


