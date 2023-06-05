<?php

namespace App\Exceptions\Lobby;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class LobbyException extends Exception {

    public function __construct(string $message = 'Exception', int $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        parent::__construct($message, $code);
    }

    public function render(){
        return response()
            ->redirectToRoute('mmk.index')
            ->withErrors($this->getMessage());
    }
}