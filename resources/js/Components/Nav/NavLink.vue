<script setup>
import { Link } from '@inertiajs/vue3';
const props = defineProps({
    name: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <li>
        <a>
            <Link :href="route(props.name)">
                {{ props.label }}
            </Link>
        </a>
    </li>
</template>