<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('visitor')->after('email');
            $table->string('phone')->nullable()->after('role');
            $table->text('address')->nullable()->after('phone');
            $table->string('profile_photo')->nullable()->after('address');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active')->after('profile_photo');
            $table->text('bio')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'address', 'profile_photo', 'status', 'bio']);
        });
    }
};
