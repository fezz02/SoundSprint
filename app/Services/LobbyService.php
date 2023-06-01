<?php

namespace App\Services;

use App\Models\Lobby;
use App\Enums\StatusType;
use App\Enums\Game;

class LobbyService {


    public function create(array $fields): Lobby
    {
        $lobby = Lobby::create([
            'playlist_id' => $fields['playlist']->id,
            'current_players' => 0,
            'max_players' => 2,
            'status' => StatusType::PLAYING,
            'game' => Game::GUESS_SONG,
            'next_round_at' => now()->addSeconds(15),
            'timeout_at' => now()->addMinutes(10),
            'started_at' => now(),
            'finished_at' => null,
            
        ]);



        return $lobby;
    }
}