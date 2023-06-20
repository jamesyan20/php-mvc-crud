<script setup>
import { ref, computed,toRaw } from 'vue'

var props = defineProps({
	order: {
		default:{},
		type:Object
	},
})

const emit = defineEmits(['delete'])

props.order.count = ref(props.order.hasOwnProperty('count') == true ? toRaw(props.order).count._value : 0);

props.order.total = 0;
props.order.total = computed(() => {
	return props.order.price*props.order.count; 
})


</script>

<template>
	<div class="group relative items-center justify-between w-full bg-gray-100 flex flex-row space-x-2 rounded-xl">
		<div class="flex flex-row items-center space-x-2">
			<img :src="props.order.images.length>0 ? props.order.images[0].uri : 'https://static.vecteezy.com/system/resources/previews/004/141/669/large_2x/no-photo-or-blank-image-icon-loading-images-or-missing-image-mark-image-not-available-or-image-coming-soon-sign-simple-nature-silhouette-in-frame-isolated-illustration-vector.jpg'" class="object-cover w-32 h-32 bg-blue-200"/>
			<div class="flex flex-col space-y-2 ml-8">
				<div class="font-medium text-xl">{{props.order.name}}</div>
				<div class="font-light">Em estoque {{props.order.quantity}} (unidades) </div>
			</div>
		</div>	
		<div class="flex flex-row items-center space-x-2">
			<div class="flex flex-row">
				<button type="button" @click="props.order.count > 0 && props.order.count <= props.order.quantity ? props.order.count-- : ''" class="flex items-center flex-shrink-0 justify-center h-14 w-14 rounded-l-xl bg-gray-200">
					<i class="fa-solid fa-minus"></i>	
				</button>
				<input v-model="props.order.count" type="number" name="quantity" class="w-14 outline-none focus:outline-none text-center bg-gray-100 font-semibold text-md hover:text-black focus:text-black  md:text-basecursor-default flex items-center text-gray-700  outline-none"/>
				<button type="button" @click="props.order.count < props.order.quantity ? props.order.count++ : ''" class="flex items-center flex-shrink-0 justify-center h-14 w-14 rounded-r-xl bg-gray-200">
					<i class="fa-solid fa-plus"></i>	
				</button>
			</div>
			<div class="pr-12 w-44 flex justify-end">
				<span class="text-gray-800 text-xl">R$ {{props.order.total}},00</span>
			</div>
			<button @click="emit('delete', {index:index,key:props.order.id})" class="hover:text-red-500 text-xl pr-12">
				<i class="fa-solid fa-trash"></i>	
			</button>
		</div>
	</div>
</template>


