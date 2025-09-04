<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'location',
        'event_type', // 'culturelle', 'sociale', 'academique'
        'status', // 'upcoming', 'ongoing', 'completed', 'cancelled'
        'featured_image',
        'user_id',
        'max_participants',
        'registration_required',
        'registration_deadline',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'registration_deadline' => 'datetime',
        'registration_required' => 'boolean',
    ];

    /**
     * Get the user that created the event
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for upcoming events
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', now())
                    ->where('status', 'upcoming')
                    ->orderBy('start_date');
    }

    /**
     * Scope for past events
     */
    public function scopePast($query)
    {
        return $query->where('end_date', '<', now())
                    ->where('status', 'completed')
                    ->orderBy('start_date', 'desc');
    }

    /**
     * Scope for events by type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('event_type', $type);
    }

    /**
     * Scope for events by year
     */
    public function scopeByYear($query, $year)
    {
        return $query->whereYear('start_date', $year);
    }

    /**
     * Check if event is upcoming
     */
    public function isUpcoming(): bool
    {
        return $this->start_date > now() && $this->status === 'upcoming';
    }

    /**
     * Check if event is past
     */
    public function isPast(): bool
    {
        return $this->end_date < now() && $this->status === 'completed';
    }

    /**
     * Get event duration in days
     */
    public function getDurationAttribute(): int
    {
        return $this->start_date->diffInDays($this->end_date) + 1;
    }
}
