<?php

namespace App\Http\Resources\Collections;

use Illuminate\Http\Resources\Json\ResourceCollection;
use \Illuminate\Http\Request;

use App\Http\Resources\LobbyResource;

class LobbyResourceCollection extends ResourceCollection
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => LobbyResource::collection($this->collection),
            'columns' => [
                [
                    'field' => 'code',
                    'label' => 'Codice'
                ],
                [
                    'field' => 'privacy',
                    'label' => 'Privacy'
                ],
                [
                    'merge' => [
                        'separator' => ' / ',
                        'columns' => [
                            [
                                'field' => 'current_players',
                                'label' => 'Players'
                            ],
                            [
                                'field' => 'max_players',
                                'label' => 'Max'
                            ]
                        ]
                    ]
                ]
            ],
        ];
    }
}
