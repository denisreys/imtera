<template>
    <li class="mb-2">
        <div class="flex items-center mb-1">
            <div class="text-lg font-semibold">
                {{ question }}
            </div>
            <a href="#" class="ml-1 hover:opacity-50" @click.prevent="showForm = !showForm">
                <svg class="w-4 h-4 " :class="showForm ? 'rotate-180 text-indigo-500' : 'text-black'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </a>
        </div>
        <div class="py-1" v-if="showForm">
            <div class="mb-5 text-sm text-gray-400 p-3 border text-center">
                Changes are saved without reloading the page.
            </div>          
            <div class="mb-1" v-if="Object.keys(updateQuestionData.errors).length">
                <p class="text-red-600" v-for="error in updateQuestionData.errors">{{ error[0] }}</p>
            </div>
            <div class="mb-1" v-else-if="updateQuestionData.success">
                <p class="text-green-600">{{ updateQuestionData.success }}</p>
            </div>
            <adminQuestionForm
                :question = question
                :answer = answer
                @update:question="newValue => updateQuestionData.form.question = newValue"
                @update:answer="newValue => updateQuestionData.form.answer = newValue">
                <template v-slot:actions>
                    <button class="rounded-full bg-indigo-400 text-white py-1 px-8" @click="updateQuestion()">Save</button>
                    <a href="#" class="text-red-600" @click.prevent="destroyQuestion()">Delete</a>
                </template>
            </adminQuestionForm>
        </div> 
    </li>
</template>
<script setup>
    import { ref } from 'vue';
    import { reactive } from 'vue';
    import adminQuestionForm from './adminQuestionForm.vue';

    let props = defineProps(['id', 'question', 'answer']);
    const emit = defineEmits(['updateQuestionsList'])
    const showForm = ref(false);

    const updateQuestionData = reactive({
        form: {
            'id': props.id,
            'question': props.question,
            'answer': props.answer
        },
        errors: {},
        success: ''
    });
    function updateQuestion(){
        updateQuestionData.success = '';
        updateQuestionData.errors = {};

        axios.put('/question/'+updateQuestionData.form.id, {
                question: updateQuestionData.form.question,
                answer: updateQuestionData.form.answer,
        })
        .then(response => {
            emit('updateQuestionsList');
            updateQuestionData.success = 'Saved changes';
        })
        .catch(error => {
            if(error.response.status == 422){
                updateQuestionData.errors = error.response.data.errors;
            }
        });
    }
    function destroyQuestion(){
        axios.delete('/question/'+updateQuestionData.form.id)
        .then(response => {
            emit('updateQuestionsList');
        });
    }
</script>