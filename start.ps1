# Script de démarrage pour Railway (PowerShell)
Write-Host "🚀 Démarrage de l'application AEMS..." -ForegroundColor Green

# Attendre que la base de données soit prête
Write-Host "⏳ Attente de la base de données..." -ForegroundColor Yellow
Start-Sleep -Seconds 5

# Migrer la base de données si nécessaire
Write-Host "🗄️ Migration de la base de données..." -ForegroundColor Yellow
php artisan migrate --force

# Démarrer le serveur
Write-Host "🌐 Démarrage du serveur Laravel..." -ForegroundColor Yellow
php artisan serve --host=0.0.0.0 --port=$env:PORT
