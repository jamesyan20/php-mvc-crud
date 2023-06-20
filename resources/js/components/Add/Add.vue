<script setup>
import { ref,reactive, computed,inject } from 'vue'


const swal = inject('$swal')
const props = defineProps({
	product:{
		type:Object,
		default:null
	},
})

var quantity = ref(props.product != null ? props.product.quantity : 0);

var key = ref(0);
var images = reactive( props.product != null && props.product.images.length > 0 ? props.product.images.map((image) => {return image.uri}) : []);

const onChange = e =>{	
	images = [...e.target.files].map((file)=>{
		return URL.createObjectURL(file);
	});
	key.value = key.value+1;
}

let urlParams = new URLSearchParams(window.location.search);

if(urlParams.has('type') && urlParams.get('type') == "success"){
	swal({
        title: 'Parabéns!',
        text: 'Seu produto foi cadastrado com sucesso!',
        icon: 'success',
        confirmButtonText: 'Certo',
        showCloseButton: true,
        showLoaderOnConfirm: true
	})	
}else if(urlParams.has('type') && urlParams.get('type') == "error"){
	swal({
        title: 'Error!',
        text: 'Ocorreu um erro ao cadastrar seu produto',
        icon: 'error',
        confirmButtonText: 'Certo',
        showCloseButton: true,
        showLoaderOnConfirm: true
	})		
}

var edit = ref(urlParams.has('id'));
var id = urlParams.get('id');
</script>


<template>
	<div class="flex flex-col space-y-2">
		<div class="flex flex-col space-y-2 mb-8">
			<h1 class="text-4xl text-gray-800">Bem-vindo ao painel de criação</h1>	
			<p class="text-xl text-gray-700">Crie e edite os produtos de seu sistema</p>
		</div>
<form :action="edit ? '/change' : '/save' " method="post" enctype="multipart/form-data" class="text-gray-800 flex flex-col space-y-2 w-full p-8 rounded-xl border-4 border-dashed">	

		<input v-if="edit" hidden name="id" :value="id"/>

		<section class="flex flex-col space-y-4 w-full">
			<div class="w-full grid grid-cols-1 lg:grid-cols-2 gap-4">
				<div class="w-full flex flex-col space-y-4">
					<div class="flex flex-col space-y-2 w-full">
						<label class="font-medium">Nome do produto</label>
						<input :value="props.product != null ? props.product.name : ''" placeholder="ex. Tênis" name="name" class="text-gray-600 focus:outline-none text-xl space-x-2 p-4 h-14 bg-gray-100 rounded-xl"/>
					</div>
					<div class="flex flex-col space-y-2 w-full">
						<label class="font-medium">Descrição do produto</label>
						<textarea name="description" class="text-gray-600 focus:outline-none text-xl space-x-2 p-4 bg-gray-100 rounded-xl h-60">
							{{props.product != null ? props.product.description : ' '}}
						</textarea>
					</div>
				</div>
				<div class="w-full flex flex-col space-y-4">
					<div class="flex flex-col space-y-2 w-full">
						<label class="font-medium">Preço do produto (R$)</label>
						<div class="flex flex-row text-xl space-x-2 h-14 bg-gray-100 rounded-xl">
							<div class="flex items-center justify-center w-14 text-xl h-14 bg-gray-300 rounded-l-xl">
								R$	
							</div>
							<input :value="props.product != null ? props.product.price : 0" placeholder="0,00" name="price" class="px-2 text-gray-600 focus:outline-none bg-transparent"/>
						</div>
					</div>
					<div class="flex flex-col space-y-2 w-full">
						<label class="font-medium">Items em estoque</label>
						
						<div class="flex flex-row">
							<button type="button" @click="quantity--" class="flex items-center flex-shrink-0 justify-center h-14 w-14 rounded-l-xl bg-gray-200">
								<i class="fa-solid fa-minus"></i>	
							</button>
							<input v-model="quantity" type="number" name="quantity" class="w-32 outline-none focus:outline-none text-center bg-gray-100 font-semibold text-md hover:text-black focus:text-black  md:text-basecursor-default flex items-center text-gray-700  outline-none"/>
							<button type="button" @click="quantity++" class="flex items-center flex-shrink-0 justify-center h-14 w-14 rounded-r-xl bg-gray-200">
								<i class="fa-solid fa-plus"></i>	
							</button>
						</div>
					</div>
				</div>
			</div>
			
			<div class="flex flex-col space-y-2">
				<label class="font-medium">Imagens do produto (Máx: 5)</label>
				<div :key="key.value" class="flex flex-wrap gap-4">
					<label class="cursor-pointer w-32 h-32 rounded-xl hover:bg-blue-200 transition duration-150 ease-in-out text-gray-800 text-3xl bg-gray-100 flex items-center justify-center">
						<i class="fa-solid fa-plus"></i>	
						<input @change="onChange" ref="files" hidden type="file" name="files[]" multiple >
					</label>
						<div v-for="(image,index) in images" :key="index" :style="`background-image: url('${image}')`" class="bg-cover w-32 h-32 rounded-xl">
					</div>
				</div>	
			</div>
		</section>
		<div class="w-full border-t pt-4 flex flex-row items-center justify-end mt-4">
			<input type="submit" value="Cadastrar produto" class="cursor-pointer p-4 bg-green-500 text-white text-xl font-bold rounded-md" />
		</div>
	</form>	
	</div>
	
</template>


