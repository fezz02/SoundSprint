import { ref } from 'vue';

export default function(channel){
  const players = ref([
      {},
      {},
      {},
      {}
  ])
    window.Echo.join(channel)
     .here((users) => {
          players.value = users
          console.log(users);
     })
     .joining((user) => {
         players.value.push(user)
         console.log(user.name + ' è entrato nel canale');
         //joinLobby(user)
       })
     .leaving((user) => {
         players.value.splice(players.value.indexOf(user), 1)
         console.log(user.name + ' ha lasciato il canale');
         //leaveLobby(user)
     });
}