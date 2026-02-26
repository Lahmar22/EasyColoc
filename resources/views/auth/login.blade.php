<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyColoc - Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd', 
                            400: '#60a5fa', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8'
                        },
                    }
                }
            }
        }
    </script>
    <style>
        /* Adds a soft glowing orb behind the card for depth */
        .glow-orb {
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.3) 0%, rgba(59, 130, 246, 0) 70%);
            border-radius: 50%;
            z-index: 0;
            filter: blur(40px);
        }
    </style>
</head>
<body class="bg-[#0f172a] overflow-hidden">
    
    <div class="relative min-h-screen flex items-center justify-center p-6">
        <div class="glow-orb -top-20 -left-20"></div>
        <div class="glow-orb -bottom-20 -right-20"></div>

        <div class="relative z-10 w-full max-w-md bg-white/[0.03] backdrop-blur-2xl border border-white/10 rounded-3xl shadow-[0_25px_50px_-12px_rgba(0,0,0,0.5)] p-10">
            
            <div class="flex flex-col items-center mb-10">
                <div class="p-3 bg-white/5 rounded-2xl border border-white/10 mb-4 shadow-inner">
                    <img src="{{ asset('images/easyColocLogo.png') }}" alt="logo" class="h-12 w-auto object-contain">
                </div>
               
            </div>

            <form id="loginForm" method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div class="group">
                    <label class="text-slate-300 text-xs font-semibold mb-2 ml-1 block uppercase tracking-wider">
                        Adresse email
                    </label>
                    <div class="relative">
                        <input type="email"
                               id="login-email"
                               name="email"
                               placeholder="vous@exemple.com"
                               class="w-full px-5 py-3.5 rounded-2xl bg-slate-900/50 border border-white/10 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary-500/50 focus:border-primary-500 transition-all duration-300 group-hover:border-white/20">
                    </div>
                </div>

                <div class="group">
                    <div class="flex justify-between items-center mb-2 ml-1">
                        <label class="text-slate-300 text-xs font-semibold block uppercase tracking-wider">
                            Mot de passe
                        </label>
                       
                    </div>
                    <input type="password"
                           id="login-password"
                           name="password"
                           placeholder="••••••••"
                           class="w-full px-5 py-3.5 rounded-2xl bg-slate-900/50 border border-white/10 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary-500/50 focus:border-primary-500 transition-all duration-300 group-hover:border-white/20">
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="remember" class="w-4 h-4 rounded border-white/10 bg-white/5 text-primary-600 focus:ring-offset-slate-900">
                    <label for="remember" class="ml-2 text-sm text-slate-400 cursor-pointer">Se souvenir de moi</label>
                </div>

                <button type="submit"
                        class="w-full py-4 rounded-2xl bg-primary-600 hover:bg-primary-500 text-white font-bold transition-all duration-300 shadow-lg shadow-primary-600/20 active:scale-[0.98]">
                    Se connecter
                </button>
            </form>

            <div class="mt-10 text-center">
                <p class="text-slate-400 text-sm">
                    Pas encore de compte ? 
                    <a href="{{ route('register') }}" class="text-white font-semibold hover:underline decoration-primary-500 underline-offset-4">Inscrivez-vous</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>