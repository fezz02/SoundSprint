<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class GameNotFoundException extends Exception {

    public function __construct(string $lobbyCode)
    {
        parent::__construct(trans('exceptions.game_not_found.body', ['code' => $lobbyCode]), Response::HTTP_NOT_FOUND);
    }
}