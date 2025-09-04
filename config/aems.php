<?php

return [
    /*
    |--------------------------------------------------------------------------
    | AEMS Application Settings
    |--------------------------------------------------------------------------
    |
    | Configuration settings for the AEMS (Association des Étudiants de 
    | Mitsoudjé au Sénégal) web platform.
    |
    */

    'site' => [
        'name' => env('AEMS_SITE_NAME', 'AEMS'),
        'description' => env('AEMS_SITE_DESCRIPTION', 'Association des Étudiants de Mitsoudjé au Sénégal'),
        'contact_email' => env('AEMS_CONTACT_EMAIL', 'contact@aems.sn'),
        'contact_phone' => env('AEMS_CONTACT_PHONE', '+221 XX XXX XX XX'),
    ],

    'registration' => [
        'enabled' => env('AEMS_REGISTRATION_ENABLED', true),
        'email_verification_required' => env('AEMS_EMAIL_VERIFICATION_REQUIRED', true),
        'default_role' => env('AEMS_DEFAULT_ROLE', 'visitor'),
    ],

    'content' => [
        'posts_per_page' => env('AEMS_POSTS_PER_PAGE', 12),
        'events_per_page' => env('AEMS_EVENTS_PER_PAGE', 12),
        'media_per_page' => env('AEMS_MEDIA_PER_PAGE', 20),
        'max_file_size' => env('AEMS_MAX_FILE_SIZE', 10), // MB
        'allowed_file_types' => env('AEMS_ALLOWED_FILE_TYPES', 'jpeg,png,jpg,gif,mp4,avi,mov,wmv'),
    ],

    'maintenance' => [
        'mode' => env('AEMS_MAINTENANCE_MODE', false),
        'message' => env('AEMS_MAINTENANCE_MESSAGE', 'Le site est temporairement en maintenance. Nous revenons bientôt !'),
    ],

    'activity_logs' => [
        'retention_days' => env('AEMS_ACTIVITY_LOGS_RETENTION_DAYS', 180), // 6 months
        'enabled' => env('AEMS_ACTIVITY_LOGS_ENABLED', true),
    ],

    'storage' => [
        'disk' => env('AEMS_STORAGE_DISK', 'public'),
        'media_path' => env('AEMS_MEDIA_PATH', 'media'),
        'profile_photos_path' => env('AEMS_PROFILE_PHOTOS_PATH', 'profile-photos'),
    ],
];
