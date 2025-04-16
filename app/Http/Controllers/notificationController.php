<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class notificationController extends Controller
{
    public function index() {
        $user = auth()->user();
        $notifications = $user->notifications;

        return view('pages.notification.notification', compact('notifications', 'user'));
    }

    public function markAsRead(Request $request)
    {
        $user = auth()->user();
        $notification = $user->unreadNotifications()->find($request->notification_id);

        if ($notification) {
            $notification->markAsRead();
        }

        return response()->json(['status' => 'success']);
    }


}
