<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Events\NewChatMessage;
use App\Models\ChatMessage;
use App\Models\User;

class ChatController extends Controller
{
    public function getMessages(Request $request)
    {
        $userID = Auth::id();
        $contactID = $request->contact_id;

        $update = ChatMessage::where('sender_id', $contactID)
                        ->where('receiver_id', $userID)
                        ->update(['read' => true]);

        $chat = ChatMessage::where(function($q) use ($userID, $contactID) {
                                $q->where('sender_id', $userID);
                                $q->where('receiver_id', $contactID);
                            })->orWhere(function($q) use ($userID, $contactID) {
                                $q->where('sender_id', $contactID);
                                $q->where('receiver_id', $userID);
                            })->with('sender')->get();

        return $chat;
    }

    public function sendMessage(Request $request)
    {
        try {
            $message = ChatMessage::create([
                                        'sender_id' => Auth::id(),
                                        'receiver_id' => $request->receiver_id,
                                        'message' => $request->message
                                    ]);

            $message->load('sender');

            try {
                broadcast(new NewChatMessage($message))->toOthers();
            } catch (\Exception $e) {
                \Log::error('Broadcast failed but message saved: '.$e->getMessage());
            }
            // $data = $message->load('sender');

            return response()->json([
                'status' => 'success',
                'message' => $message
            ]);
        } catch (\Exception $e) {
            \Log::error('Chat send error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
        
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send message',
                'debug' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function getContacts()
    {
        if (Auth::user()->role === 'admin') {
            return User::where('role', '!=', 'admin')->get();
        }
        
        return User::where('role', 'admin')->get();
    }

    public function markAsRead(ChatMessage $message)
    {
        if ($message->receiver_id === auth()->id()) {
            $message->update(['read' => true]);
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error'], 403);
    }

    public function markMultipleAsRead(Request $request)
    {
        $validated = $request->validate([
            'message_ids' => 'required|array',
            'message_ids.*' => 'integer|exists:chat_messages,id'
        ]);

        ChatMessage::whereIn('id', $validated['message_ids'])
            ->where('receiver_id', auth()->id())
            ->update(['read' => true]);

        return response()->json(['status' => 'success']);
    }
}
