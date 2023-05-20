<script setup>
const props = defineProps({
    value: {
        type: String,
    },
});
</script>

<template>
    <label class="label">
        {{ props.value }}
    </label>
</template>