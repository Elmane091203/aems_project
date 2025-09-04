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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->string('location');
            $table->enum('event_type', ['culturelle', 'sociale', 'academique']);
            $table->enum('status', ['upcoming', 'ongoing', 'completed', 'cancelled'])->default('upcoming');
            $table->string('featured_image')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('max_participants')->nullable();
            $table->boolean('registration_required')->default(false);
            $table->datetime('registration_deadline')->nullable();
            $table->timestamps();

            $table->index(['status', 'start_date']);
            $table->index(['event_type', 'start_date']);
            $table->index(['start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
