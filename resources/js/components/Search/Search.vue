<script setup>

import Item from './Item.vue';
import { ref, computed, reactive, inject } from 'vue'

import axios from 'axios';

import {useToast} from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

const $toast = useToast()
const swal = inject('$swal')

const props = defineProps({
	products:{
		type:String,
		default:''
	}
})

var products = reactive(props.products);

var search = ref('');

const onDelete = (data) =>{	

	swal({
        title: 'Tem certeza?',
        text: 'Você tem certeza que gostaria de deletar este produto?',
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: 'Quero deletar',
        cancelButtonText: 'Cancelar',
        showCloseButton: true,
        showLoaderOnConfirm: true
	}).then((result) => {
        if(result.value) {

			axios.post('http://localhost:8000/delete', {
				id: data.id,
			})
			.then(function (response) {
				//console.log(response);
				$toast.open({
					message: response.data.message,
					type: response.data.status,
				});	
				products.splice(data.index,1);
			})
			.catch(function (error) {
				$toast.open({
					message: "Ocorreu um erro inesperado!",
					type: "error",
				});
			});

        } 
    });
		
}

const filteredProducts = computed(() => {
	return products.filter((product) =>{
        return product.name.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, "").match(search.value.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, "")) || product.name.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, "").match(search.value.normalize('NFD').replace(/[\u0300-\u036f]/g, "")) 
    }); 
})

</script>

<template>
	<section class="flex flex-col space-y-4">
		<div class="flex flex-row items-center text-xl space-x-2 w-1/2 p-4 h-16 bg-gray-200 rounded-xl">
			<i class="fa-solid fa-magnifying-glass text-gray-600 ml-1"></i>	
			<input v-model="search" placeholder="Pesquise por: Camisas, Tênis, Calças..." class="text-gray-600 py-4 pr-4 pl-2 focus:outline-none bg-transparent w-full"/>
			{{search.value}}
		</div>	
		<p class="text-gray-600">({{products.length}}) produtos cadastrados</p>
		<div class="w-full grid grid-cols-1 lg:grid-cols-3 gap-4">
			<Item v-for="(product,index) in filteredProducts" :key="index" :index="index" @delete="onDelete" :product="product"/>	
		</div>
	</section>
</template>


