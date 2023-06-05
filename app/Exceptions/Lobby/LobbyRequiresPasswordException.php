<?php

namespace App\Exceptions\Lobby;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class LobbyRequiresPasswordException extends LobbyException {

    public function __construct()
    {
        parent::__construct(trans('exceptions.lobby_needs_password.body'), Response::HTTP_UNAUTHORIZED);
    }
}