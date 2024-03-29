<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Order;

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

Broadcast::channel('Notifications.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('orders', function($user){
    if ($user->type == 'super-admin' || $user->type == 'admin'){
        return true;
    }
    return false;
});

Broadcast::channel('chat', function ($user){
   if($user->type == 'super-admin' || $user->type == 'admin') {
       return $user;
   }
});
