<template>
    <div class="mb-2 text-sm text-gray-400 p-3 border text-center">
        Open a question on the dashboard to see changes.
    </div>
    <div class="mb-5 text-sm text-gray-400 p-3 border text-center">
        The bottom paddings is only visible if there are more than one question.
    </div>  
    <div class="flex flex-col sm:flex-row sm:justify-between gap-5">
        <div class="flex-1">
            <div class="mb-3 font-semibold">Padding top</div>
            <div class="flex gap-2">
                <div class="flex-1" v-for="value in paddings">
                    <input 
                        :id="'radio-pt'+value" 
                        type="radio" 
                        name="settings--pt" 
                        class="radio--paddings" 
                        :value="value" 
                        v-model.number="checked.top" 
                        @change="updatePaddings()" 
                        :checked="props.settings['padding-top'] == value ? true : false">
                    <label :for="'radio-pt'+value" class="label--paddings">{{ value }}px</label>
                </div>
            </div>
        </div>
        <div class="flex-1">
            <div class="mb-3 font-semibold">Padding bottom</div>
            <div class="flex gap-2">
                <div class="flex-1" v-for="value in paddings">
                        <input 
                            :id="'radio-pb'+value" 
                            type="radio" 
                            name="settings--pb" 
                            class="radio--paddings" 
                            :value="value" 
                            v-model.number="checked.bottom" 
                            @change="updatePaddings()" 
                            :checked="props.settings['padding-bottom'] == value ? true : false">
                    <label :for="'radio-pb'+value" class="label--paddings">{{ value }}px</label>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
    import { ref, reactive } from 'vue';
    const props = defineProps(['settings']);
    const emit = defineEmits(['updateSettings', 'updateQuestionsList'])
    let paddings = [4,6,8,12];
    const checked = reactive({
        top: props.settings['padding-top'],
        bottom: props.settings['padding-bottom']
    });
    
    function updatePaddings(){
        axios.put('/setting/paddings/update', {
            top: checked.top,
            bottom: checked.bottom
        })
        .then(response => {
            emit('updateSettings')
            emit('updateQuestionsList')
        });
    }
</script>