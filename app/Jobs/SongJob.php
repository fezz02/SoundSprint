<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Lobby;

class SongJob implements ShouldQueue
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

        $nextRoundInSeconds = now()->addSeconds($this->seconds);
        //sleep(now()->diffInSeconds(now()->addSeconds(15)));
        event(new \App\Events\NewSongEvent($this->lobby, $nextRoundInSeconds));
        //dispatch(new \App\Jobs\SongJob($this->lobby));
        dispatch(new \App\Jobs\SongJob($this->lobby, $this->seconds))->delay($nextRoundInSeconds);
    }
}
