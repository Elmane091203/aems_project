<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'original_name',
        'file_path',
        'file_size',
        'mime_type',
        'file_type', // 'image', 'video', 'document'
        'alt_text',
        'caption',
        'post_id',
        'user_id',
        'year',
        'category',
        'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    /**
     * Get the post that owns the media
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get the user that uploaded the media
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for images
     */
    public function scopeImages($query)
    {
        return $query->where('file_type', 'image');
    }

    /**
     * Scope for videos
     */
    public function scopeVideos($query)
    {
        return $query->where('file_type', 'video');
    }

    /**
     * Scope for media by year
     */
    public function scopeByYear($query, $year)
    {
        return $query->where('year', $year);
    }

    /**
     * Scope for featured media
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Get the full URL for the media file
     */
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }

    /**
     * Get the file name attribute
     */
    public function getFileNameAttribute(): string
    {
        return $this->original_name ?? $this->filename;
    }

    /**
     * Get the file size in human readable format
     */
    public function getFileSizeAttribute(): int
    {
        return $this->attributes['file_size'] ?? 0;
    }
}
