<?php

namespace App\Services;

use App\Models\Lobby;
use App\Enums\Status;
use App\Enums\Game;

class LobbyService {


    public function create(array $fields): Lobby
    {
        $lobby = Lobby::create([
            'playlist_id' => $fields['playlist']->id,
            'current_players' => 0,
            'max_players' => 2,
            'status' => Status::PLAYING,
            'game' => Game::GUESS_SONG,
            'timeout_at' => now()->addMinutes(10),
            'started_at' => now(),
            'finished_at' => null,
            
        ]);



        return $lobby;
    }
}