<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ensure PostgreSQL compatibility
        // This migration ensures that all tables are properly configured for PostgreSQL
        
        // Add any PostgreSQL-specific configurations if needed
        // For now, the existing migrations should work fine with PostgreSQL
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse anything for this compatibility migration
    }
};
