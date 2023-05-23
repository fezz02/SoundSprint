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

class NewSongEvent implements ShouldBroadcast
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
        //dd($this->lobby->playlist->tracks);
        $tracks = $this->lobby->playlist->tracks
        ->filter(fn($track) => $track?->preview_url)
        ->random(4)
        ->map(function ($track){
            return [
                'track' => [
                    'album' => [
                        'images' => $track?->album?->images?->toArray()
                    ],
                    'name' => $track?->name,
                    'preview_url' => $track?->preview_url,
                    'artists' => $track?->artists?->toArray(),
                ]
            ];
        });

        //dd($tracks->filter(fn($track) => dd($track['track'])));

        //dd($tracks->count());
        return [
            'seconds' => 15,
            'selected' => $tracks->random(1)->toArray()[0],
            'tracks' => $tracks->toArray()
        ];
    }

    public function broadcastAs(){
        return 'lobby.new_song';
    }
}
