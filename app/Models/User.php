<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property string $role
 * @property string $name
 * @property string $email
 * @property int $id
 * @method bool isAdmin()
 * @method bool isMember()
 * @method bool isVisitor()
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'profile_photo',
        'status',
        'bio',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is member
     */
    public function isMember(): bool
    {
        return $this->role === 'member';
    }

    /**
     * Check if user is visitor
     */
    public function isVisitor(): bool
    {
        return $this->role === 'visitor';
    }

    /**
     * Get user's posts
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get user's events
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Get user's media
     */
    public function media()
    {
        return $this->hasMany(Media::class);
    }

    /**
     * Get user's activity logs
     */
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }
}
