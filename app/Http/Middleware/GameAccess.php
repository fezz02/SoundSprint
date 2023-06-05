<?php

namespace App\Http\Middleware;

use App\Models\Lobby;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Exceptions\Lobby\LobbyIsFullException;
use App\Exceptions\Lobby\LobbyPasswordIsIncorrectException;
use App\Exceptions\Lobby\LobbyRequiresPasswordException;
use App\Exceptions\Lobby\LobbyUserNotAllowedException;

class GameAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $lobbyCode = $request->route('lobby_code');
        $lobby = Lobby::where('code', $lobbyCode)
            ->first();
        
        
        if($lobby->isFull())
            throw new LobbyIsFullException();
        

        if(!$lobby->isUserAllowed($request->user()))
            throw new LobbyUserNotAllowedException();
        

        if($lobby->isPrivate()){

            if(!$request->has('password'))
                throw new LobbyRequiresPasswordException();
            

            if(!$lobby->authorize(request()->user(), $request->password))
                throw new LobbyPasswordIsIncorrectException();
            
        }

        return $next($request);
    }
}
