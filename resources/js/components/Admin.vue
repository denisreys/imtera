<template>
<div class="absolute z-10 top-0 bg-white pl-5 w-full pt-3 sm:right-0 sm:w-80 sm:rounded  ">
    <ul class="text-lg font-semibold fixed bg-white">
        <li class="inline-block mr-4 pb-2 hover:border-b-2 hover:border-b-gray-100" :class="tabActive == 'content' ? 'admin-tab--active' : ''">
            <a href="#" class="block" @click.prevent="tabActive = 'content'">Content</a>
        </li>
        <li class="inline-block mr-4 pb-2 hover:border-b-2 hover:border-b-gray-100" :class="tabActive == 'design' ? 'admin-tab--active' : ''">
            <a href="#" class="block" @click.prevent="tabActive = 'design'">Design</a>
        </li>
    </ul>
    <div class="py-5 mt-9 overflow-y-scroll max-h-[80vh] pr-4">
        <div v-if="tabActive == 'content'">
            <ul class="mb-4" v-if="questionsList.length">
                <adminQuestion v-for="question in questionsList" :key="question.id"
                    :id="question.id"
                    :question="question.question"
                    :answer="question.answer"
                    @updateQuestionsList="emit('updateQuestionsList')"
                />
            </ul>
            <div class="mb-5 text-sm text-gray-400 p-3 border text-center" v-else>
                Add some questions
            </div> 
            <a href="#" class="text-indigo-400 hover:opacity-70" @click.prevent="newQuestion.show = true" v-if="newQuestion.show == false">
                <span class="inline-block mr-1 align-middle">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
                <span class="inline-block align-middle">Add question</span>
            </a>
            <div v-if="newQuestion.show == true">
                <div class="relative w-full border-t mt-10 mb-5">
                    <div class="absolute text-center w-full -mt-4">
                        <span class="bg-white px-3 font-semibold text-lg">New question</span>
                    </div>
                </div>
                <div class="mb-1" v-if="newQuestion.errors">
                    <p class="text-red-600" v-for="error in newQuestion.errors">{{ error[0] }}</p>
                </div>
                <adminQuestionForm
                    id="0"
                    :question = newQuestion.form.question 
                    :answer = newQuestion.form.answer
                    @update:question="newValue => newQuestion.form.question = newValue"
                    @update:answer="newValue => newQuestion.form.answer = newValue">
                    <template v-slot:actions>
                        <button class="rounded-full bg-indigo-400 text-white py-1 px-8" @click="createQuestion()">Create</button>
                        <a href="#" class="text-red-600" @click.prevent="newQuestion.show = false">Cancel</a>
                    </template>
                </adminQuestionForm>
            </div>
        </div>
        <div v-if="tabActive == 'design'">  
            <adminSettings
                :settings="settings"
                @updateSettings="emit('updateSettings')"
                @updateQuestionsList="emit('updateQuestionsList')"
            />
        </div>
    </div>
</div>
</template>
<script setup>
    import { reactive } from 'vue';
    import { ref } from 'vue';
    import axios from 'axios';
    import adminQuestion from './AdminQuestion.vue';
    import adminQuestionForm from './adminQuestionForm.vue';
    import adminSettings from './adminSettings.vue';

    defineProps(['questionsList', 'settings']);
    const emit = defineEmits(['updateQuestionsList', 'updateSettings'])

    const tabActive = ref('content');

    const newQuestion = reactive({
        show: false,
        form: {
            'question': '',
            'answer': ''
        },
        errors: {}
    });

    function createQuestion(){
        newQuestion.errors = {};
        axios.get('/question/create', {
            params: {
                question: newQuestion.form.question,
                answer: newQuestion.form.answer,
            }
        })
        .then(response => {
            emit('updateQuestionsList');
            newQuestion.show = false;
            newQuestion.form.question = newQuestion.form.answer = '';
        })
        .catch(error => {
            if(error.response.status == 422){
                newQuestion.errors = error.response.data.errors;
            }
        });
    }
</script>