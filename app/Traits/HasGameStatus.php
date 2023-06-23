<?php

namespace App\Traits;

use App\Enums\StatusType;
use Illuminate\Database\Eloquent\Builder;

trait HasGameStatus {

    public function scopeJoinable(Builder $query)
    {
        return $query->whereIn('status', config('matchmaking.game.connection.join.status'));
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

    public function isJoinable(){
        return in_array($this->status, config('matchmaking.game.connection.join.status'));
    }
}