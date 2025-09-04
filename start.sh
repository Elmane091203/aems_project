#!/bin/bash

# Script de démarrage pour Railway
echo "🚀 Démarrage de l'application AEMS..."

# Attendre que la base de données soit prête
echo "⏳ Attente de la base de données..."
sleep 5

# Migrer la base de données si nécessaire
echo "🗄️ Migration de la base de données..."
php artisan migrate --force

# Create the storage link
echo "🗄️ Création du lien de stockage..."
php artisan storage:link

# Compile the assets
echo "🗄️ Compilation des assets..."
npm install
npm run build

# Seed the database
echo "🗄️ Peuplement de la base de données..."
php artisan db:seed

# Démarrer le serveur
echo "🌐 Démarrage du serveur Laravel..."
php artisan serve --host=0.0.0.0 --port=$PORT
