<?php

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

Broadcast::channel('App.user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('user_{id}', function ($user,$id) {
    return true;
});


Broadcast::channel('messages', function() {
    return true;
});
