<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use SpotifyWebAPI\SpotifyWebAPI;
use SpotifyWebAPI\Session;
use App\Models\Lobby;
use App\Models\Track;

class GameController extends Controller {

    public function getPlaylistSongs() {
        $session = new Session(
            config('services.spotify.client_id'),
            config('services.spotify.client_secret'),
            config('services.spotify.redirect_uri')
        );

        $session->requestCredentialsToken();
        $accessToken = $session->getAccessToken();

        $api = new SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        $playlistUrl = 'https://open.spotify.com/playlist/0f7lxe2uiW3coTKP62s1Gz?si=377cadf109944286';
        $playlistId = $this->getPlaylistIdFromUrl($playlistUrl);

        $playlist = $api->getPlaylistTracks($playlistId, ['limit' => 4]);


        //$playlist->songs;

        $randomIds = [0, 45, 12, 23];

        //dd($playlist->tracks->items);
        $pps = [];
        foreach($randomIds as $n){
            $pps[] = $playlist->tracks->items[$n]->track;
        }
        dd($pps);
        return abort(404);
    }

    private function getPlaylistIdFromUrl($url) {
        $parts = explode('/', $url);
        return end($parts);
    }

    public function index() {

        $session = new Session(
            config('services.spotify.client_id'),
            config('services.spotify.client_secret'),
            config('services.spotify.redirect_uri')
        );

        $session->requestCredentialsToken();
        $accessToken = $session->getAccessToken();

        $api = new SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        $playlistUrl = 'https://open.spotify.com/playlist/4JGT5MnoT1vQIfk7Skdvwl?si=aa4635bfe64b47fe';
        $playlistId = $this->getPlaylistIdFromUrl($playlistUrl);

        $playlist = $api->getPlaylistTracks($playlistId, ['limit' => 4]);

        dd($playlist);

        $songs = collect($playlist->tracks->items)->filter(fn($item) => $item->track->preview_url);

        $lobby = Lobby::create([
            
        ]);
        $songs->each(function($song) use ($lobby) {
            Track::create([
                'lobby_id' => $lobby->id,
                'track' => $song
            ]);
        });

        
        /*
        $tracks = \App\Models\Track::where('lobby_id', $lobby->id)
            ->get()
            ->random(4)
            ->map(function ($track){
                dd($track->track['track']['preview_url']);
                return $track->track['preview_url'];
            });
        */
        //dd($tracks);
        

        $songs = $songs->random(4);

        //event(new \App\Events\newSongEvent($lobby));
        //event(new \App\Events\MyEvent('gattooo'));
        // Crea l'handler che invierà l'evento ogni 15 secondi
        dispatch(new \App\Jobs\SongJob($lobby, 15));

        return Inertia::render('Game', [
            'songs' => $songs,
            'lobby' => $lobby
        ]);
    }

    public function prova(){
        $lobbies = Lobby::all();

        $lobbies->each(function($lobby) {
            event(new \App\Events\newSongEvent($lobby));
        });
    }

    public function gatto()
    {
        return Inertia::render('Prova');
    }
}
