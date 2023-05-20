<script setup>
import { computed } from 'vue'
const props = defineProps({
    maxSeconds: {
        type: Number,
        default: 120
    },
    seconds: {
        type: Number,
        default: 0
    },
})

const percentage = computed(() => {
    return ((props.seconds / props.maxSeconds) * 100)
})
</script>

<template>
    <div class="flex gap-2 place-items-center">

        <progress class="w-full h-4 progress progress-primary" :value="percentage" max="100"/>
        {{ (props.seconds > 0) ? props.seconds.toFixed(0) : 0 }}
        <progress class="w-full h-4 rotate-180 progress progress-primary" :value="percentage" max="100"/>
    </div>
</template>