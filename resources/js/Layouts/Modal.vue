<script setup>
import { ref, onMounted, watch } from 'vue';
import { XMarkIcon } from '@heroicons/vue/24/outline';

const emit = defineEmits(['close']);
const props = defineProps({
    state: Boolean,
    additionalClasses: {
        type: String,
        default: '',
    },
});

const modalContent = ref(null);

onMounted(() => {
    window.addEventListener('keydown', (e) => {
        if(e.key === 'Escape') emit('close');;
    });
});

watch(() => props.state, (value) => {
    // condition to prevent error when running SSR
    if (typeof document !== 'undefined') {
        if (value) {
            document.body.style.overflowY = "hidden";
        } else {
            document.body.style.overflowY = "auto";
        }
    }
}, { immediate: true });

const clickOutside = (event) => {
    if(modalContent.value && !modalContent.value.contains(event.target)) {
        emit('close');;
    }
};
</script>

<template>
    <div class="modalBg" v-if="state" @click="(e) => clickOutside(e)">
        <div ref="modalContent" class="relative" :class="additionalClasses">
            <slot />
            <div @click="emit('close')" class="absolute right-2 top-2 h-6 w-6 flex justify-center items-center cursor-pointer hover:text-red-500">
                <XMarkIcon/>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
div.modalBg {
    @apply fixed w-screen inset-0 z-50 flex justify-center items-center bg-black/75;
    height: 100svh;
    backdrop-filter: blur(3px);
}
</style>
