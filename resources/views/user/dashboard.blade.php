<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EasyColoc – Ma Colocation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 50: '#f0f9ff', 100: '#e0f2fe', 200: '#bae6fd', 300: '#7dd3fc', 400: '#38bdf8', 500: '#0ea5e9', 600: '#0284c7', 700: '#0369a1', 800: '#075985', 900: '#0c4a6e' },
                        accent: { 400: '#a78bfa', 500: '#8b5cf6', 600: '#7c3aed', 700: '#6d28d9' },
                    },
                    animation: { 'fade-in': 'fadeIn .4s ease-out' },
                    keyframes: { fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } } }
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
            font-size: 0.75rem;
            font-weight: 600;
            padding: 4px 10px;
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

        .btn-gradient:hover {
            transform: scale(1.03);
        }

        .btn-red {
            background: linear-gradient(90deg, #ef4444, #dc2626);
            color: #fff;
            font-weight: 600;
            border-radius: 12px;
            padding: 8px 16px;
            cursor: pointer;
            transition: all .2s;
            border: none;
            font-size: 0.8rem;
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 50;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal {
            background: #fff;
            border-radius: 24px;
            padding: 32px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 24px 80px rgba(0, 0, 0, 0.2);
        }

        .input {
            width: 100%;
            padding: 12px 16px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            outline: none;
            font-size: 0.9rem;
            transition: border .2s;
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
        <div class="p-6 border-b border-white/10">
            <a href="index.html" class="flex items-center gap-2">
                <span class="text-3xl">🏠</span>
                <span class="text-white font-bold text-xl">Easy<span class="text-sky-300">Coloc</span></span>
            </a>
        </div>
        <div class="p-4 mx-4 my-4 rounded-2xl flex items-center gap-3"
            style="background:rgba(255,255,255,0.07);backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,0.12);">
            <div
                class="w-10 h-10 rounded-full bg-gradient-to-br from-sky-300 to-violet-500 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                MD</div>
            <div class="overflow-hidden">
                <p class="text-white font-semibold text-sm truncate">{{ Auth::user()->name }}</p>
                <p class="text-sky-300 text-xs truncate">Membre de la coloc</p>
            </div>
        </div>
        <nav class="flex-1 px-4 flex flex-col gap-1">
            
            <a href="dashboard.html" class="nav-item active"><span>📊</span> Dashboard</a>
           
           
            <a href="profile.html" class="nav-item"><span>👤</span> Mon Profil</a>
        </nav>
         <div class="h-px bg-white/10 my-3"></div>
        <div class="p-4">
            <a href="{{ route('logout') }}" class="nav-item justify-center"
                style="background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);color:#fca5a5;">
                <span>🚪</span> Déconnexion
            </a>
        </div>
    </aside>

    
    <!-- MAIN -->
    <main class="ml-64 flex-1 p-8 animate-fade-in">
        
        <!-- Header -->
        <div class="flex items-start justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Ma Colocation</h1>
                <p class="text-slate-500 text-sm mt-1">Gérez vos membres, invitations et paramètres</p>
            </div>
            <div class="flex gap-3">
                <button class="btn-gradient" onclick="document.getElementById('inviteModal').style.display='flex'">
                    📧 Inviter un membre
                </button>
                <button onclick="document.getElementById('createModal').style.display='flex'"
                    class="px-4 py-2.5 rounded-xl border-2 border-slate-300 text-slate-700 font-semibold text-sm hover:border-sky-400 transition">
                    + Créer une coloc
                </button>
            </div>
        </div>

        

        <!-- Coloc Info Card -->
        <div class="glass-white rounded-2xl shadow-xl p-6 mb-6">
           @if($colocations->count() > 0)
                 @foreach ($colocations as $colocation)
                    <div class="flex items-center justify-between flex-wrap gap-4">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-16 h-16 rounded-2xl bg-gradient-to-br from-sky-400 to-violet-500 flex items-center justify-center text-4xl shadow-lg">
                                🏙️</div>
                            <div>
                                <h2 class="text-xl font-bold text-slate-800">{{ $colocation->name }}</h2>
                                <div class="flex items-center gap-2 mt-1">
                                    @if($colocation->status_colocation)
                                        <span class="badge bg-green-100 text-green-700">Active</span>
                                    @else
                                        <span class="badge bg-red-100 text-red-700">Inactive</span>
                                    @endif
                                    <span class="text-slate-400 text-xs">{{ $colocation->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-6 text-center">
                            
                           
                            <p class="text-2xl font-extrabold text-slate-800">Token d'invitation</p>
    
                            <code id="token-{{ $colocation->id }}"
                                    class="text-xs bg-slate-200 rounded-lg px-2 py-1 flex-1 truncate text-slate-700">
                                    {{ $colocation->token }}
                            </code>

                            <button
                                    onclick="copyToken('token-{{ $colocation->id }}')" 
                                    class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded-lg transition">
                                   <img src="{{ asset('images/copy.png') }}" alt="copy" class="w-3 h-3">
                            </button>

                          
                            
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-slate-500 text-center">aucune colocation</p>
            @endif
        </div>

        <div class="grid grid-cols-3 gap-6">

            <!-- MEMBERS LIST -->
            <div class="col-span-2 glass-white rounded-2xl shadow-xl p-6">
                <h3 class="font-bold text-slate-800 text-lg mb-5">Membres actifs</h3>
                @foreach ($members as $member)
                    <div class="flex flex-col gap-4">
                        <div class="flex items-center gap-4 p-4 rounded-xl bg-slate-50 hover:bg-slate-100 transition">
                            <div
                                class="w-12 h-12 rounded-full bg-gradient-to-br from-sky-300 to-violet-500 flex items-center justify-center text-white font-bold">
                                MD</div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <p class="font-semibold text-slate-800">{{ $member->user_name }}</p>
                                    <span class="badge bg-blue-100 text-blue-700">{{ $member->role }}</span>
                                </div>
                                <p class="text-slate-400 text-xs">{{ $member->user_email }} · Rejoint le {{ $member->joined_at }}</p>
                                <p class="text-amber-600 text-xs font-semibold mt-1">{{ $member->reputation_score }} points de réputation</p>
                            </div>
                            @if($member->utilisateur_id == Auth::id())
                                <span class="badge bg-green-100 text-green-700">Vous</span>
                            @endif
                        </div>
                
                    </div>
                @endforeach

                <!-- Leave coloc -->
                <div class="mt-6 p-4 rounded-xl border-2 border-dashed border-red-200 bg-red-50">
                    <p class="text-slate-600 text-sm mb-3 font-medium">⚠️ Zone danger</p>
                    <div class="flex gap-3 flex-wrap">
                        <button
                            class="px-4 py-2 rounded-xl bg-white border border-red-300 text-red-600 text-sm font-semibold hover:bg-red-50 transition"
                            onclick="document.getElementById('leaveModal').style.display='flex'">
                            🚪 Quitter la colocation
                        </button>

                            <button
                                class="px-4 py-2 rounded-xl bg-white border border-red-300 text-red-600 text-sm font-semibold hover:bg-red-50 transition"
                                onclick="document.getElementById('cancelModal').style.display='flex'">
                                ❌ Annuler la colocation
                            </button>

                    </div>
                </div>
            </div>

            <!-- RIGHT: Pending invites + token -->
            <div class="flex flex-col gap-5">
                <div class="glass-white rounded-2xl shadow-xl p-6">
                    <h3 class="font-bold text-slate-800 text-lg mb-4">Invitations en attente</h3>
                    
                    <div class="flex flex-col gap-3">
                        @foreach($invitations as $invitation)
                            <div
                                class="flex items-center justify-between p-3 bg-yellow-50 rounded-xl border border-yellow-100">
                                <div>
                                    <p class="text-sm font-semibold text-slate-700">{{$invitation->email}}</p>
                                    <p class="text-xs text-slate-400">{{$invitation->created_at}}</p>
                                </div>
                                <span class="badge bg-yellow-100 text-yellow-700">{{$invitation->status}}</span>
                            </div>
                        @endforeach
                    </div>
                    
                    
                    
                </div>
            </div>
        </div>
    </main>

    <!-- ===== MODALS ===== -->

    <!-- Invite Modal -->
    <div id="inviteModal" class="modal-overlay" style="display:none"
        onclick="if(event.target===this)this.style.display='none'">
        <div class="modal">
            <h3 class="text-xl font-bold text-slate-800 mb-2">📧 Inviter un membre</h3>
            <p class="text-slate-500 text-sm mb-6">Un email avec un lien d'invitation sera envoyé.</p>
            <div class="flex flex-col gap-4">
                <form action="{{ route('invitationBymail') }}" method="post">
                    @csrf
                    <div>
                        <label class="text-slate-600 text-xs font-semibold mb-1 block">Adresse email</label>
                        <input type="email" name="email" placeholder="ami@exemple.com" class="input" />
                    </div>
                    <div class="flex gap-3 justify-end">
                        <button
                            class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-medium text-sm hover:bg-slate-50 transition"
                            onclick="document.getElementById('inviteModal').style.display='none'">Annuler</button>
                        <button type="submit" class="btn-gradient text-sm px-6">Envoyer l'invitation</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>

    <!-- Create Coloc Modal -->
    <div id="createModal" class="modal-overlay" style="display:none"
        onclick="if(event.target===this)this.style.display='none'">
        <div class="modal">
            <h3 class="text-xl font-bold text-slate-800 mb-2">🏠 Créer une colocation</h3>
            <p class="text-slate-500 text-sm mb-6">Vous serez automatiquement désigné propriétaire (owner).</p>
            <div class="flex flex-col gap-4">
                <form action="{{ route('createColocation') }}" method="post">
                    @csrf
                    <div>
                        <label class="text-slate-600 text-xs font-semibold mb-1 block">Nom de la colocation</label>
                        <input type="text" name = "name" placeholder="Appart Centre-Ville" class="input" />
                    </div>
                    
                    <div class="flex gap-3 justify-end p-4 pt-6">
                        <button
                            class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-medium text-sm hover:bg-slate-50 transition"
                            onclick="document.getElementById('createModal').style.display='none'">Annuler</button>
                        <button type="submit" class="btn-gradient text-sm px-6">Créer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Remove Member Modal -->
    <div id="removeModal" class="modal-overlay" style="display:none"
        onclick="if(event.target===this)this.style.display='none'">
        <div class="modal">
            <h3 class="text-xl font-bold text-slate-800 mb-2">⚠️ Retirer un membre</h3>
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-5">
                <p class="text-amber-800 text-sm font-medium">Si ce membre a des dettes non réglées, la dette sera
                    imputée à vous (l'owner) — ajustement interne du système.</p>
            </div>
            <p class="text-slate-600 text-sm mb-6">Êtes-vous sûr de vouloir retirer <strong>Thomas Martin</strong> de la
                colocation ?</p>
            <div class="flex gap-3 justify-end">
                <button class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-medium text-sm"
                    onclick="document.getElementById('removeModal').style.display='none'">Annuler</button>
                <button
                    class="px-4 py-2.5 rounded-xl bg-red-500 text-white font-semibold text-sm hover:bg-red-600 transition">Confirmer
                    le retrait</button>
            </div>
        </div>
    </div>

    <!-- Leave Modal -->
    <div id="leaveModal" class="modal-overlay" style="display:none"
        onclick="if(event.target===this)this.style.display='none'">
        <div class="modal">
            <h3 class="text-xl font-bold text-slate-800 mb-2">🚪 Quitter la colocation</h3>
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-5">
                <p class="text-red-700 text-sm font-medium">Si vous avez des dettes, votre réputation baissera de
                    <strong>-1</strong>. Sans dette : <strong>+1</strong>.</p>
            </div>
            <p class="text-slate-600 text-sm mb-6">Votre départ sera enregistré (<code
                    class="bg-slate-100 px-1 rounded">left_at</code> = aujourd'hui).</p>
            <div class="flex gap-3 justify-end">
                <button class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-medium text-sm"
                    onclick="document.getElementById('leaveModal').style.display='none'">Annuler</button>
                <button
                    class="px-4 py-2.5 rounded-xl bg-red-500 text-white font-semibold text-sm hover:bg-red-600 transition">Confirmer
                    le départ</button>
            </div>
        </div>
    </div>

    <!-- Cancel Coloc Modal -->
    <div id="cancelModal" class="modal-overlay" style="display:none"
        onclick="if(event.target===this)this.style.display='none'">
        <div class="modal">
            <h3 class="text-xl font-bold text-slate-800 mb-2">❌ Annuler la colocation</h3>
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-5">
                <p class="text-red-700 text-sm font-medium">Cette action est irréversible. Le statut passera à <code
                        class="bg-red-100 px-1 rounded font-mono">cancelled</code>. L'impact sur la réputation de tous
                    les membres sera calculé selon leurs dettes.</p>
            </div>
            <div class="flex gap-3 justify-end">
                <button class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-medium text-sm"
                    onclick="document.getElementById('cancelModal').style.display='none'">Annuler</button>
                <button
                    class="px-4 py-2.5 rounded-xl bg-red-600 text-white font-semibold text-sm hover:bg-red-700 transition">Annuler
                    définitivement</button>
            </div>
        </div>
    </div>

</body>
<script>
    function copyToken(elementId) {
        const text = document.getElementById(elementId).innerText;

        navigator.clipboard.writeText(text).then(() => { 
            alert("Token copié ");
        }).catch(err => {
            console.error("Erreur de copie", err);
        });
    }
</script>

</html>