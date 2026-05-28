<?php

namespace App\Http\Controllers;

use App\Models\SmartNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = SmartNotification::latest()->get();
        $unreadCount   = SmartNotification::where('is_read', false)->count();
        $criticalCount = SmartNotification::where('severity', 'critical')->where('is_read', false)->count();

        return view('notifications.index', compact('notifications', 'unreadCount', 'criticalCount'));
    }

    public function markRead(SmartNotification $notification)
    {
        $notification->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    public function markAllRead()
    {
        SmartNotification::where('is_read', false)->update(['is_read' => true]);

        return redirect()->back()->with('success', 'All notifications marked as read.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'message'  => 'required|string',
            'type'     => 'required|in:traffic,resource,delivery,system',
            'severity' => 'required|in:info,warning,critical',
            'module'   => 'nullable|string',
        ]);

        SmartNotification::create($request->all());

        return redirect()->route('notifications.index')
            ->with('success', 'Notification created successfully.');
    }

    public function destroy(SmartNotification $notification)
    {
        $notification->delete();

        return redirect()->route('notifications.index')
            ->with('success', 'Notification deleted.');
    }
}
