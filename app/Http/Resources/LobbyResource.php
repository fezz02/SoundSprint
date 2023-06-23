<?php

namespace App\Http\Resources;

use App\Enums\StatusType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LobbyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_merge(parent::toArray($request), [
            'status' => __('game.lobby.status.'.$this->status->value),
            'joinable' => $this->isUserAllowed($request->user()) && $this->isJoinable()
        ]);
    }
}
