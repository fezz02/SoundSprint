<?php

namespace App\Exceptions\Lobby;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class NoJoinableLobbyException extends LobbyException {

    public function __construct()
    {
        parent::__construct(trans('exceptions.no_joinable_lobby.body'), Response::HTTP_NOT_FOUND);
    }
}