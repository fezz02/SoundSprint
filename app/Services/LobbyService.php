<?php

namespace App\Services;

use App\Models\Lobby;
use App\Enums\StatusType;
use App\Enums\Game;
use App\Exceptions\Lobby\NoJoinableLobbyException;
use App\Models\User;

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

    public function canJoin(Lobby $lobby, User $user): bool
    {

        if($lobby->isFull()){
            //throw new LobbyIsFullException();
        }

        return true;
    }

    public function getRandomJoinableCode(): string
    {
        return Lobby::query()
            ->inRandomOrder()
            ->select(['code'])
            ->limit(1)
            ->joinable()
            ->firstOr(fn() => throw new NoJoinableLobbyException);
    }
}