<script setup>
import { watch, computed, ref, onMounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Answer from '@/Components/Game/Answer.vue';
import Card from '@/Components/Game/Card.vue';
import Countdown from '@/Components/Game/Countdown.vue';
import Spinner from '@/Components/Loading/Spinner.vue'

import usePresence from '@/Composables/usePresence.js'
import useSong from '@/Composables/useSong.js'


const props = defineProps({
    lobby: {
        type: Object,
        required: true
    }
})

usePresence('presence.lobby.' + props.lobby.id)
const {
    currentSong,
    secondsRemaining,
    maxSeconds,
    songs,
    startRound
} = useSong()

onMounted(() => {
    window.Echo.channel('private.lobby.new_song.' + props.lobby.id)
    .subscribed(() => {
        console.log('subscribed')
    })
    .listen('.lobby.new_song', (data) => {
        console.log('new song')
        console.log(data)
        startRound(data?.tracks, data?.selected, data?.seconds)
    });
})

computed(() => {
    
})

</script>

<template>
    <AuthenticatedLayout/>


    <div>
        <div class="relative grid m-2 place-content-center">
            <div class="w-full h-full p-4 border-2 border-base-100 bg-base-200">
                <div v-if="secondsRemaining <= 0" class="absolute top-0 left-0 z-10 flex items-center justify-center w-full h-full">
                    <Spinner/>
                </div>
                <Countdown :seconds="secondsRemaining" :max-seconds="maxSeconds"/>
                <ul v-if="secondsRemaining > 0" class="grid grid-cols-2 gap-4 border-2 border-base-200">
                    <Answer v-for="song in songs" :url="song?.track?.album?.images[0]?.url">
                        <template #title>{{ song?.track?.name }}</template>
                        <template #artist>
                            {{ song?.track?.artists.map(artist => artist.name).join(', ') }}
                        </template>
                    </Answer>    
                </ul>
                <ul v-else class="grid grid-cols-2 gap-4 border-2 border-base-200">
                    <Answer v-for="song in 4">
                        <template #title>Loading...</template>
                        <template #artist>
                            Please wait...
                        </template>
                    </Answer>    
                </ul>
            </div>
        </div>
    </div>
</template>