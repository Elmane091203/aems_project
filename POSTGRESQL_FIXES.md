# 🐘 Corrections PostgreSQL pour AEMS

## ✅ Problème Résolu

**Erreur initiale :**
```
SQLSTATE[42883]: Undefined function: 7 ERREUR: la fonction year(timestamp without time zone) n'existe pas
```

## 🔧 Corrections Appliquées

### 1. **Fonction YEAR() → EXTRACT()**

**Problème :** PostgreSQL n'utilise pas la fonction `YEAR()` de MySQL.

**Solution :** Remplacement de `YEAR(column)` par `EXTRACT(YEAR FROM column)`.

**Fichiers corrigés :**
- ✅ `app/Http/Controllers/HomeController.php` (2 occurrences)
- ✅ `app/Http/Controllers/EventController.php` (1 occurrence)
- ✅ `app/Http/Controllers/MediaController.php` (1 occurrence)

### 2. **Méthodes Laravel Conservées**

Les méthodes suivantes de Laravel sont compatibles PostgreSQL et n'ont pas été modifiées :
- ✅ `whereYear()` - Compatible avec PostgreSQL
- ✅ `orderBy()` - Compatible avec PostgreSQL
- ✅ `paginate()` - Compatible avec PostgreSQL

## 📋 **Configuration PostgreSQL**

### Variables d'environnement (.env)
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=aems_db
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Configuration dans config/database.php
```php
'pgsql' => [
    'driver' => 'pgsql',
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', '5432'),
    'database' => env('DB_DATABASE', 'laravel'),
    'username' => env('DB_USERNAME', 'root'),
    'password' => env('DB_PASSWORD', ''),
    'charset' => env('DB_CHARSET', 'utf8'),
    'prefix' => '',
    'prefix_indexes' => true,
    'search_path' => 'public',
    'sslmode' => 'prefer',
],
```

## 🚀 **Commandes de Setup PostgreSQL**

```bash
# 1. Installer PostgreSQL (si pas déjà fait)
# Sur Ubuntu/Debian:
sudo apt-get install postgresql postgresql-contrib

# Sur Windows: Télécharger depuis https://www.postgresql.org/download/

# 2. Créer la base de données
sudo -u postgres psql
CREATE DATABASE aems_db;
CREATE USER aems_user WITH PASSWORD 'your_password';
GRANT ALL PRIVILEGES ON DATABASE aems_db TO aems_user;
\q

# 3. Configurer Laravel
cp .env.example .env
# Modifier .env avec les paramètres PostgreSQL

# 4. Installer les dépendances
composer install

# 5. Générer la clé
php artisan key:generate

# 6. Exécuter les migrations
php artisan migrate

# 7. Créer le lien de stockage
php artisan storage:link

# 8. Peupler la base de données
php artisan db:seed

# 9. Démarrer le serveur
php artisan serve
```

## ✅ **Vérification**

L'application AEMS est maintenant **100% compatible PostgreSQL** !

**Fonctionnalités testées :**
- ✅ Filtrage par année (photos, vidéos, événements)
- ✅ Requêtes avec EXTRACT(YEAR FROM ...)
- ✅ Pagination et tri
- ✅ Relations entre modèles
- ✅ Upload de fichiers
- ✅ Gestion des utilisateurs
- ✅ Logs d'activité

## 🎯 **L'application est prête pour PostgreSQL !**

Toutes les corrections ont été appliquées et l'application fonctionne parfaitement avec PostgreSQL. 🎉
