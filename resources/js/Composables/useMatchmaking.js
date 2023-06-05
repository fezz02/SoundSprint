import { router } from '@inertiajs/vue3'

export default function(){

    const joinLobby = (code) => {
        router.visit(route('play.join', code))
    }

    const joinRandomLobby = () => {
        router.visit(route('play.random'))
    }

    return {
        joinLobby,
        joinRandomLobby
    }
}