<?php

namespace App\Exceptions\Lobby;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class LobbyIsFullException extends LobbyException {

    public function __construct()
    {
        parent::__construct(trans('exceptions.lobby_full.body'), Response::HTTP_SERVICE_UNAVAILABLE);
    }
}