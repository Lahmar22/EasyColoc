<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EasyColoc – Mon Profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { theme: { extend: { colors: { primary: { 50: '#f0f9ff', 300: '#7dd3fc', 400: '#38bdf8', 500: '#0ea5e9', 600: '#0284c7', 700: '#0369a1', 800: '#075985', 900: '#0c4a6e' }, accent: { 400: '#a78bfa', 500: '#8b5cf6', 600: '#7c3aed' } }, animation: { 'fade-in': 'fadeIn .4s ease-out' }, keyframes: { fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } } } } } }</script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .sidebar {
            background: linear-gradient(180deg, #0c4a6e 0%, #0369a1 60%, #6d28d9 100%);
        }

        .glass-white {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(0, 0, 0, 0.06);
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 12px;
            color: rgba(255, 255, 255, 0.7);
            font-weight: 500;
            font-size: 0.875rem;
            cursor: pointer;
            text-decoration: none;
            transition: all .2s;
        }

        .nav-item:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
        }

        .nav-item.active {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .badge {
            font-size: 0.7rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 9999px;
        }

        .btn-gradient {
            background: linear-gradient(90deg, #0ea5e9, #8b5cf6);
            color: #fff;
            font-weight: 600;
            border-radius: 12px;
            padding: 10px 20px;
            cursor: pointer;
            transition: all .2s;
            border: none;
        }

        .input {
            width: 100%;
            padding: 12px 16px;
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            outline: none;
            font-size: 0.9rem;
            transition: border .2s;
            color: #1e293b;
            background: #fff;
        }

        .input:focus {
            border-color: #0ea5e9;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.15);
        }
    </style>
</head>

<body class="bg-slate-100 min-h-screen flex">

    <!-- SIDEBAR -->
    <aside class="sidebar w-64 min-h-screen flex flex-col fixed left-0 top-0 z-30 shadow-2xl">
        <div class="p-6 border-b border-white/10"><a href="index.html" class="flex items-center gap-2"><span
                    class="text-3xl">🏠</span><span class="text-white font-bold text-xl">Easy<span
                        class="text-sky-300">Coloc</span></span></a></div>
        <div class="p-4 mx-4 my-4 rounded-2xl flex items-center gap-3"
            style="background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);">
            <div
                class="w-10 h-10 rounded-full bg-gradient-to-br from-sky-300 to-violet-500 flex items-center justify-center text-white font-bold text-sm">
                {{ strtoupper(substr($user->name,0,2)) }}</div>
            <div>
                <p class="text-white font-semibold text-sm">{{ $user->name }}</p>
                @if($isAdminGlobal)
                <p class="text-sky-300 text-xs">Admin global 👑</p>
                @else
                <p class="text-sky-300 text-xs">Membre de la coloc</p>
                @endif
            </div>
        </div>
        <nav class="flex-1 px-4 flex flex-col gap-1">
            
            <a href="{{ route('user.dashboard') }}" class="nav-item"><span>📊</span> Dashboard</a>
            <a href="{{ route('user.expenses') }}" class="nav-item"><span>💸</span> Dépenses</a>
            <a href="{{ route('user.payments') }}" class="nav-item"><span>✅</span> Paiements</a>
           
            <a href="{{ route('user.profile') }}" class="nav-item active"><span>👤</span> Mon Profil</a>
        </nav>
        <div class="p-4"><a href="{{ route('logout') }}" class="nav-item justify-center"
                style="background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);color:#fca5a5;"><span>🚪</span>
                Déconnexion</a></div>
    </aside>

    <!-- MAIN -->
    <main class="ml-64 flex-1 p-8 animate-fade-in">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-slate-800">Mon Profil</h1>
            <p class="text-slate-500 text-sm mt-1">Gérez vos informations personnelles et votre sécurité</p>
        </div>
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-3 gap-6">
            <!-- Profile Card -->
            <div class="glass-white rounded-2xl shadow-xl p-6 flex flex-col items-center text-center">
                @php
                // compute initials from user name
                $initials = collect(explode(' ', trim($user->name)))->map(function($p){ return strtoupper(substr($p,0,1)); })->join('');
                $joined = optional($user->created_at)->format('d F Y');
                $colocName = $coloc->name ?? '—';
                $statusText = ($membership && $membership->is_active) ? 'Actif' : 'Inactif';
            @endphp
            <div
                    class="w-24 h-24 rounded-full bg-gradient-to-br from-sky-300 to-violet-500 flex items-center justify-center text-white font-extrabold text-3xl shadow-xl mb-4">
                    {{ $initials }}</div>
                <h2 class="font-bold text-slate-800 text-xl">{{ $user->name }}</h2>
                <p class="text-slate-400 text-sm">{{ $user->email }}</p>
                <div class="flex gap-2 mt-3 justify-center flex-wrap">
                    @if($isAdminGlobal)
                        <span class="badge bg-amber-100 text-amber-700">👑 Admin global</span>
                    @endif
                    @if($membership && $membership->role)
                        <span class="badge bg-emerald-100 text-emerald-700">{{ ucfirst($membership->role) }}</span>
                        @if($membership->role === 'admin')
                            <span class="badge bg-purple-100 text-purple-700">Owner</span>
                        @endif
                    @endif
                </div>
                <div class="mt-5 w-full p-4 bg-amber-50 rounded-xl">
                    <p class="text-amber-700 text-sm font-semibold">Réputation ⭐ {{ $reputation }}</p>
                    <p class="text-amber-600 text-xs mt-1">Excellent historique de paiements</p>
                </div>
                <div class="mt-4 w-full text-left space-y-2">
                    <p class="text-slate-500 text-xs"><strong class="text-slate-700">Inscrit depuis :</strong> {{ $joined }}</p>
                    <p class="text-slate-500 text-xs"><strong class="text-slate-700">Colocation active :</strong> {{ $colocName }}</p>
                    <p class="text-slate-500 text-xs"><strong class="text-slate-700">Statut :</strong> <span
                            class="text-emerald-500 font-semibold">{{ $statusText }}</span></p>
                </div>
            </div>

            <!-- Edit forms -->
            <div class="col-span-2 flex flex-col gap-5">

                <!-- Info form -->
                <form method="POST" action="{{ route('user.profile.update') }}" class="glass-white rounded-2xl shadow-xl p-6">
                    @csrf
                    <h3 class="font-bold text-slate-800 text-lg mb-5">✏️ Modifier mes informations</h3>
                    <div class="grid grid-cols-1 gap-4 mb-4">
                        <div>
                            <label class="text-slate-600 text-xs font-semibold mb-1.5 block">Nom Complet</label>
                            <input class="input" type="text" name="first_name" value="{{ explode(' ', trim($user->name))[0] ?? '' }}" />
                        </div> 
                        
                    </div>
                    <div class="mb-4">
                        <label class="text-slate-600 text-xs font-semibold mb-1.5 block">Adresse email</label>
                        <input class="input" type="email" name="email" value="{{ $user->email }}" />
                    </div>
                    <button class="btn-gradient px-6 py-2.5 text-sm">Sauvegarder les modifications</button>
                </form>

                <!-- Password form -->
                <form method="POST" action="{{ route('user.profile.password') }}" class="glass-white rounded-2xl shadow-xl p-6">
                    @csrf
                    <h3 class="font-bold text-slate-800 text-lg mb-5">🔒 Changer mon mot de passe</h3>
                    <div class="flex flex-col gap-4">
                        <div>
                            <label class="text-slate-600 text-xs font-semibold mb-1.5 block">Mot de passe actuel</label>
                            <input class="input" name="current_password" type="password" placeholder="••••••••" required />
                        </div>
                        <div>
                            <label class="text-slate-600 text-xs font-semibold mb-1.5 block">Nouveau mot de
                                passe</label>
                            <input class="input" name="new_password" type="password" placeholder="••••••••" required />
                        </div>
                        <div>
                            <label class="text-slate-600 text-xs font-semibold mb-1.5 block">Confirmer le nouveau mot de
                                passe</label>
                            <input class="input" name="new_password_confirmation" type="password" placeholder="••••••••" required />
                        </div>
                        <button class="btn-gradient px-6 py-2.5 text-sm w-max">Mettre à jour le mot de passe</button>
                    </div>
                </form>

                <!-- Danger zone -->
                <div class="glass-white rounded-2xl shadow-xl p-6 border-2 border-dashed border-red-200">
                    <h3 class="font-bold text-red-600 text-lg mb-2">⚠️ Zone danger</h3>
                    <p class="text-slate-500 text-sm mb-4">La suppression de votre compte est définitive et
                        irréversible.</p>
                    <button
                        class="px-5 py-2.5 rounded-xl bg-white border-2 border-red-400 text-red-600 font-semibold text-sm hover:bg-red-50 transition">
                        🗑️ Supprimer mon compte
                    </button>
                </div>

            </div>
        </div>
    </main>

</body>

</html>