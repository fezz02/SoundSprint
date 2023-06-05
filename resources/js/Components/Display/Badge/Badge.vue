<script setup>
import { computed } from 'vue';
const props = defineProps({
    type: {
        type: String,
        default: 'primary',
    },
    size: {
        type: String,
        default: 'md',
    }
})

const classes = computed(() => {
    return [
        `badge-${props.type}`,
        `badge-${props.size}`
    ]
})


</script>

<template>
    <div class="badge" :class="classes">
        <slot/>
    </div>
</template>