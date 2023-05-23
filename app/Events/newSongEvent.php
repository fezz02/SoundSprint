<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Lobby;

class newSongEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Lobby $lobby;
    private \Illuminate\Support\Carbon $nextSeconds;

    /**
     * Create a new event instance.
     */
    public function __construct(Lobby $lobby, \Illuminate\Support\Carbon $nextSeconds)
    {
        $this->lobby = $lobby;
        $this->nextSeconds = $nextSeconds;
    }
    
    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('lobby.new_song.'.$this->lobby->id),
        ];
    }

    public function broadCastWith(){

        $tracks = $this->lobby->playlist->tracks
        ->random(4)
        ->map(function ($track){
            return [
                'track' => [
                    'album' => [
                        'images' => $track?->album?->images?->first()?->toArray()
                    ],
                    'name' => $track?->name,
                    'preview_url' => $track?->preview_url,
                    'artists' => $track?->artists?->toArray(),
                ]
            ];
        });
        //dd($tracks->first()->toArray());

        //$songs = collect($this->lobby->tracks)->filter(fn($item) => $item->track['preview_url'])->random(4);
        /*
        $tracks = \App\Models\Track::where('lobby_id', $this->lobby->id)
            ->get()
            ->random(4)
            ->map(function ($track){
                return [
                    'track' => [
                        'album' => [
                            'images' => $track->track['track']['album']['images']
                        ],
                        'name' => $track->track['track']['name'],
                        'preview_url' => $track->track['track']['preview_url'],
                        'artists' => $track->track['track']['artists'],
                    ]
                ];
            });
        */
        $ritorno = [
            'seconds' => 15,
            'selected' => $tracks->random(1)->toArray()[0],
            'tracks' => $tracks->toArray()
        ];
        //dd($ritorno);
        return $ritorno;
    }

    public function broadcastAs(){
        return 'lobby.new_song';
    }
}
