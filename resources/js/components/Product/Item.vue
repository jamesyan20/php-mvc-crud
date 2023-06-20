<script setup>
import { ref, computed, reactive, inject } from 'vue'

import {useToast} from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

import { useCookies } from "vue3-cookies";
const { cookies } = useCookies();

const $toast = useToast()

const props = defineProps({
	product:{
		type:Object,
		default:null
	},
	index:{
		type:Number,
		default:0
	}
})

const emit = defineEmits(['delete'])

var key = ref(1)

var in_cart = ref(cookies.get(`order_${props.product.id}`) == null ? false : true);

const addCart = () =>{

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
	<div  style="min-height:400px;" class="group relative w-full bg-gray-100 flex flex-col space-y-2 rounded-xl p-4 px-6">
				<div class="group-hover:opacity-100 opacity-0 absolute p-2 bg-gray-200 right-2 top-2 rounded-xl flex flex-row space-x-2">
					<a :href="`/edit?id=${product.id}`" class="flex items-center justify-center w-10 h-10 text-white rounded-md bg-green-500">
						<i class="fa-solid fa-pen"></i>		
					</a>
					<button @click="emit('delete',{index:index,id:product.id})" class="w-10 h-10 text-white rounded-md bg-red-500">
						<i class="fa-solid fa-trash"></i>
					</button>
				</div>	
				<img :src="product.images.length>0 ? product.images[0].uri : 'https://static.vecteezy.com/system/resources/previews/004/141/669/large_2x/no-photo-or-blank-image-icon-loading-images-or-missing-image-mark-image-not-available-or-image-coming-soon-sign-simple-nature-silhouette-in-frame-isolated-illustration-vector.jpg'" class="object-cover w-full h-60 rounded-xl"/>
				<div class="flex flex-col space-y-1">
					<div class="flex flex-row items-center space-x-2">
						<span class="text-medium text-xl font-medium">{{product.name}}</span>
						<span class="text-light text-lg">R$ {{product.price}}</span>
					</div>
					<p class="w-full h-20">{{product.description}}</p>
				</div>
				<div class="w-full flex flex-row mt-2 space-x-2">
					<button :key="key.value" @click="addCart()" class="flex items-center justify-center text-center text-white w-full text-xl p-2 bg-green-500 rounded-md">
						<div v-if="in_cart ==false ">
							<i class="fa-solid fa-cart-shopping"></i>
						</div>
						<div v-else class="flex flex-row space-x-2 items-center">
							<i class="fa-solid fa-check"></i>	
							<span class="font-medium">No carrinho</span>
						</div>
					</button>
					<a :href="`/product?id=${product.id}`" class="text-center text-white w-20 text-xl p-2 bg-blue-500 rounded-md">
						<i class="fa-solid fa-eye"></i>
					</a>
				</div>
			</div>
</template>


