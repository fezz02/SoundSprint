<script setup>
import { computed } from 'vue'
const props = defineProps({
    url: {
        type: String,
        required: true,
    },
    selected: {
        type: Boolean,
        default: false
    }
})

const style = computed(() => {
    return {
        'background': `url(${props.url})`,
        'background-size': 'cover',
        'background-position': 'center',
    }
})
</script>

<template>
    <li
        class="grid border-4 cursor-pointer w-36 h-36 sm:w-48 sm:h-48 md:h-64 md:w-64 lg:h-75 lg:w-75 rounded-xl bg-base-300 border-base-300 text-base-content place-items-center"
        :class="{'border-8 border-primary': props.selected, 'hover:border-base-100': !props.selected}"
        :style="style"
    >
        <div class="w-full h-full transition-all delay-100 backdrop-blur-sm hover:backdrop-blur-0 rounded-xl">
            <div class="grid w-full h-full p-2 transition-all delay-100 opacity-90 bg-base-300 hover:opacity-0 place-items-center">
                <h1 class="text-sm text-center lg:text-2xl">
                    <slot name="title"/>
                </h1>
                <p class="text-xs text-center md:text-md">
                    <slot name="artist"/>
                </p>
            </div>
        </div>
    </li>
</template>