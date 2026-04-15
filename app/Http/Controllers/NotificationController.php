<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Carbon\Carbon;

class NotificationController extends Controller
{
    /**
     * Provide notifications and activity logs for header polling
     */
    public function headerPulse(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['status' => 'unauthenticated'], 401);
        }

        // Get Unread Notifications
        $unreadNotifications = $user->unreadNotifications()->take(10)->get()->map(function($notif) {
            return [
                'id' => $notif->id,
                'title' => $notif->data['title'] ?? 'Notifikasi Baru',
                'message' => $notif->data['message'] ?? '',
                'icon' => $notif->data['icon'] ?? 'fa fa-bell',
                'color' => $notif->data['color'] ?? 'primary', // e.g. success, danger, warning
                'time' => $notif->created_at->diffForHumans(),
                'url' => $notif->data['url'] ?? 'javascript:;'
            ];
        });

        // Get Latest General Activity Logs
        $activities = Activity::latest()->take(10)->get()->map(function($act) {
            $colors = [
                'created' => 'success',
                'updated' => 'info',
                'deleted' => 'danger'
            ];

            return [
                'id' => $act->id,
                'description' => $act->description,
                'subject_type' => class_basename($act->subject_type),
                'causer_name' => $act->causer ? $act->causer->name : 'System',
                'color' => $colors[$act->event] ?? 'primary',
                'time' => $act->created_at->diffForHumans()
            ];
        });

        return response()->json([
            'status' => 'success',
            'unread_count' => $user->unreadNotifications()->count(),
            'notifications' => $unreadNotifications,
            'activities' => $activities
        ]);
    }

    /**
     * Mark a specific notification as read or all if no ID is passed
     */
    public function markAsRead(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['status' => 'error'], 401);
        }

        $id = $request->input('id');
        if ($id) {
            $notification = $user->unreadNotifications()->where('id', $id)->first();
            if ($notification) {
                $notification->markAsRead();
            }
        } else {
            $user->unreadNotifications->markAsRead();
        }

        return response()->json(['status' => 'success']);
    }
}
