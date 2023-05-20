<template>
    <div>
      <canvas ref="canvasRef" width="800" height="200"></canvas>
      <button @click="togglePlayback">{{ isPlaying ? 'Pausa' : 'Riproduci' }}</button>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  
  const isPlaying = ref(false);
  const audioContext = new (window.AudioContext || window.webkitAudioContext)();
  const analyser = audioContext.createAnalyser();
  analyser.fftSize = 2048;
  
  const canvasRef = ref(null);
  const bufferLength = analyser.frequencyBinCount;
  const dataArray = new Uint8Array(bufferLength);
  const barWidth = 2;
  const barHeightMultiplier = 0.5;
  
  let audioElement = null;
  let audioSource = null;
  
  onMounted(() => {
    const canvas = canvasRef.value;
    const ctx = canvas.getContext('2d');
  
    
  
    audioElement = new Audio();
    audioElement.src = 'https://p.scdn.co/mp3-preview/fa9c8a009beb5173efbc722460a8a115a3f06304?cid=b817f14761d649389d14d78d3fd339cc';
    audioSource = audioContext.createMediaElementSource(audioElement);
    audioSource.connect(analyser);
    audioSource.connect(audioContext.destination);
  
    audioElement.addEventListener('play', () => {
  isPlaying.value = true;
  drawWaveform();
});

function drawWaveform() {
      analyser.getByteTimeDomainData(dataArray);
  
      ctx.fillStyle = 'white';
      ctx.fillRect(0, 0, canvas.width, canvas.height);
  
      ctx.lineWidth = 2;
      ctx.strokeStyle = 'black';
      ctx.beginPath();
  
      let x = 0;
      for (let i = 0; i < bufferLength; i++) {
        const v = dataArray[i] / 128.0;
        const y = v * canvas.height * barHeightMultiplier;
  
        if (i === 0) {
          ctx.moveTo(x, y);
        } else {
          ctx.lineTo(x, y);
        }
  
        x += barWidth;
      }
  
      ctx.lineTo(canvas.width, canvas.height * 0.5);
      ctx.stroke();
  
      if (isPlaying.value) {
        requestAnimationFrame(drawWaveform);
      }
    }

audioElement.addEventListener('pause', () => {
  isPlaying.value = false;
});
  });
  
  const togglePlayback = () => {
  if (!isPlaying.value) {
    audioContext.resume().then(() => {
      audioElement.play();
      isPlaying.value = true;
      drawWaveform();
    });
  } else {
    audioElement.pause();
    isPlaying.value = false;
  }
}
  </script>
  
  <style>
  canvas {
    background-color: #000;
  }
  </style>
  