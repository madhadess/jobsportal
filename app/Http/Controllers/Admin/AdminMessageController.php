<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\AdminMessage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

class AdminMessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $superAdmin = Admin::whereHas('role', function ($q) {
            $q->where('role_name', 'SUPER_ADMIN');
        })->first();
        $superAdminId = $superAdmin ? $superAdmin->id : 1;

        return view('admin.messages.index', compact('superAdminId'));
    }

    /**
     * Get message history between current user and specified admin
     */
    public function getHistory($adminId)
    {
        $myId = Auth::guard('admin')->user()->id;

        $messages = AdminMessage::where(function ($q) use ($myId, $adminId) {
            $q->where('sender_id', $myId)->where('receiver_id', $adminId);
        })->orWhere(function ($q) use ($myId, $adminId) {
            $q->where('sender_id', $adminId)->where('receiver_id', $myId);
        })
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark incoming messages as read
        AdminMessage::where('sender_id', $adminId)
            ->where('receiver_id', $myId)
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        return response()->json($messages);
    }

    /**
     * Send a new message
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:admins,id',
            'message' => 'required'
        ]);

        $message = AdminMessage::create([
            'sender_id' => Auth::guard('admin')->user()->id,
            'receiver_id' => $request->receiver_id,
            'subject' => $request->subject ?? 'Dahili Mesaj',
            'message' => $request->message,
            'is_read' => 0
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Mesaj başarıyla gönderildi',
            'data' => $message
        ]);
    }

    /**
     * Get unread message count for dashboard
     */
    public function getUnreadCount()
    {
        $count = AdminMessage::where('receiver_id', Auth::guard('admin')->user()->id)
            ->where('is_read', 0)
            ->count();

        return response()->json(['unread_count' => $count]);
    }

    /**
     * Get recent messages for dashboard
     */
    public function getRecentMessages()
    {
        $myId = Auth::guard('admin')->user()->id;

        $messages = AdminMessage::where('receiver_id', $myId)
            ->with('sender')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return response()->json($messages);
    }
}
