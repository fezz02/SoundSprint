<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use SpotifyWebAPI\SpotifyWebAPI;
use SpotifyWebAPI\Session;
use App\Models\Lobby;
use App\Models\Track;

use App\Services\LobbyService;
use App\Services\PlaylistService;

use App\Http\Requests\JoinLobbyRequest;
use App\Http\Requests\SelectSongRequest;

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
        //dd($pps);
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

        $playlistUrl = 'https://open.spotify.com/playlist/33PyRULhtc4SRrUE1wbbmp?si=295abf2b61634194';
        $playlistId = $this->getPlaylistIdFromUrl($playlistUrl);

        $playlist = $api->getPlaylistTracks($playlistId, ['limit' => 4]);
        //dd($playlist->tracks->items[0]->track);

        //$songs = collect($playlist->tracks->items)->filter(fn($item) => $item->track->preview_url);


        //dd($playlist, gettype($playlist));
        $plist = (new PlaylistService())->create($playlist);
        
        $lobby = (new LobbyService())->create([
            'playlist' => $plist
        ]);

        $lobby->load([
            'playlist',
            'playlist.tracks',
            'playlist.tracks.artists',
            'playlist.tracks.album',
            'playlist.tracks.album.images',
            'playlist.tracks.album.artists'
        ]);

        
        // Crea l'handler che invierà l'evento ogni 15 secondi
        dispatch(new \App\Jobs\SongJob($lobby, 15));

        return response()
            ->redirectToRoute('join', ['lobby_code' => $lobby->code]);
    }

    public function join(JoinLobbyRequest $request, string $lobbyCode)
    {

        $lobby = Lobby::query()
            ->with(['users'])
            ->where('code', $lobbyCode)
            ->first();

        
            /*
        if(!$lobby->users->contains(auth()->user())) {
            $lobby->users()->attach(auth()->user());
        }
        */
        
        return Inertia::render('Game', [
            'lobby' => $lobby
        ]);
    }

    public function selectSong(SelectSongRequest $request, string $lobbyCode)
    {
        $lobby = Lobby::query()
            ->with(['users', 'round', 'round.users'])
            ->where('code', $lobbyCode)
            ->first();
        
        $request = $request->validated();

        $trackId = $request['track_id'];
        $userId = auth()->user()->id;

        $guessed = $trackId === $lobby->round->track_id;

        if($lobby->round->users->contains(auth()->user())){
            $lobby->round->users()->detach($userId);
        }
        $lobby->round->users()->attach($userId, ['track_id' => $trackId, 'guessed' => $guessed]);
    }
}
