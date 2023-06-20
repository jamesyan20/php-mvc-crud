<script setup>
import { ref } from 'vue'

defineProps({
	quant: {
		default:0,
		type:Number
	},
	path: String,
	icon: String,
})

</script>

<template>
	<a :href="path" class="hover:bg-blue-200 transition duration-150 ease-in-out relative flex w-20 h-20 text-2xl justify-center items-center p-4 rounded-xl bg-gray-200">
		<span v-if="quant > 0" class="absolute top-2 right-2 text-center rounded-full bg-red-500 text-white w-6 h-6 font-bold text-base">{{quant}}</span>
		<i :class="icon"></i>
	</a> 
</template>


