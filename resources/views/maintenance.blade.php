<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance - AEMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .aems-text-green { color: #1f2937; }
        .aems-year-button { 
            background-color: #f97316; 
            color: white; 
            padding: 0.75rem 1.5rem; 
            border-radius: 0.5rem; 
            text-decoration: none; 
            display: inline-block;
            transition: background-color 0.3s;
        }
        .aems-year-button:hover { background-color: #ea580c; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md mx-auto text-center">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <!-- Logo AEMS -->
            <div class="mb-6">
                <div class="w-20 h-20 bg-green-800 rounded-full mx-auto flex items-center justify-center mb-4">
                    <span class="text-white text-2xl font-bold">AEMS</span>
                </div>
                <h1 class="text-2xl font-bold aems-text-green">Association des Étudiants de Mitsoudjé au Sénégal</h1>
            </div>

            <!-- Maintenance Icon -->
            <div class="text-6xl mb-6">🔧</div>

            <!-- Message -->
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Site en maintenance</h2>
            <p class="text-gray-600 mb-6">
                {{ $message ?? 'Le site est temporairement en maintenance. Nous revenons bientôt !' }}
            </p>

            <!-- Contact Info -->
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <p class="text-sm text-gray-600">
                    Pour toute urgence, contactez-nous :
                </p>
                <p class="text-sm font-medium text-gray-800">
                    {{ config('aems.site.contact_email') }}
                </p>
            </div>

            <!-- Refresh Button -->
            <button onclick="location.reload()" class="aems-year-button">
                Actualiser la page
            </button>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-sm text-gray-500">
            <p>&copy; {{ date('Y') }} AEMS. Tous droits réservés.</p>
        </div>
    </div>

    <!-- Auto-refresh every 30 seconds -->
    <script>
        setTimeout(function() {
            location.reload();
        }, 30000);
    </script>
</body>
</html>
