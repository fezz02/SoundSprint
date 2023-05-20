<script setup>
const props = defineProps({
    disabled: {
        type: Boolean,
        default: false
    },
});
</script>

<template>
    <button class="btn ">
        <slot/>
    </button>
</template>