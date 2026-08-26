<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notifications = Notification::with(['user', 'createdBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        $unreadCount = Notification::unread()->count();
        
        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Notification $notification)
    {
        $notification->load(['user', 'createdBy']);
        
        // Mark as read
        if ($notification->read_status === 'unread') {
            $notification->markAsRead();
        }
        
        return view('notifications.show', compact('notification'));
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(Notification $notification)
    {
        $notification->markAsRead();
        
        return redirect()->back()
            ->with('success', 'Notifikasi ditandai sebagai sudah dibaca.');
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        Notification::unread()->update([
            'read_status' => 'read',
            'read_at' => now(),
        ]);
        
        return redirect()->back()
            ->with('success', 'Semua notifikasi ditandai sebagai sudah dibaca.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();
        
        return redirect()->route('notifications.index')
            ->with('success', 'Notifikasi berhasil dihapus.');
    }

    /**
     * Get unread notifications count
     */
    public function getUnreadCount()
    {
        $count = Notification::unread()->forUser(auth()->id())->count();
        return response()->json(['count' => $count]);
    }

    /**
     * Get user notifications (realtime endpoint)
     */
    public function getUserNotifications()
    {
        $notifications = Notification::forUser(auth()->id())
            ->with(['createdBy'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        $unreadCount = Notification::unread()->forUser(auth()->id())->count();
        
        return response()->json([
            'success' => true,
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
            'last_updated' => now()->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * Mark notification as read (AJAX)
     */
    public function markAsReadAjax(Notification $notification)
    {
        if ($notification->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        
        $notification->markAsRead();
        
        return response()->json([
            'success' => true,
            'message' => 'Notifikasi ditandai sebagai sudah dibaca',
            'unread_count' => Notification::unread()->forUser(auth()->id())->count()
        ]);
    }

    /**
     * Mark all notifications as read (AJAX)
     */
    public function markAllAsReadAjax()
    {
        Notification::unread()->forUser(auth()->id())->update([
            'read_status' => 'read',
            'read_at' => now(),
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi ditandai sebagai sudah dibaca',
            'unread_count' => 0
        ]);
    }

}
