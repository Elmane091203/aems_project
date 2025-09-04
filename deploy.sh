#!/bin/bash

# Script de déploiement AEMS pour Railway
echo "🚀 Déploiement AEMS sur Railway..."

# Installer les dépendances Node.js
echo "📦 Installation des dépendances Node.js..."
npm install

# Compiler les assets
echo "🎨 Compilation des assets CSS/JS..."
npm run build:production

# Vérifier que les assets sont compilés
echo "✅ Vérification des assets compilés..."
if [ -d "public/build" ]; then
    echo "✅ Assets compilés trouvés dans public/build/"
    ls -la public/build/
else
    echo "❌ Erreur: Assets non compilés"
    exit 1
fi

echo "🎉 Déploiement prêt !"
echo "📝 N'oubliez pas de commiter et pousser les changements:"
echo "   git add ."
echo "   git commit -m 'Build assets for production'"
echo "   git push"
