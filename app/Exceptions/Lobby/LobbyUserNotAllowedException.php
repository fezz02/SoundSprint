<?php

namespace App\Exceptions\Lobby;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class LobbyUserNotAllowedException extends LobbyException {

    public function __construct()
    {
        parent::__construct(trans('exceptions.user_not_allowed_in_lobby.body'), Response::HTTP_UNAUTHORIZED);
    }
}