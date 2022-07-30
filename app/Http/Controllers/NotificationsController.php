<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    //

    public function index()
    {
        $user = Auth::user();
        return view('admin.notifications', [
            'notifications' => $user->notifications()->paginate(10),
        ]);
    }

    public function show($id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->findOrFail($id);
        $notification->markAsRead();
        if(isset($notification->data['url']) && $notification->data['url']) {
            return redirect($notification->data['url']);
        }
        return redirect()->back();

//        return view('admin.notifications.show', [
//            'notification' => $notification,
//        ]);
    }
}
