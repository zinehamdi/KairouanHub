<div x-data="chatbotWidget()" x-init="init()" class="fixed z-50">
    {{-- Backdrop --}}
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-kairouan-midnight/40 backdrop-blur-md"></div>

    {{-- Chat Window --}}
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
         class="fixed bottom-28 right-6 w-[420px] max-w-[95vw] bg-gradient-to-br from-white via-kairouan-warm-cream/30 to-white rounded-3xl shadow-2xl overflow-hidden border border-accent-DEFAULT/30 backdrop-blur-xl">
        
        {{-- Header with Moroccan pattern --}}
        <div class="relative overflow-hidden bg-gradient-to-br from-accent-DEFAULT via-accent-amber to-kairouan-brass px-6 py-5">
            <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cpath d=&quot;M30 0l5 15h16l-13 9 5 16-13-9-13 9 5-16-13-9h16z&quot; fill=&quot;%23fff&quot; fill-opacity=&quot;1&quot;/%3E%3C/svg%3E');"></div>
            <div class="relative flex items-center justify-between text-white">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">{{ __('KairouanHub Assistant') }}</h3>
                        <p class="text-xs text-white/80">{{ __('AI Powered') }}</p>
                    </div>
                </div>
                <button @click="open=false" 
                        class="w-9 h-9 flex items-center justify-center rounded-xl bg-white/10 hover:bg-white/20 backdrop-blur-sm transition-all duration-200 hover:rotate-90">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        
        {{-- Messages --}}
        <div class="h-[450px] flex flex-col bg-gradient-to-b from-kairouan-warm-cream/20 to-white">
            <div id="chat-scroll" class="flex-1 overflow-y-auto p-5 space-y-4 scrollbar-thin scrollbar-thumb-accent-DEFAULT/20 scrollbar-track-transparent">
                <template x-for="(m, idx) in messages" :key="idx">
                    <div :class="m.role==='user' ? 'flex justify-end' : 'flex justify-start'" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <div :class="m.role==='user' 
                            ? 'bg-gradient-to-br from-accent-DEFAULT to-accent-amber text-white shadow-lg shadow-accent-DEFAULT/20' 
                            : 'bg-white text-brand-dark border-2 border-kairouan-limestone/50 shadow-md'" 
                             class="max-w-[80%] px-5 py-3.5 rounded-2xl font-medium text-[15px] leading-relaxed">
                            <span x-text="m.content" class="whitespace-pre-wrap"></span>
                        </div>
                    </div>
                </template>
                <template x-if="messages.length===0">
                    <div class="flex items-center justify-center h-full">
                        <div class="text-center px-6">
                            <div class="w-20 h-20 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-accent-DEFAULT/10 to-accent-amber/10 flex items-center justify-center">
                                <svg class="w-10 h-10 text-accent-DEFAULT" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                                </svg>
                            </div>
                            <h4 class="font-bold text-lg text-brand-dark mb-2">{{ __('How can I help you today?') }}</h4>
                            <p class="text-sm text-gray-500">{{ __('Ask me anything about KairouanHub services') }}</p>
                        </div>
                    </div>
                </template>
                <template x-if="loading">
                    <div class="flex justify-start">
                        <div class="bg-white border-2 border-kairouan-limestone/50 shadow-md px-5 py-3.5 rounded-2xl">
                            <div class="flex gap-1.5">
                                <div class="w-2 h-2 bg-accent-DEFAULT rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                                <div class="w-2 h-2 bg-accent-DEFAULT rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                                <div class="w-2 h-2 bg-accent-DEFAULT rounded-full animate-bounce" style="animation-delay: 300ms"></div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            
            {{-- Input Form --}}
            <div class="border-t-2 border-kairouan-limestone/30 p-4 bg-white/80 backdrop-blur-sm">
                <form @submit.prevent="send" class="flex gap-3">
                    <input x-model="draft" 
                           type="text" 
                           class="flex-1 border-2 border-kairouan-limestone/50 rounded-2xl px-5 py-3.5 text-[15px] focus:outline-none focus:ring-2 focus:ring-accent-DEFAULT/50 focus:border-accent-DEFAULT transition-all placeholder-gray-400 bg-white" 
                           :placeholder="__('Type your message...')" 
                           :disabled="loading" />
                    <button type="submit" 
                            class="px-6 py-3.5 bg-gradient-to-br from-accent-DEFAULT to-accent-amber text-white font-bold rounded-2xl shadow-lg shadow-accent-DEFAULT/20 hover:shadow-xl hover:shadow-accent-DEFAULT/30 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 transform hover:scale-105 active:scale-95 flex items-center gap-2" 
                            :disabled="loading || draft.trim()===''">
                        <span x-show="!loading">{{ __('Send') }}</span>
                        <span x-show="loading" class="inline-flex items-center">
                            <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                        <svg x-show="!loading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Floating Chat Button --}}
    <button @click="toggle" 
            class="group fixed bottom-6 right-6 bg-gradient-to-br from-accent-DEFAULT via-accent-amber to-kairouan-brass hover:from-kairouan-brass hover:via-accent-amber hover:to-accent-DEFAULT text-white pl-6 pr-7 py-4 rounded-full shadow-2xl hover:shadow-accent-DEFAULT/40 flex items-center gap-3 font-bold transition-all duration-300 transform hover:scale-110 active:scale-95 border-2 border-white/20">
        <div class="relative">
            <svg class="w-7 h-7 transition-transform duration-300 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
            </svg>
            <span x-show="messages.length > 0" class="absolute -top-1 -right-1 w-3 h-3 bg-white rounded-full animate-pulse"></span>
        </div>
        <span class="text-lg">{{ __('Chat') }}</span>
    </button>

    <script>
        function chatbotWidget() {
            return {
                open: false,
                loading: false,
                draft: '',
                messages: [],
                init() {
                    this.fetchHistory();
                },
                toggle() {
                    this.open = !this.open;
                    if (this.open) this.$nextTick(() => this.scrollToBottom());
                },
                csrf() {
                    const el = document.querySelector('meta[name="csrf-token"]');
                    return el ? el.getAttribute('content') : '';
                },
                async fetchHistory() {
                    try {
                        const res = await fetch('{{ route('chatbot.history') }}', { headers: { 'Accept': 'application/json' } });
                        if (res.ok) {
                            const data = await res.json();
                            this.messages = data.messages || [];
                            this.$nextTick(() => this.scrollToBottom());
                        }
                    } catch (e) {
                        console.warn('History error', e);
                    }
                },
                async send() {
                    const content = this.draft.trim();
                    if (!content) return;
                    this.loading = true;
                    const userMsg = { role: 'user', content };
                    this.messages.push(userMsg);
                    this.draft = '';
                    this.$nextTick(() => this.scrollToBottom());
                    try {
                        const res = await fetch('{{ route('chatbot.message') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': this.csrf(),
                            },
                            body: JSON.stringify({ content })
                        });
                        const data = await res.json();
                        const reply = data.reply || '...';
                        this.messages.push({ role: 'assistant', content: reply });
                        this.$nextTick(() => this.scrollToBottom());
                    } catch (e) {
                        this.messages.push({ role: 'assistant', content: 'Sorry, something went wrong.' });
                    } finally {
                        this.loading = false;
                    }
                },
                scrollToBottom() {
                    const el = document.getElementById('chat-scroll');
                    if (el) el.scrollTop = el.scrollHeight;
                }
            }
        }
    </script>
</div>
