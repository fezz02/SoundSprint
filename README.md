# SoundSprint

## Project Idea (TODO)
SoundSprint is an engaging music game that challenges you to guess the names of random music tracks while listening to them. What makes SoundSprint unique is its direct integration with Spotify, allowing you to use your own personal playlists. You can simultaneously challenge an unlimited number of friends and customize the game with different modes. The score is calculated based on the number of players who fail to guess the song, with a bonus score if you manage to win the game. You can steal points from your opponents and earn a bonus of 5 points. You can also customize challenges and select playlists directly from your Spotify account or as a guest. SoundSprint offers social features such as leaderboards, most played playlists, and a history of challenges with your friends. What truly sets SoundSprint apart is the wide range of challenge options, including the ability to select random playlists based on genres. Additionally, the gameplay experience is further enhanced by a unique visual design that syncs with the music, creating a vibrant disco-like atmosphere. Have fun with SoundSprint and put your music knowledge to the test in a unique and engaging way.
The project is open source and everyone in github can freely help the developing process of the game.

## Developers
- [Federico Palcich](https://www.linkedin.com/in/federico-palcich/) | [website](https://www.fezz.it)

- **[Install project]**
- Clone main repository `git clone https://github.com/fezz02/SoundSprint/tree/main`

- Duplicate .env.example into a new file .env and change the settings as you like: note that you have to create your own pusher account in order to play the game on your local machine
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=spotify_game
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=pusher
QUEUE_CONNECTION=database

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1
```

- Install NPM dependencies `npm install`
- Install Composer packages `composer install`
- Run the vite development server `npm run dev`
- Run the laravel backend server `php artisan serve`
- Run the queue worker `php artisan queue:work`

... more to come...
