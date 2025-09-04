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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('original_name');
            $table->string('file_path');
            $table->bigInteger('file_size');
            $table->string('mime_type');
            $table->enum('file_type', ['image', 'video', 'document']);
            $table->string('alt_text')->nullable();
            $table->text('caption')->nullable();
            $table->foreignId('post_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->year('year');
            $table->string('category')->default('general');
            $table->boolean('is_featured')->default(false);
            $table->timestamps();

            $table->index(['file_type', 'year']);
            $table->index(['category', 'year']);
            $table->index(['is_featured', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
