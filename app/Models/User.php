<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserRole;
use App\Observers\UserObserver;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[ObservedBy([UserObserver::class])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'npm',
        'email',
        'password',
        'role',
        'class_id',
        'is_change_password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
    protected function casts() : array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function class() : BelongsTo
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function schedules() : BelongsToMany
    {
        return $this->belongsToMany(Schedule::class);
    }

    public static function checkAdminCount() : bool
    {
        return self::whereRole(UserRole::Admin)->count() > 1;
    }

    public function isAdmin() : bool
    {
        return $this->role == UserRole::Admin;
    }

    public function isAssistant() : bool
    {
        return $this->role == UserRole::Assistant;
    }

    public function isStudent() : bool
    {
        return $this->role == UserRole::Student;
    }

    public function isRoles($roles) : bool
    {
        return in_array($this->role, $roles);
    }
}
