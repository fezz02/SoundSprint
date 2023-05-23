import {
  ref
} from 'vue';

export default function() {

  const currentSong = ref(new Audio())
  const secondsRemaining = ref(0)
  const maxSeconds = ref(0)

  const songs = ref([])

  let roundReady = true


  const startRound = (tracks, current, seconds) => {
      /*
      while(!roundReady){
        console.log('round not ready yet')
      }
      */
      songs.value = tracks

      currentSong.value.src = current.track?.preview_url
      currentSong.value.volume = 1
      currentSong.value.play()

      secondsRemaining.value = seconds
      maxSeconds.value = seconds
      roundReady = false


      const timerSeconds =
      setInterval(() => {
          if (secondsRemaining.value > 0) {
              secondsRemaining.value = (secondsRemaining.value - 0.1)
              
              if (secondsRemaining.value <= 5) {
                  //currentSong.value.volume -= 0.01
                  currentSong.value.volume = (currentSong.value.volume - 0.01).toFixed(2)
                  //console.log(currentSong.value.volume)

              }
          } 
          if(secondsRemaining.value <= 0) {
              //currentSong.value.pause()
              console.log('cleared')
              roundReady = true
              clearInterval(timerSeconds)
          }
      }, 100)
    }

  




  return {
      currentSong,
      maxSeconds,
      secondsRemaining,
      songs,
      startRound
  }
}