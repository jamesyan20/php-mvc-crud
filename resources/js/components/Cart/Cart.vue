<script setup>

import Item from './Item.vue';
import { ref, computed, reactive, inject } from 'vue'

import {useToast} from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

const $toast = useToast()
const swal = inject('$swal')

import { useCookies } from "vue3-cookies";

const { cookies } = useCookies();

var orders = reactive(cookies.keys().map(cookie => cookies.get(cookie)));

var amount = ref(0)
var success= ref(false)

amount.value = computed(() => {
	return orders.reduce((a, b) =>{ return a + b.total }, 0); 
})

const cancel = () =>{
	cookies.keys().forEach(cookie => cookies.remove(cookie))		
	orders.splice(0);
}

const onDelete = (data) =>{

	swal({
        title: 'Tem certeza?',
        text: 'Você tem certeza que gostaria de remover este produto do seu carrinho?',
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: 'Quero remover',
        cancelButtonText: 'Cancelar',
        showCloseButton: true,
        showLoaderOnConfirm: true
	}).then((result) => {
        if(result.value) {
			orders.splice(data.index,1);
			cookies.remove(`order_${data.key}`);

			$toast.open({
				message: "Produto removido!",
				type: "success",
			});	

        } 
    });


}

const buy = () =>{
	success = true;	
}

</script>

<template>
	<section class="flex flex-col space-y-4">
		<div class="flex flex-col space-y-2 mb-8">
			<h1 class="text-4xl text-gray-800">Sua lista de pedidos</h1>	
			<p class="text-xl text-gray-700">Você pode remover items, editar a quantidade e concluir sua compra por aqui!</p>
		</div>
	
		<div class="">
			<div v-if="success == false && orders.length > 0"  class="flex flex-col space-y-4">
				<Item v-for="(order,index) in orders" :key="index" @delete="onDelete" :order="order"/>
			</div>
			<div v-else-if="success == false" class="border-dashed border-4 rounded-xl w-full h-96 flex items-center justify-center">	
				<div class="flex flex-row items-center space-x-12">
					<div>
						<Vue3Lottie animationLink="/public/lottie/empty.json" :height="200" :width="200" />
					</div>
					<div class="flex flex-col space-y-2">
						<span class="text-gray-800 text-3xl font-bold">OOOPS!</span>
						<span class="text-gray-700 text-xl">Parece que você ainda não tem nada no carrinho :(</span>
						<a href="/" class="hover:text-green-500 hover:underline text-lg">Ir as compras</a>
					</div>	
				</div>	
			</div>
			<div v-else class="border-dashed border-4 rounded-xl w-full h-96 flex items-center justify-center">	
				<div class="flex flex-row items-center space-x-12">
					<div>
						<Vue3Lottie animationLink="/public/lottie/success.json" :height="200" :width="200" />
					</div>
					<div class="flex flex-col space-y-2">
						<span class="text-gray-800 text-3xl font-bold">EBAAA!</span>
						<span class="text-gray-700 text-xl">Recebemos a sua compra! Verifique seu email para mais informações!</span>
						<a href="/" class="hover:text-green-500 hover:underline text-lg">Comprar novamente</a>
					</div>	
				</div>	
			</div>
		</div>
	
		<div v-if="success ==false && orders.length > 0" class="pt-10 w-full border-t pt-4 flex flex-row items-center justify-between">
			<div class="flex flex-col space-y-2">
				<p class="text-xl">Sua compra dará o total de <b>R$ {{amount}}</b></p>
				<p class="text-lg">Com <b>{{orders.length}}</b> items no carrinho</p>
			</div>
			<div class="flex flex-row space-x-2">
				<button @click="buy()" class="flex flex-row items-center space-x-2 rounded-xl text-lg font-bold bg-green-500 p-4 text-white">
					<i class="fa-solid fa-check"></i>
					<span>Concluir compra</span>
				</button>
				<button @click="cancel()" class="flex flex-row items-center space-x-2 rounded-xl text-lg font-bold bg-red-500 p-4 text-white">
					<span>Cancelar compra</span>
				</button>
			</div>	
		</div>
	</section>
</template>


