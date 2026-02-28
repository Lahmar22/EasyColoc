<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EasyColoc – Dépenses</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { theme: { extend: { colors: { primary: { 50: '#f0f9ff', 300: '#7dd3fc', 400: '#38bdf8', 500: '#0ea5e9', 600: '#0284c7', 700: '#0369a1', 800: '#075985', 900: '#0c4a6e' }, accent: { 400: '#a78bfa', 500: '#8b5cf6', 600: '#7c3aed', 700: '#6d28d9' } }, animation: { 'fade-in': 'fadeIn .4s ease-out' }, keyframes: { fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } } } } } }</script>
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
            max-width: 520px;
            box-shadow: 0 24px 80px rgba(0, 0, 0, 0.2);
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
        }

        .input:focus {
            border-color: #0ea5e9;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.15);
        }

        select.input {
            background: #fff;
        }

        .filter-btn {
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 0.8rem;
            font-weight: 600;
            border: 1.5px solid #e2e8f0;
            background: #fff;
            cursor: pointer;
            transition: all .2s;
            color: #475569;
        }

        .filter-btn.active {
            background: linear-gradient(90deg, #0ea5e9, #8b5cf6);
            color: #fff;
            border-color: transparent;
        }

        .cat-dot {
            width: 10px;
            height: 10px;
            border-radius: 9999px;
            flex-shrink: 0;
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
            <a href="{{ route('user.dashboard') }}" class="nav-item"><span>📊</span> Dashboard</a>
            <a href="{{ route('user.expenses') }}" class="nav-item active"><span>💸</span> Dépenses</a>
            <a href="{{ route('user.payments') }}" class="nav-item"><span>✅</span> Paiements</a>
            
            <a href="{{ route('user.profile') }}" class="nav-item"><span>👤</span> Mon Profil</a>
            
        </nav>
        <div class="p-4"><a href="{{ route('logout') }}" class="nav-item justify-center"
                style="background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);color:#fca5a5;"><span>🚪</span>
                Déconnexion</a></div>
    </aside>

    <!-- MAIN -->
    <main class="ml-64 flex-1 p-8 animate-fade-in">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

    <!-- Title Section -->
    <div>
        <h1 class="text-3xl font-bold text-slate-800 tracking-tight">
            Dépenses
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            Gérez vos dépenses facilement
        </p>
    </div>

    <!-- Buttons Section -->
    <div class="flex flex-col sm:flex-row gap-3">

        <button 
            class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-medium shadow-md hover:shadow-lg hover:scale-105 transition duration-200"
            onclick="document.getElementById('addExpenseModal').style.display='flex'">
            + Ajouter une dépense
        </button>

        <button 
            class="px-5 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-700 font-medium shadow-sm hover:bg-slate-100 hover:shadow-md transition duration-200"
            onclick="document.getElementById('addCategoryModal').style.display='flex'">
            + Ajouter catégorie
        </button>

    </div>

</div>

        
        <!-- FILTERS -->
        <div class="flex items-center gap-3 mb-5 flex-wrap">
            <button class="filter-btn active">Tous</button>
            <button class="filter-btn">Janvier 2025</button>
            <button class="filter-btn">Février 2025</button>
            <button class="filter-btn">Mars 2025</button>
            
        </div>

        <!-- EXPENSE TABLE -->
        <div class="glass-white rounded-2xl shadow-xl overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                        <th class="px-5 py-4 text-left font-semibold">Titre</th>
                        <th class="px-5 py-4 text-left font-semibold">Catégorie</th>
                        <th class="px-5 py-4 text-left font-semibold">Payeur</th>
                        <th class="px-5 py-4 text-left font-semibold">Date</th>
                        <th class="px-5 py-4 text-right font-semibold">Montant</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @if($expenses->isEmpty())
                        <tr>
                            <td colspan="5" class="px-5 py-6 text-center text-slate-500">
                                Aucune dépense enregistrée. Commencez à ajouter des dépenses pour suivre vos finances !
                            </td>
                        </tr>
                    @else
                        @foreach($expenses as $expense)
                        <tr class="hover:bg-slate-50 transition">
                        <td class="px-5 py-4 font-medium text-slate-800 flex items-center gap-2 mt-0.5"><span
                                class="text-lg">🛒</span> {{ $expense->titre }}</td>
                        <td class="px-5 py-4"><span class="badge bg-blue-100 text-blue-600">{{ $expense->category_name }}</span></td>
                        <td class="px-5 py-4 text-slate-600"><span class="badge bg-sky-100 text-sky-700">{{ $expense->user_name }}</span>
                        </td>
                        <td class="px-5 py-4 text-slate-400">{{ $expense->expense_date }}</td>
                        <td class="px-5 py-4 text-right font-bold text-slate-800">{{ number_format($expense->amount, 2, ',', ' ') }} €</td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </main>

    <!-- ADD EXPENSE MODAL -->
    <div id="addExpenseModal" class="modal-overlay" style="display:none"
        onclick="if(event.target===this)this.style.display='none'">
        <div class="modal">
            <h3 class="text-xl font-bold text-slate-800 mb-1">💸 Ajouter une dépense</h3>
            <p class="text-slate-500 text-sm mb-6">La dépense sera partagée équitablement entre tous les membres.</p>
            <div class="flex flex-col gap-4">
                <form action="{{ route('addExpense') }}" method="post">
                    @csrf
                    <div>
                    <label class="text-slate-600 text-xs font-semibold mb-1.5 block">Titre <span
                            class="text-red-400">*</span></label>
                    <input  type="text" name="title" placeholder="Ex: Courses du weekend" class="input" />
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-slate-600 text-xs font-semibold mb-1.5 block">Montant (€) <span
                                class="text-red-400">*</span></label>
                        <input type="number" name="amount" placeholder="0.00" step="0.01" class="input" />
                    </div>
                    <div>
                        <label class="text-slate-600 text-xs font-semibold mb-1.5 block">Date <span
                                class="text-red-400">*</span></label>
                        <input type="date" name="date" class="input" />
                    </div>
                    </div>
                    <div>
                    <label class="text-slate-600 text-xs font-semibold mb-1.5 block">Catégorie <span
                            class="text-red-400">*</span></label>
                    <select name="category_id" class="input">
                        <option value="">Sélectionner...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    </div>
                
                    <div class="flex gap-3 justify-end mt-2">
                        <button
                            class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-medium text-sm hover:bg-slate-50 transition"
                            onclick="document.getElementById('addExpenseModal').style.display='none'">Annuler</button>
                        <button type="submit" class="btn-gradient px-6">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="addCategoryModal" class="modal-overlay" style="display:none"
        onclick="if(event.target===this)this.style.display='none'">
        <div class="modal">
            <h3 class="text-xl font-bold text-slate-800 mb-1">💸 Ajouter une catégorie</h3>
            <p class="text-slate-500 text-sm mb-6">La catégorie sera disponible pour toutes les dépenses de la colocation.</p>
            <div class="flex flex-col gap-4">
                <form action="{{ route('addCategory') }}" method="post">
                    @csrf
                    <div>
                        <label class="text-slate-600 text-xs font-semibold mb-1.5 block">Catégorie <span
                                class="text-red-400">*</span></label>
                        <input type="text" name="category_name" placeholder="Ex: Courses du weekend" class="input" />
                    </div>
                
                    <div class="flex gap-3 justify-end mt-2">
                        <button
                            class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-medium text-sm hover:bg-slate-50 transition"
                            onclick="document.getElementById('addCategoryModal').style.display='none'">Annuler</button>
                        <button type="submit" class="btn-gradient px-6">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>