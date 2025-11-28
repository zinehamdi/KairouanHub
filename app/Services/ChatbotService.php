<?php

namespace App\Services;

use App\Models\ChatMessage;
use OpenAI; // from openai-php/client
use Illuminate\Support\Str;
use Throwable;

class ChatbotService
{
    public function generateReply(string $sessionId, string $userContent): string
    {
        $apiKey = config('openai.api_key');
        if (!$apiKey || $apiKey === 'your-openai-api-key-here') {
            return $this->localFallback($userContent);
        }

        $history = ChatMessage::where('session_id', $sessionId)
            ->orderBy('created_at', 'desc')
            ->limit(config('openai.max_history'))
            ->get()
            ->reverse()
            ->values();

        $messages = [
            [
                'role' => 'system',
                'content' => 'You are KairouanHub Assistant, a helpful AI assistant for KairouanHub platform. KairouanHub is a comprehensive service marketplace platform in Kairouan, Tunisia, connecting service providers with customers. The platform offers various categories including restaurants, cafes, fast food, juice bars, bakery, agriculture products, livestock, olive oil products, honey products, traditional food, home services, beauty services, health services, education, transportation, and more. Always respond in a friendly, professional manner. If asked about services, categories, or how the platform works, provide helpful information. Support Arabic, French, and English languages.'
            ]
        ];

        foreach ($history as $msg) {
            $messages[] = [
                'role' => $msg->role === 'assistant' ? 'assistant' : 'user',
                'content' => $msg->content,
            ];
        }
        $messages[] = [
            'role' => 'user',
            'content' => $userContent,
        ];

        try {
            $client = OpenAI::client($apiKey);
            $response = $client->chat()->create([
                'model' => config('openai.model'),
                'messages' => $messages,
                'temperature' => 0.7,
                'max_tokens' => 500,
            ]);
            $reply = $response->choices[0]->message->content ?? '';
            if (!is_string($reply) || trim($reply) === '') {
                return $this->localFallback($userContent);
            }
            return $reply;
        } catch (Throwable $e) {
            \Log::error('ChatGPT API Error: ' . $e->getMessage());
            
            // Check for specific error types
            if (str_contains($e->getMessage(), 'rate limit')) {
                return "I apologize, but I've reached the API rate limit. Please try again in a few moments. In the meantime, I can help you explore KairouanHub services - we offer restaurants, cafes, fast food, agriculture products, and many more categories!";
            }
            
            if (str_contains($e->getMessage(), 'authentication') || str_contains($e->getMessage(), 'API key')) {
                return "There's an issue with the API authentication. Please contact the administrator. Meanwhile, feel free to browse our services and categories!";
            }
            
            return $this->localFallback($userContent);
        }
    }

    protected function localFallback(string $input): string
    {
        $trimmed = strtolower(trim($input));
        
        // Smart responses based on keywords
        if (empty($trimmed)) {
            return "Hello! 👋 I'm the KairouanHub Assistant. I can help you with:\n\n🍽️ Restaurants & Cafes\n🌾 Agriculture & Food Products\n🏠 Home Services\n💇 Beauty & Health\n🚗 Transportation\n\nWhat would you like to know?";
        }
        
        if (str_contains($trimmed, 'service') || str_contains($trimmed, 'category') || str_contains($trimmed, 'خدمة')) {
            return "KairouanHub offers comprehensive services including:\n\n✨ Food Services: Restaurants, cafes, fast food, juice bars, bakery\n🌾 Agriculture: Fresh produce, livestock, olive oil, honey\n🏠 Home: Cleaning, repairs, maintenance\n💇 Beauty & Health: Salons, spas, fitness\n📚 Education & Transportation\n\nWould you like details about any specific category?";
        }
        
        if (str_contains($trimmed, 'food') || str_contains($trimmed, 'restaurant') || str_contains($trimmed, 'طعام')) {
            return "Our food services include:\n\n🍽️ Traditional Tunisian cuisine\n☕ Coffee shops & cafes\n🍔 Fast food & delivery\n🥤 Fresh juice bars\n🥐 Bakery & pastries\n🫒 Olive oil products\n🍯 Natural honey\n\nAll from local providers in Kairouan!";
        }
        
        if (str_contains($trimmed, 'agriculture') || str_contains($trimmed, 'farm') || str_contains($trimmed, 'زراعة')) {
            return "Agricultural products available:\n\n🌾 Fresh vegetables & fruits\n🫒 Premium olive oil\n🍯 Natural honey & bee products\n🐄 Livestock & dairy\n🌿 Organic herbs\n\nSupporting local farmers in Kairouan!";
        }
        
        if (str_contains($trimmed, 'how') || str_contains($trimmed, 'work') || str_contains($trimmed, 'كيف')) {
            return "KairouanHub connects you with local service providers:\n\n1️⃣ Browse services & categories\n2️⃣ View provider profiles & reviews\n3️⃣ Request services directly\n4️⃣ Get matched with quality providers\n\nIt's easy, fast, and reliable!";
        }
        
        return "Thank you for your message! 😊\n\nI'm here to help you discover KairouanHub services. You can ask me about:\n- Available services & categories\n- Food & agriculture products\n- How the platform works\n- Specific service providers\n\nWhat would you like to know?";
    }
}
