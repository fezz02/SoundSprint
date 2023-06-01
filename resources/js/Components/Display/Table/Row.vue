<script setup>
const props = defineProps({
    active: {
        type: Boolean,
        default: false
    }
})
</script>

<template>
    <tr :class="{'active': props.active}">
        <slot/>
    </tr>
</template>