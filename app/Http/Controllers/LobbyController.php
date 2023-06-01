<?php

namespace App\Http\Controllers;

use App\Models\Lobby;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Resources\Collections\LobbyResourceCollection;

class LobbyController extends Controller
{
    public function index()
    {

        $lobbies = Lobby::query()
            ->public()
            ->paginate(5);

        
        return Inertia::render('Matchmaking', [
            'lobbies' => new LobbyResourceCollection($lobbies)
        ]);
    }
}
