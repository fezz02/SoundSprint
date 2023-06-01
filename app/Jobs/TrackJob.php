<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Lobby;

class TrackJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Lobby $lobby;
    private int $seconds;
    /**
     * Create a new job instance.
     */
    public function __construct(Lobby $lobby, int $seconds)
    {
        $this->lobby = $lobby;
        $this->seconds = $seconds;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //$changeTime = now()->clone()->addSeconds(15);

        //$nextRoundInSeconds = now()->addSeconds($this->seconds);
        event(new \App\Events\NewTrackEvent($this->lobby, $this->seconds));

        /*
        $this->lobby->update([
            'next_round_at' => now()->addSeconds($this->seconds) + 1
        ]);
        */

        dispatch(new \App\Jobs\TrackJob($this->lobby, $this->seconds))->delay($this->seconds);
    }
}
