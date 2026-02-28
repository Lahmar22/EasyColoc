<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EasyColoc – Administration</title>
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
            border-radius: 10px;
            padding: 8px 16px;
            cursor: pointer;
            transition: all .2s;
            border: none;
            font-size: 0.8rem;
        }

        .btn-ban {
            background: linear-gradient(90deg, #ef4444, #dc2626);
            color: #fff;
            font-weight: 600;
            border-radius: 10px;
            padding: 8px 16px;
            cursor: pointer;
            transition: all .2s;
            border: none;
            font-size: 0.8rem;
        }

        .btn-unban {
            background: linear-gradient(90deg, #10b981, #059669);
            color: #fff;
            font-weight: 600;
            border-radius: 10px;
            padding: 8px 16px;
            cursor: pointer;
            transition: all .2s;
            border: none;
            font-size: 0.8rem;
        }

        .tab-active {
            background: linear-gradient(90deg, #0ea5e9, #8b5cf6);
            color: #fff;
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
                {{ Str::upper(substr(Auth::user()->name,0,2)) }}</div>
            <div>
                <p class="text-white font-semibold text-sm">{{ Auth::user()->name }}</p>
                <p class="text-sky-300 text-xs">Admin global</p>
            </div>
        </div>
        <nav class="flex-1 px-4 flex flex-col gap-1">
            <a href="#" class="nav-item active"><span>📊</span> Dashboard</a>
        </nav>
        <div class="h-px bg-white/10 my-3"></div>
        <div class="p-4"><a href="{{ route('logout') }}" class="nav-item justify-center"
                style="background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);color:#fca5a5;"><span>🚪</span>
                Déconnexion</a></div>
    </aside>

    <!-- MAIN -->
    <main class="ml-64 flex-1 p-8 animate-fade-in">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-1">
                <h1 class="text-2xl font-bold text-slate-800">Administration</h1>
                <span class="badge bg-amber-100 text-amber-700">Admin global</span>
            </div>
            <p class="text-slate-500 text-sm">Gestion globale des utilisateurs et de la plateforme</p>
        </div>

        <!-- STATS -->
        <div class="grid grid-cols-4 gap-4 mb-8">
            <div class="glass-white rounded-2xl shadow p-5">
                <p class="text-slate-400 text-xs mb-1">Utilisateurs totaux</p>
                <p class="text-3xl font-extrabold text-slate-800">{{ $totalUsers ?? 0 }}</p>
            </div>
            <div class="glass-white rounded-2xl shadow p-5">
                <p class="text-slate-400 text-xs mb-1">Actifs</p>
                <p class="text-3xl font-extrabold text-emerald-500">{{ $activeUsers ?? 0 }}</p>
            </div>
            <div class="glass-white rounded-2xl shadow p-5">
                <p class="text-slate-400 text-xs mb-1">Bannis</p>
                <p class="text-3xl font-extrabold text-red-500">{{ $bannedUsers ?? 0 }}</p>
            </div>
            <div class="glass-white rounded-2xl shadow p-5">
                <p class="text-slate-400 text-xs mb-1">Colocations actives</p>
                <p class="text-3xl font-extrabold text-sky-600">{{ $activeColocs ?? 0 }}</p>
            </div>
        </div>

        <!-- Tabs -->
        <div class="flex gap-2 mb-6">
            <button onclick="showTab('users')" id="tab-users"
                class="px-5 py-2 rounded-xl text-sm font-semibold tab-active transition-all">Tous les
                utilisateurs</button>
            <button onclick="showTab('banned')" id="tab-banned"
                class="px-5 py-2 rounded-xl text-sm font-semibold text-slate-600 bg-white border border-slate-200 transition-all">Utilisateurs
                bannis</button>
            <button onclick="showTab('colocs')" id="tab-colocs"
                class="px-5 py-2 rounded-xl text-sm font-semibold text-slate-600 bg-white border border-slate-200 transition-all">Colocations</button>
        </div>

        <!-- USERS TABLE -->
        <div id="panel-users" class="glass-white rounded-2xl shadow-xl overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <h2 class="font-bold text-slate-800">Gestion des utilisateurs</h2>
                <form method="GET" action="{{ route('administrateur.dashboard') }}">
                    <input name="q" value="{{ request('q') }}" class="px-3 py-2 rounded-xl border border-slate-200 text-sm outline-none focus:border-sky-400"
                        placeholder="🔍 Rechercher..." />
                </form>
            </div>
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                        <th class="px-5 py-4 text-left">Utilisateur</th>
                        <th class="px-5 py-4 text-left">Email</th>
                        <th class="px-5 py-4 text-left">Rôle</th>
                        <th class="px-5 py-4 text-left">Réputation</th>
                        <th class="px-5 py-4 text-left">Statut</th>
                        <th class="px-5 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users ?? [] as $u)
                        <tr class="hover:bg-slate-50 transition @if($u->is_banned) opacity-60 @endif">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-slate-300 flex items-center justify-center text-slate-700 font-bold text-xs">{{ strtoupper(substr($u->name,0,2)) }}</div>
                                    <span class="font-semibold @if($u->is_banned) text-slate-500 line-through @else text-slate-800 @endif">{{ $u->name }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-slate-500">{{ $u->email }}</td>
                            <td class="px-5 py-4">
                                @if($u->admin_id ?? false)
                                    <span class="badge bg-amber-100 text-amber-700">👑 Admin</span>
                                @else
                                    <span class="badge bg-slate-100 text-slate-600">Membre</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-amber-500 font-bold">{{ $u->reputation_score ?? 0 }} ⭐</td>
                            <td class="px-5 py-4">
                                @if($u->is_banned)
                                    <span class="badge bg-red-100 text-red-600">🚫 Banni</span>
                                @else
                                    <span class="badge bg-emerald-100 text-emerald-700">Actif</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-center">
                                @if($u->is_banned)
                                    <form method="POST" action="{{ route('administrateur.unban', $u->id) }}" style="display:inline;">
                                        @csrf
                                        <button class="btn-unban">✅ Débannir</button>
                                    </form>
                                @elseif(!($u->admin_id ?? false) && $u->id !== Auth::id())
                                    <form method="POST" action="{{ route('administrateur.ban', $u->id) }}" style="display:inline;">
                                        @csrf
                                        <button class="btn-ban">🚫 Bannir</button>
                                    </form>
                                @else
                                    <span class="text-slate-400 text-xs">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-8 text-center text-slate-400">Aucun utilisateur trouvé</td></tr>
                    @endforelse
                </tbody>
            </table>
            <!-- Blocked user notice -->
            <div class="p-4 bg-red-50 border-t border-red-100 mx-0">
                <p class="text-red-700 text-xs font-medium">⚠️ Les utilisateurs bannis sont automatiquement déconnectés
                    et ne peuvent plus accéder à la plateforme.</p>
            </div>
        </div>

        <!-- BANNED PANEL (hidden by default) -->
        <div id="panel-banned" class="hidden glass-white rounded-2xl shadow-xl p-6">
            <h2 class="font-bold text-slate-800 mb-4">🚫 Utilisateurs bannis</h2>
            <div class="flex flex-col gap-3">
                @forelse(($users ?? [])->where('is_banned', 1) as $b)
                    <div class="flex items-center gap-4 p-4 bg-red-50 rounded-xl border border-red-100">
                        <div class="w-10 h-10 rounded-full bg-slate-300 flex items-center justify-center text-slate-600 font-bold text-sm">{{ strtoupper(substr($b->name,0,2)) }}</div>
                        <div class="flex-1">
                            <p class="font-semibold text-slate-700 line-through">{{ $b->name }}</p>
                            <p class="text-slate-400 text-xs">Banni · {{ $b->email }}</p>
                        </div>
                        <form method="POST" action="{{ route('administrateur.unban', $b->id) }}" style="display:inline;">
                            @csrf
                            <button class="btn-unban">✅ Lever le ban</button>
                        </form>
                    </div>
                @empty
                    <p class="text-slate-400 text-center py-8">Aucun utilisateur banni</p>
                @endforelse
            </div>
        </div>

        <!-- COLOCS PANEL -->
        <div id="panel-colocs" class="hidden glass-white rounded-2xl shadow-xl overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                        <th class="px-5 py-4 text-left">Nom</th>
                        <th class="px-5 py-4 text-left">Owner</th>
                        <th class="px-5 py-4 text-left">Membres</th>
                        <th class="px-5 py-4 text-left">Statut</th>
                        <th class="px-5 py-4 text-left">Créée le</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($colocations ?? [] as $c)
                        <tr class="hover:bg-slate-50 transition @if(!$c->status_colocation) opacity-60 @endif">
                            <td class="px-5 py-4 font-semibold @if(!$c->status_colocation) text-slate-500 line-through @else text-slate-800 @endif">{{ $c->name }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $c->owner_name ?? 'Unknown' }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $c->members_count ?? 0 }}</td>
                            <td class="px-5 py-4">@if($c->status_colocation)<span class="badge bg-emerald-100 text-emerald-700">Active</span>@else<span class="badge bg-slate-100 text-slate-500">Cancelled</span>@endif</td>
                            <td class="px-5 py-4 text-slate-400">{{ $c->created_at ? \Carbon\Carbon::parse($c->created_at)->translatedFormat('j M Y') : '' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-8 text-center text-slate-400">Aucune colocation</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

    <script>
        function showTab(tab) {
            ['users', 'banned', 'colocs'].forEach(t => {
                const panel = document.getElementById('panel-' + t);
                const btn = document.getElementById('tab-' + t);
                if (t === tab) {
                    panel.classList.remove('hidden');
                    btn.classList.add('tab-active');
                    btn.classList.remove('text-slate-600', 'bg-white', 'border', 'border-slate-200');
                } else {
                    panel.classList.add('hidden');
                    btn.classList.remove('tab-active');
                    btn.classList.add('text-slate-600', 'bg-white', 'border', 'border-slate-200');
                }
            });
        }
        // init
        document.getElementById('tab-users').classList.add('tab-active');
    </script>

</body>

</html>