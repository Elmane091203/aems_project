# Script de déploiement AEMS pour Railway (PowerShell)
Write-Host "🚀 Déploiement AEMS sur Railway..." -ForegroundColor Green

# Installer les dépendances Node.js
Write-Host "📦 Installation des dépendances Node.js..." -ForegroundColor Yellow
npm install

# Compiler les assets
Write-Host "🎨 Compilation des assets CSS/JS..." -ForegroundColor Yellow
npm run build:production

# Vérifier que les assets sont compilés
Write-Host "✅ Vérification des assets compilés..." -ForegroundColor Yellow
if (Test-Path "public/build") {
    Write-Host "✅ Assets compilés trouvés dans public/build/" -ForegroundColor Green
    Get-ChildItem "public/build" | Format-Table
} else {
    Write-Host "❌ Erreur: Assets non compilés" -ForegroundColor Red
    exit 1
}

Write-Host "🎉 Déploiement prêt !" -ForegroundColor Green
Write-Host "📝 N'oubliez pas de commiter et pousser les changements:" -ForegroundColor Cyan
Write-Host "   git add ." -ForegroundColor White
Write-Host "   git commit -m 'Build assets for production'" -ForegroundColor White
Write-Host "   git push" -ForegroundColor White
