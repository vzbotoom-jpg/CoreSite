{{-- resources/views/layouts/guest.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#FFFFFF">
    <title>@yield('title', config('app.name', 'CoreSite'))</title>
    
    <!-- ============================================ -->
    <!-- ANTI-FLICKER SCRIPT - 100% AUTO FOLLOW CHROME -->
    <!-- ============================================ -->
    <script>
        (function() {
            // Detect Chrome theme preference IMMEDIATELY
            const isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            if (isDark) {
                document.documentElement.classList.add('dark');
                const meta = document.querySelector('meta[name="theme-color"]');
                if (meta) meta.content = '#0A0B0E';
            } else {
                document.documentElement.classList.remove('dark');
                const meta = document.querySelector('meta[name="theme-color"]');
                if (meta) meta.content = '#FFFFFF';
            }
        })();
    </script>
    <!-- ============================================ -->
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/css/components.css'])
    @stack('styles')
</head>
<body class="bg-light-bg dark:bg-dark-bg antialiased transition-colors duration-200">
    <!-- Navigation -->
    @include('layouts.partials.guest-nav')
    
    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('layouts.partials.footer')
    
    @vite(['resources/js/app.js', 'resources/js/bootstrap.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')

    <!-- Floating Chat Widget -->
    <div class="coresite-chat-widget" id="coresite-chat-widget">
        <div class="coresite-chat-panel coresite-chat-hidden" id="coresite-chat-panel" role="dialog" aria-label="CorBot.AI chat panel">
            <div class="coresite-chat-panel-header">
                <div class="coresite-chat-panel-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M8 10h8M8 14h5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M4 5.75C4 4.231 5.231 3 6.75 3h10.5C18.769 3 20 4.231 20 5.75v12.5c0 1.519-1.231 2.75-2.75 2.75H8.5L4 22V5.75Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    CorBot.AI
                </div>
                <button type="button" class="coresite-chat-panel-close" id="coresite-chat-close" aria-label="Tutup chat">×</button>
            </div>
            <div class="coresite-chat-panel-body">
                <div class="coresite-chat-messages" id="coresite-chat-messages">
                    <div class="coresite-chat-bubble bot">
                        Halo! Saya CorBot.AI. Apa yang bisa saya bantu tentang CoreSite hari ini?
                    </div>
                </div>
            </div>
            <form class="coresite-chat-form" id="coresite-chat-form">
                <input class="coresite-chat-input" id="coresite-chat-input" type="text" placeholder="Tulis pertanyaanmu..." autocomplete="off" aria-label="Tulis pertanyaan" />
                <button type="submit" class="coresite-chat-submit" aria-label="Kirim pesan">Kirim</button>
            </form>
        </div>

        <button type="button" class="coresite-chat-button" id="coresite-chat-toggle" aria-label="Buka chat CorBot.AI">
            
            <span class="text-white text-[0.56rem] font-semibold uppercase tracking-[0.2em]">Bot.AI</span>
        </button>
    </div>

    <script>
        const chatToggle = document.getElementById('coresite-chat-toggle');
        const chatPanel = document.getElementById('coresite-chat-panel');
        const chatClose = document.getElementById('coresite-chat-close');
        const chatForm = document.getElementById('coresite-chat-form');
        const chatInput = document.getElementById('coresite-chat-input');
        const chatMessages = document.getElementById('coresite-chat-messages');

        const openChat = () => {
            chatPanel.classList.remove('coresite-chat-hidden');
            chatInput.focus();
        };

        const closeChat = () => {
            chatPanel.classList.add('coresite-chat-hidden');
        };

        if (chatToggle && chatPanel) {
            chatToggle.addEventListener('click', openChat);
        }

        if (chatClose && chatPanel) {
            chatClose.addEventListener('click', closeChat);
        }

        if (chatForm && chatInput && chatMessages) {
            const appendMessage = (text, type = 'user') => {
                const bubble = document.createElement('div');
                bubble.className = `coresite-chat-bubble ${type}`;
                bubble.textContent = text;
                chatMessages.appendChild(bubble);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            };

            chatForm.addEventListener('submit', event => {
                event.preventDefault();
                const message = chatInput.value.trim();
                if (!message) return;

                appendMessage(message, 'user');
                chatInput.value = '';
                chatInput.focus();

                setTimeout(() => {
                    appendMessage('Terima kasih. AI sedang memproses jawaban untukmu…', 'bot');
                }, 450);
            });
        }
    </script>
</body>
</html>