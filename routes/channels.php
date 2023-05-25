<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('private.lobby.{lobby}', function(App\Models\User $user, App\Models\Lobby $lobby){
    return true;
});

Broadcast::channel('presence.lobby.{lobby}', function (App\Models\User $user, App\Models\Lobby $lobby) {
    //$us = \App\Models\Lobby::findOrFail($lobbyId);
    //$lobby->users()->attach($user);
    return $user;
});
