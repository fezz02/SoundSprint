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

class NewTrackEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Lobby $lobby;
    private int $secondsToNextTrack;

    /**
     * Create a new event instance.
     */
    public function __construct(Lobby $lobby, int $secondsToNextTrack)
    {
        $this->lobby = $lobby;
        $this->secondsToNextTrack = $secondsToNextTrack;
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
            'seconds' => $this->secondsToNextTrack,
            'selected' => $randomTrack->toArray()[0],
            'tracks' => $tracks->toArray()
        ];
    }

    public function broadcastAs(){
        return 'new_track';
    }
}
