<?php

namespace App\Traits;

use App\Enums\StatusType;
use Illuminate\Database\Eloquent\Builder;

trait HasGameStatus {

    public function scopeJoinable(Builder $query)
    {
        return $query->whereIn('status', [
            StatusType::QUEUE,
            StatusType::STARTING
        ]);
    }

    public function scopeQueue(Builder $query)
    {
        return $query->where('status', StatusType::QUEUE);
    }

    public function scopeStarting(Builder $query)
    {
        return $query->where('status', StatusType::STARTING);
    }

    public function scopePlaying(Builder $query)
    {
        return $query->where('status', StatusType::PLAYING);
    }

    public function scopeFinished(Builder $query)
    {
        return $query->where('status', StatusType::FINISHED);
    }
}