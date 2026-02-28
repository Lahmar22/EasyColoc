<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Invitation — EasyColoc</title>
    <!-- Tailwind CDN for quick styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* minimal helper styles (button centering) */
        .ec-btn{display:inline-flex;align-items:center;justify-content:center;padding:.5rem 1rem;border-radius:.375rem}
    </style>
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center p-6">
    <div class="max-w-md w-full bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <h1 class="text-2xl font-semibold text-gray-800 mb-2">Vous êtes invité à rejoindre EasyColoc 🎉</h1>
            <p class="text-gray-600 mb-6">Quelqu'un vous a invité à rejoindre sa colocation. Acceptez pour rejoindre le groupe et commencer à collaborer sur les dépenses et les paiements.</p>

            <div class="flex gap-3">
                <form method="POST" action="{{ url('/accept-invitation') }}" class="flex-1">
                    @csrf
                    <input type="hidden" name="token" value="{{ $invitation->token }}">
                    <button type="submit" class="ec-btn w-full bg-green-600 hover:bg-green-700 text-white focus:outline-none focus:ring-2 focus:ring-green-500">✅ Accepter</button>
                </form>

                <form method="POST" action="{{ url('/refuse-invitation') }}" class="flex-1">
                    @csrf
                    <input type="hidden" name="token" value="{{ $invitation->token }}">
                    <button type="submit" class="ec-btn w-full bg-red-50 hover:bg-red-100 text-red-700 border border-red-200 focus:outline-none focus:ring-2 focus:ring-red-200">❌ Refuser</button>
                </form>
            </div>

            <p class="text-xs text-gray-400 mt-4">Si vous n'attendiez pas cette invitation, vous pouvez ignorer cette page.</p>
        </div>
    </div>
</body>
</html>