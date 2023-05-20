<script setup>
const emit = defineEmits(['update:modelValue']);
const props = defineProps({
    modelValue: {
        type: Object,
        default: null,
    },
});
</script>

<template>
    <input
        :value="props.modelValue"

        type="text"
        placeholder="Type here"
        class="input input-bordered w-full lg:max-w-sm"

        @change="emit('update:modelValue', $event.target.value)"
    />
</template>