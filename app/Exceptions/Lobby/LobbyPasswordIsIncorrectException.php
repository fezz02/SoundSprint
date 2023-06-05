<?php

namespace App\Exceptions\Lobby;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class LobbyPasswordIsIncorrectException extends LobbyException {

    public function __construct()
    {
        parent::__construct(trans('exceptions.user_password_not_correct.body'), Response::HTTP_UNAUTHORIZED);
    }
}