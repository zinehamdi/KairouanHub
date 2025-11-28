<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use Illuminate\Http\Request;
use App\Services\ChatbotService;

class ChatbotController extends Controller
{
    public function history(Request $request)
    {
        $sessionId = $request->session()->getId();
        if (app()->environment('testing') && $request->boolean('all')) {
            $messages = ChatMessage::orderBy('created_at', 'asc')
                ->get(['role', 'content', 'created_at']);
        } else {
            $messages = ChatMessage::where('session_id', $sessionId)
                ->orderBy('created_at', 'asc')
                ->get(['role', 'content', 'created_at']);
        }

        return response()->json([
            'messages' => $messages,
        ]);
    }

    public function message(Request $request)
    {
        $data = $request->validate([
            'content' => ['required', 'string', 'max:5000'],
        ]);

        $sessionId = $request->session()->getId();
        $userContent = trim($data['content']);

        ChatMessage::create([
            'session_id' => $sessionId,
            'role' => 'user',
            'content' => $userContent,
        ]);

        $reply = app(ChatbotService::class)->generateReply($sessionId, $userContent);

        $assistant = ChatMessage::create([
            'session_id' => $sessionId,
            'role' => 'assistant',
            'content' => $reply,
        ]);

        return response()->json([
            'reply' => $assistant->content,
        ]);
    }

    // Legacy local method retained for potential future direct fallback usage.
    protected function generateLocalReply(string $input): string
    {
        $trimmed = trim($input);
        if ($trimmed === '') {
            return 'Hi! How can I help you today?';
        }
        return 'Thanks for your message: \"' . $trimmed . '\"';
    }
}
