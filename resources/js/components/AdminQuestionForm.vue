<template>
    <div class="">
        <div>
            <div class="mb-3">
                <label :for="'question-'+id" class="font-semibold">Question</label>
                <input
                    :id="'question-'+id" 
                    class="input w-full mt-1" 
                    type="text" 
                    placeholder="Add a question"
                    :value="question" 
                    @input="$emit('update:question', $event.target.value)"
                >
            </div>
            <div class="mb-3">
                <label :for="'answer-'+id" class="font-semibold">Answer</label>
                <textarea 
                    :id="'answer-'+id"
                    class="input w-full mt-1"
                    type="text" 
                    placeholder="Add a answer" 
                    :value="answer" 
                    @input="$emit('update:answer', $event.target.value)"
                ></textarea>
            </div>
        </div>
        <div class="flex justify-between items-center mt-5">
            <slot name="actions"></slot>
        </div>
    </div>
</template>
<script setup>
    defineProps(['id', 'answer', 'question']);
</script>