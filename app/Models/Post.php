<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'excerpt',
        'featured_image',
        'status',
        'published_at',
        'user_id',
        'category',
        'tags',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'tags' => 'array',
    ];

    /**
     * Get the user that owns the post
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the media files for the post
     */
    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
    }

    /**
     * Scope for published posts
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where('published_at', '<=', now());
    }

    /**
     * Scope for posts by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope for posts by year
     */
    public function scopeByYear($query, $year)
    {
        return $query->whereYear('published_at', $year);
    }
}
