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
                'content' => 'إنت مساعد KairouanHub الذكي. المنصة هاذي موجودة في القيروان، تونس، وتجمع بين مزودي الخدمات والناس اللي يحبو خدمات.

المنصة فيها كل أنواع الخدمات:
- الحرفيين: سباكة، كهرباء، نجارة، طلاء، بناء، تكييف
- الصحة: أطباء، ممرضين، علاج طبيعي، تغذية
- التعليم: دروس خصوصية، تعليم لغات، موسيقى
- المحاماة والمحاسبة: محامين، محاسبين، استشارات
- النقل: سواقين، توصيل، نقل أثاث
- المطاعم والقهاوي: مطاعم تونسية، كوفي شوب، فاست فود، عصائر، حلويات
- الفلاحة: زيت زيتون، عسل، خضر وغلة، منتجات تقليدية
- الأحداث: تصوير، تنظيم حفلات، ديجي
- الجمال: حلاقة، ماكياج، سبا

القيروان مدينة تاريخية فيها الجامع الكبير وفيها تراث غني. المنصة حاليا تخدم غير في القيروان.

جاوب دائما بالتونسي (الدارجة) بطريقة ودية ومحترمة. كون مختصر وواضح. إذا حد سألك على خدمة معينة، وجهو للمكان المناسب في المنصة.'
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
                return "سامحني، وصلت للحد الأقصى. جرب مرة أخرى بعد شوية. 😊\n\nفي الانتظار، تنجم تتصفح الخدمات والمزودين!";
            }
            
            if (str_contains($e->getMessage(), 'authentication') || str_contains($e->getMessage(), 'API key')) {
                return "عندي مشكل تقني. تواصل مع الإدارة. في الوقت هذا، تنجم تشوف الخدمات المتوفرة!";
            }
            
            return $this->localFallback($userContent);
        }
    }

    protected function localFallback(string $input): string
    {
        $trimmed = mb_strtolower(trim($input));
        
        // Smart responses based on keywords in Arabic and English
        if (empty($trimmed)) {
            return "أهلا! 👋 أنا مساعد KairouanHub.\n\nنقدر نعاونك في:\n🔧 حرفيين (سباكة، كهرباء، نجارة...)\n👨‍⚕️ أطباء ومختصين صحة\n📚 أساتذة ودروس خصوصية\n⚖️ محامين ومحاسبين\n🚗 سواقين وتوصيل\n🍽️ مطاعم وقهاوي\n\nشنوة تحب تعرف؟";
        }
        
        // Location questions
        if (str_contains($trimmed, 'وين') || str_contains($trimmed, 'فين') || str_contains($trimmed, 'المكان') || str_contains($trimmed, 'location') || str_contains($trimmed, 'where')) {
            return "المنصة حاليا تخدم غير في القيروان 📍\n\nالقيروان مدينة تاريخية فيها الجامع الكبير والمدينة العتيقة.\n\nإن شاء الله نتوسعو لمدن أخرى قريب!";
        }
        
        // Services questions
        if (str_contains($trimmed, 'خدمة') || str_contains($trimmed, 'خدمات') || str_contains($trimmed, 'service') || str_contains($trimmed, 'شنوة عندكم')) {
            return "عندنا خدمات متنوعة:\n\n🔧 حرفيين: سباكة، كهرباء، نجارة، طلاء، بناء\n👨‍⚕️ صحة: أطباء، ممرضين، علاج طبيعي\n📚 تعليم: دروس خصوصية، لغات\n⚖️ مهنيين: محامين، محاسبين\n🚗 نقل: سواقين، توصيل\n🍽️ مأكولات: مطاعم، قهاوي\n💇 جمال: حلاقة، سبا\n\nتحب تفاصيل على فئة معينة؟";
        }
        
        // Doctor/Medical questions
        if (str_contains($trimmed, 'طبيب') || str_contains($trimmed, 'دكتور') || str_contains($trimmed, 'doctor') || str_contains($trimmed, 'صحة')) {
            return "خدمات الصحة عندنا:\n\n👨‍⚕️ استشارات طبية\n💉 تمريض ورعاية منزلية\n🏥 علاج طبيعي\n🥗 تغذية وحميات\n💪 تدريب شخصي ولياقة\n\nتنجم تشوف المزودين وتطلب خدمة من الموقع!";
        }
        
        // Lawyer questions
        if (str_contains($trimmed, 'محامي') || str_contains($trimmed, 'قانون') || str_contains($trimmed, 'lawyer')) {
            return "عندنا خدمات قانونية:\n\n⚖️ محامين\n📝 استشارات قانونية\n📄 عقود ووثائق\n\nتنجم تشوف المحامين المتوفرين وتتواصل معاهم!";
        }
        
        // Teacher/Education questions
        if (str_contains($trimmed, 'أستاذ') || str_contains($trimmed, 'معلم') || str_contains($trimmed, 'دروس') || str_contains($trimmed, 'teacher') || str_contains($trimmed, 'تعليم')) {
            return "خدمات التعليم عندنا:\n\n📚 دروس خصوصية\n🗣️ تعليم لغات\n🎵 موسيقى وفنون\n🎓 تدريب مهني\n\nتنجم تلقى أستاذ حسب المادة اللي تحبها!";
        }
        
        // Driver questions
        if (str_contains($trimmed, 'سواق') || str_contains($trimmed, 'توصيل') || str_contains($trimmed, 'نقل') || str_contains($trimmed, 'driver') || str_contains($trimmed, 'transport')) {
            return "خدمات النقل عندنا:\n\n🚗 سواقين شخصيين\n📦 توصيل طلبات\n🚚 نقل أثاث\n\nتوفر لك خدمة سريعة وموثوقة!";
        }
        
        // Food questions
        if (str_contains($trimmed, 'مطعم') || str_contains($trimmed, 'أكل') || str_contains($trimmed, 'طعام') || str_contains($trimmed, 'قهوة') || str_contains($trimmed, 'restaurant') || str_contains($trimmed, 'food')) {
            return "خدمات المأكولات عندنا:\n\n🍽️ مطاعم تونسية تقليدية\n☕ قهاوي ومقاهي\n🍔 فاست فود وتوصيل\n🥤 عصائر طازجة\n🥐 حلويات ومخابز\n🫒 زيت زيتون\n🍯 عسل طبيعي\n\nكلها من منتجين محليين في القيروان!";
        }
        
        // How it works
        if (str_contains($trimmed, 'كيفاش') || str_contains($trimmed, 'how') || str_contains($trimmed, 'شلون') || str_contains($trimmed, 'work')) {
            return "KairouanHub ساهل:\n\n1️⃣ تصفح الخدمات والفئات\n2️⃣ شوف ملفات المزودين وتقييماتهم\n3️⃣ اطلب الخدمة مباشرة\n4️⃣ تتواصل مع المزود وتتفاهمو\n\nسريع وموثوق! 💪";
        }
        
        // Greeting
        if (str_contains($trimmed, 'السلام') || str_contains($trimmed, 'مرحبا') || str_contains($trimmed, 'أهلا') || str_contains($trimmed, 'hello') || str_contains($trimmed, 'hi')) {
            return "وعليكم السلام! 😊\n\nأهلا بيك في KairouanHub!\n\nشنوة تحب تسأل؟ نقدر نعاونك تلقى:\n- حرفيين\n- أطباء\n- أساتذة\n- محامين\n- سواقين\n- مطاعم\n\nوبرشة خدمات أخرى!";
        }
        
        return "مرحبا! 😊\n\nنقدر نعاونك تلقى خدمات في القيروان:\n\n🔧 حرفيين\n👨‍⚕️ أطباء\n📚 أساتذة\n⚖️ محامين\n🚗 سواقين\n🍽️ مطاعم\n\nاسأل على أي فئة تحبها!";
    }
}
