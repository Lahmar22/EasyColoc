<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EasyColoc – Paiements</title>
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

        .btn-gradient:hover {
            transform: scale(1.03);
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
            max-width: 460px;
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
                MD</div>
            <div class="overflow-hidden">
                <p class="text-white font-semibold text-sm truncate">{{ Auth::user()->name }}</p>
                <p class="text-sky-300 text-xs truncate">Membre de la coloc</p>
            </div>
        </div>
         <nav class="flex-1 px-4 flex flex-col gap-1">
            
            <a href="{{ route('user.dashboard') }}" class="nav-item "><span>📊</span> Dashboard</a>
            <a href="{{ route('user.expenses') }}" class="nav-item"><span>💸</span> Dépenses</a>
            <a href="{{ route('user.payments') }}" class="nav-item active"><span>✅</span> Paiements</a>
           
            <a href="profile.html" class="nav-item"><span>👤</span> Mon Profil</a>
        </nav>
        <div class="p-4"><a href="{{ route('logout') }}" class="nav-item justify-center"
                style="background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);color:#fca5a5;"><span>🚪</span>
                Déconnexion</a></div>
    </aside>

    <!-- MAIN -->
    <main class="ml-64 flex-1 p-8 animate-fade-in">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-slate-800">Paiements &amp; Settlements</h1>
            <p class="text-slate-500 text-sm mt-1">Marquez les dettes comme payées pour mettre à jour les balances</p>
        </div>

        
        <!-- PENDING SETTLEMENTS -->
        <div class="glass-white rounded-2xl shadow-xl p-6 mb-6">
            <h2 class="font-bold text-slate-800 text-lg mb-5">⏳ Settlements en attente</h2>
            <div class="flex flex-col gap-4">
                @if(!empty($due) && count($due) > 0)
                    @foreach($due as $item)
                        @php
                            $from = $item['from'] ?? '—';
                            $to = $item['to'] ?? '—';
                            $amount = $item['amount'] ?? '—';
                            $date = isset($item['payment']->created_at) ? $item['payment']->created_at->format('d M Y') : ($item['payment']->date ?? '—');
                            $initials = strtoupper(substr($from,0,2));
                        @endphp
                        <div class="flex items-center gap-4 p-4 bg-red-50 rounded-xl border border-red-100">
                            <div class="w-12 h-12 rounded-full bg-indigo-200 flex items-center justify-center text-indigo-700 font-bold text-sm">{{ $initials }}</div>
                            <div class="flex-1">
                                <p class="font-semibold text-slate-800">{{ $from }} <span class="text-slate-400 text-xs font-normal">→ doit à →</span> {{ $to }}</p>
                                <p class="text-slate-400 text-xs mt-0.5">Calculé le {{ $date }} · Non payé</p>
                            </div>
                            <div class="text-right mr-4">
                                <p class="font-extrabold text-red-500 text-xl">{{ $amount }} €</p>
                                <span class="badge bg-red-100 text-red-600">En attente</span>
                            </div>
                            <button data-payment-id="{{ $item['payment']->id }}" class="btn-gradient text-sm px-5 py-2.5" onclick="markPaid(this, '{{ $from }} → {{ $to }}', '{{ $amount }} €')">
                                ✅ Marquer payé
                            </button>
                        </div>
                    @endforeach
                @else
                    <div class="p-4 text-sm text-slate-500">Aucune dette en attente.</div>
                @endif
            </div>
        </div>

        <!-- HISTORY -->
        <div class="glass-white rounded-2xl shadow-xl p-6">
            <h2 class="font-bold text-slate-800 text-lg mb-5">📋 Historique des paiements</h2>
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                        <th class="px-4 py-3 text-left font-semibold">De</th>
                        <th class="px-4 py-3 text-left font-semibold">À</th>
                        <th class="px-4 py-3 text-left font-semibold">Date</th>
                        <th class="px-4 py-3 text-right font-semibold">Montant</th>
                        <th class="px-4 py-3 text-center font-semibold">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100" id="historyTable">
                @foreach($payments as $payment)
                    @if($payment->status == true)
                        @php
                            $from = $payment->user_name ?? $payment->from ?? '—';
                            $to = $payment->to ?? '—';
                            $date = isset($payment->created_at) ? $payment->created_at->format('d M Y') : ($payment->date ?? '—');
                            $amount = $payment->amount ?? $payment->montant ?? '—';
                        @endphp
                        <tr class="hover:bg-slate-50 transition">
                        <td class="px-4 py-3 font-medium text-slate-700">{{ $from }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $to }}</td>
                        <td class="px-4 py-3 text-slate-400">{{ $date }}</td>
                        <td class="px-4 py-3 text-right font-bold text-slate-800">{{ $amount }} €</td>
                        <td class="px-4 py-3 text-center"><span class="badge bg-green-100 text-green-600">✓ Payé</span>
                        </td>
                        </tr>
                    @endif
                @endforeach
                    
                    
                </tbody>
            </table>
        </div>
    </main>

    <!-- Confirm Paid Modal -->
    <div id="confirmModal" class="modal-overlay" style="display:none"
        onclick="if(event.target===this)this.style.display='none'">
        <div class="modal shadow-2xl">
            <div class="text-center mb-5">
                <div
                    class="w-16 h-16 mx-auto rounded-full bg-emerald-100 flex items-center justify-center text-4xl mb-3">
                    ✅</div>
                <h3 class="text-xl font-bold text-slate-800">Confirmer le paiement</h3>
            </div>
            <p class="text-slate-600 text-sm text-center mb-2">Settlement : <strong id="modalLabel"></strong></p>
            <p class="text-slate-600 text-sm text-center mb-6">Montant : <strong id="modalAmount"
                    class="text-emerald-600"></strong></p>
            <p class="text-slate-500 text-xs text-center mb-6">Le système mettra à jour les balances automatiquement.
            </p>
            <div class="flex gap-3">
                <button class="flex-1 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-medium text-sm"
                    onclick="document.getElementById('confirmModal').style.display='none'">Annuler</button>
                <button class="flex-1 py-2.5 rounded-xl text-white font-semibold text-sm"
                    style="background:linear-gradient(90deg,#10b981,#059669)"
                    onclick="confirmPayment()">Confirmer</button>
            </div>
        </div>
    </div>

    <script>
        let pendingRow = null;
        const markPaidBase = '{{ url('/user/payments') }}';
        const csrfToken = '{{ csrf_token() }}';
        function markPaid(btn, label, amount) {
            pendingRow = btn.closest('.flex');
            pendingRow.__paymentId = btn.dataset.paymentId || null;
            document.getElementById('modalLabel').textContent = label;
            document.getElementById('modalAmount').textContent = amount;
            document.getElementById('confirmModal').style.display = 'flex';
        }
        function confirmPayment() {
            (async function(){
                if (!pendingRow) return;
                const id = pendingRow.__paymentId;
                if (!id) {
                    // fallback: just update UI
                    applyPaidUI(pendingRow);
                    document.getElementById('confirmModal').style.display = 'none';
                    return;
                }

                try {
                    const res = await fetch(`${markPaidBase}/${id}/mark-paid`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({})
                    });

                    if (res.ok) {
                        applyPaidUI(pendingRow);
                    } else {
                        const json = await res.json().catch(()=>null);
                        alert((json && json.error) ? json.error : 'Échec de la mise à jour');
                    }
                } catch (e) {
                    alert('Erreur réseau');
                } finally {
                    document.getElementById('confirmModal').style.display = 'none';
                }
            })();
        }

        function applyPaidUI(row){
            row.style.opacity = '0.4';
            const btn = row.querySelector('button');
            if (btn) {
                btn.textContent = '✓ Payé';
                btn.disabled = true;
                btn.style.background = '#10b981';
            }
            const card = row.querySelector('.bg-red-50');
            if (card) card.classList.replace('bg-red-50', 'bg-green-50');
        }
    </script>

</body>

</html>