<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(15);
        Auth::user()->unreadNotifications->markAsRead();
        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        if ($id === 'all') {
            Auth::user()->unreadNotifications->markAsRead();
        } else {
            $notification = Auth::user()->notifications()->findOrFail($id);
            $notification->markAsRead();
        }
        return back();
    }
}
