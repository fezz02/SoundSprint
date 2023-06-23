<script setup>
import { router } from '@inertiajs/vue3'

import { watch, computed, ref, onMounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Table from '@/Components/Display/Table/Table.vue'
import Row from '@/Components/Display/Table/Row.vue'
import Badge from '@/Components/Display/Badge/Badge.vue'
import Button from '@/Components/Input/Button.vue';

const props = defineProps({
})
</script>

<template>
    <AuthenticatedLayout/>
    <div class="relative grid m-2 place-content-center">
        <div class="grid gap-4 p-2 rounded-lg bg-neutral">
            prova
        </div>
        
    </div>
</template>