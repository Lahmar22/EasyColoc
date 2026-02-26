<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EasyColoc – Gérez votre colocation</title>
    <meta name="description" content="EasyColoc : gérez vos dépenses, balances et colocataires facilement." />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 50: '#f0f9ff', 100: '#e0f2fe', 200: '#bae6fd', 300: '#7dd3fc', 400: '#38bdf8', 500: '#0ea5e9', 600: '#0284c7', 700: '#0369a1', 800: '#075985', 900: '#0c4a6e' },
                        accent: { 400: '#a78bfa', 500: '#8b5cf6', 600: '#7c3aed', 700: '#6d28d9' },
                    },
                    animation: {
                        'fade-in': 'fadeIn .5s ease-out',
                        'slide-up': 'slideUp .5s ease-out',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4,0,0.6,1) infinite',
                    },
                    keyframes: {
                        fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
                        slideUp: { '0%': { opacity: '0', transform: 'translateY(20px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        .glass-light {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }

        .gradient-bg {
            background: linear-gradient(135deg, #0c4a6e 0%, #0369a1 40%, #6d28d9 100%);
        }

        .tab-active {
            background: linear-gradient(90deg, #0ea5e9, #8b5cf6);
            color: #fff;
        }

        .input-base {
            width: 100%;
            padding: .75rem 1rem;
            border-radius: .75rem;
            background: rgba(255, 255, 255, .1);
            border: 1px solid rgba(255, 255, 255, .2);
            color: #fff;
            transition: border-color .15s, box-shadow .15s;
        }

        .input-base::placeholder {
            color: rgba(255, 255, 255, .5);
        }

        .input-base:focus {
            outline: none;
            border-color: #7dd3fc;
            box-shadow: 0 0 0 2px rgba(56, 189, 248, .3);
        }

        .btn-primary {
            width: 100%;
            padding: .75rem;
            border-radius: .75rem;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(90deg, #0ea5e9, #8b5cf6);
            border: none;
            cursor: pointer;
            transition: transform .2s;
        }

        .btn-primary:hover {
            transform: scale(1.05);
        }

        .btn-primary:active {
            transform: scale(0.95);
        }

        .feature-card {
            background: rgba(255, 255, 255, .07);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, .12);
            border-radius: 1rem;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: .75rem;
            transition: transform .3s;
            cursor: default;
        }

        .feature-card:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body class="gradient-bg min-h-screen">

    <!-- Animated blob background -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-primary-500/20 rounded-full blur-3xl animate-pulse-slow">
        </div>
        <div class="absolute top-1/2 -right-32 w-80 h-80 bg-accent-500/20 rounded-full blur-3xl animate-pulse-slow"
            style="animation-delay:1.5s"></div>
        <div class="absolute bottom-0 left-1/3 w-72 h-72 bg-primary-300/10 rounded-full blur-3xl animate-pulse-slow"
            style="animation-delay:3s"></div>
    </div>

    <div class="relative z-10 flex flex-col min-h-screen">

        <!-- NAVBAR -->
        <nav class="fixed top-4 left-1/2 -translate-x-1/2 w-[95%] max-w-7xl z-50">
    <div class="bg-white/[0.03] backdrop-blur-xl border border-white/10 px-6 py-3 rounded-2xl flex items-center justify-between shadow-2xl">
        
        <div class="flex items-center gap-3 group cursor-pointer">
            <div class="p-1.5 bg-white/5 rounded-lg border border-white/10 group-hover:border-primary-500/50 transition-colors">
                <img src="{{ asset('images/easyColocLogo.png') }}" alt="logo" class="h-9 w-auto object-contain">
            </div>
            <span class="text-white font-bold text-xl tracking-tight italic">
                Easy<span class="text-primary-400">Coloc</span>
            </span>
        </div>

        <div class="flex items-center gap-8">
            <a href="{{ route('login') }}" 
               class="text-slate-300 text-sm font-medium hover:text-white transition-all duration-300">
                Se connecter
            </a>
            
            <a href="{{ route('register') }}" 
               class="bg-primary-600 hover:bg-primary-500 text-white text-sm font-bold px-6 py-2.5 rounded-xl transition-all duration-300 shadow-lg shadow-primary-600/20 active:scale-95">
                S'inscrire
            </a>
        </div>
    </div>
</nav>

<div class="h-24"></div>

        <!-- HERO + AUTH -->
        <div
            class="flex-1 flex flex-col lg:flex-row items-center justify-center gap-12 px-6 py-16 max-w-7xl mx-auto w-full">

            <!-- Hero Text -->
            <div class="flex-1 animate-fade-in">
                <div
                    class="inline-flex items-center gap-2 glass rounded-full px-4 py-2 text-primary-300 text-sm font-medium mb-6">
                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                    Gestion de colocation simplifiée
                </div>
                <h1 class="text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-6">
                    Gérez votre<br />
                    <span
                        class="bg-gradient-to-r from-primary-300 to-accent-400 bg-clip-text text-transparent">colocation</span><br />
                    sans stress
                </h1>
                <p class="text-white/70 text-lg mb-8 leading-relaxed">
                    Dépenses partagées, balances automatiques, réputation des colocataires — tout en un seul endroit.
                </p>

                <!-- Feature pills -->
                <div class="flex flex-wrap gap-3 mb-10">
                    <span class="glass rounded-full px-4 py-2 text-white/80 text-sm">💸 Dépenses partagées</span>
                    <span class="glass rounded-full px-4 py-2 text-white/80 text-sm">⚖️ Balances automatiques</span>
                    <span class="glass rounded-full px-4 py-2 text-white/80 text-sm">⭐ Système de réputation</span>
                    <span class="glass rounded-full px-4 py-2 text-white/80 text-sm">📊 Statistiques</span>
                </div>
            </div>

            
        </div>

        <footer class="glass px-6 py-6 text-center text-white/40 text-sm">
            © 2025 EasyColoc · Tous droits réservés
        </footer>
    </div>

    <script>
        function switchTab(tab) {
            const loginForm = document.getElementById('loginForm');
            const registerForm = document.getElementById('registerForm');
            const tabLogin = document.getElementById('tab-login');
            const tabRegister = document.getElementById('tab-register');
            if (tab === 'login') {
                loginForm.classList.remove('hidden');
                registerForm.classList.add('hidden');
                tabLogin.classList.add('tab-active');
                tabLogin.classList.remove('text-white/70');
                tabRegister.classList.remove('tab-active');
                tabRegister.classList.add('text-white/70');
            } else {
                registerForm.classList.remove('hidden');
                loginForm.classList.add('hidden');
                tabRegister.classList.add('tab-active');
                tabRegister.classList.remove('text-white/70');
                tabLogin.classList.remove('tab-active');
                tabLogin.classList.add('text-white/70');
            }
        }
    </script>
</body>

</html>
