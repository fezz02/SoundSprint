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
use App\Models\Round;

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
            new PrivateChannel('lobby.'.$this->lobby->id),
        ];
    }

    public function broadCastWith(){
        //dd($this->lobby->playlist->tracks);
        $tracks = $this->lobby->playlist->tracks
        ->filter(fn($track) => $track?->preview_url)
        ->random(4)
        ->map(function ($track){
            return [
                'id' => $track?->id,
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

        $randomTrack = $tracks->random(1);

        $this->lobby->load([
            'round',
            'round.users'
        ]);

        $lastRound = $this->lobby->round;

        $round = Round::create([
            'lobby_id' => $this->lobby->id,
            'track_id' => $randomTrack[0]['id']
        ]);

        $round->tracks()->sync($tracks->map(fn($tr) => $tr['id']));


        return [
            'last_round' => $lastRound,
            'seconds' => 15,
            'selected' => $randomTrack->toArray()[0],
            'tracks' => $tracks->toArray()
        ];
    }

    public function broadcastAs(){
        return 'new_song';
    }
}
