<template>
    <li class="mb-2">
        <div class="flex items-center">
            <div class="text-xl">{{ question }}</div>
            <a href="#" class="ml-2 hover:opacity-50" @click.prevent="showAnswer = !showAnswer">
                <svg class="w-5 h-5 " :class="showAnswer ? 'rotate-180 align-top text-indigo-500' : 'text-black'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </a>
        </div>
        <div class="pt-2 pb-2" :style="{ paddingTop: paddingTop+'px', paddingBottom: paddingBottom+'px' }" v-if="showAnswer">{{ answer }}</div>
    </li>
</template>
<script setup>
    import { ref } from 'vue';
    defineProps(['id', 'question', 'answer', 'paddingTop', 'paddingBottom']);
    const showAnswer = ref(false);
</script>