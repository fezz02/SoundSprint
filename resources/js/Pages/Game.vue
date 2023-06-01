<script setup>
import { router } from '@inertiajs/vue3'

import { watch, computed, ref, onMounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Answer from '@/Components/Game/Answer.vue';
import Card from '@/Components/Game/Card.vue';
import Countdown from '@/Components/Game/Countdown.vue';
import Spinner from '@/Components/Loading/Spinner.vue'

import useSong from '@/Composables/useSong.js'


const props = defineProps({
    lobby: {
        type: Object,
        required: true
    },
    auth: {
        type: Object,
        required: true
    }
})

const {
    currentSong,
    secondsRemaining,
    maxSeconds,
    songs,
    startRound
} = useSong()

const selected = ref({})

onMounted(() => {
    console.log(props.lobby.id)
    window.Echo.channel('private.lobby.' + props.lobby.id)
    .subscribed(() => {
        console.log('subscribed')
    })
    .listen('.new_track', (data) => {
        selected.value = {};
        console.log(data)
        let guessed = data?.last_round?.users.find(user => user.id === props.auth.user.id)

        console.log((guessed) ? 'you guessed' : 'did not guess')
        startRound(data?.tracks, data?.selected, data?.seconds)
    });
})

computed(() => {
    
})

const guessTrack = (song) => {
    selected.value = song
    router.post(route('play.guessTrack', {lobby_code: props.lobby.code}), {
        track_id: selected.value?.id,
    });
}

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
                    <Answer v-for="song in songs" :key="song?.id" :url="song?.track?.album?.images[0]?.url" :selected="selected?.id === song?.id" @click="guessTrack(song)">
                        <template #title>{{ song?.track?.name }}</template>
                        <template #artist>
                            {{ song?.track?.artists.map(artist => artist.name).join(', ') }}
                        </template>
                    </Answer>    
                </ul>
                <ul v-else class="grid grid-cols-2 gap-4 border-2 border-base-200">
                    <Answer v-for="song in 4">
                        <template #title>{{ $t('game.loading.title') }}</template>
                        <template #artist>{{ $t('game.loading.text') }}</template>
                    </Answer>    
                </ul>
            </div>
        </div>
    </div>
</template>