<?php

namespace App\Models;

use App\Notifications\UserCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'is_blocked'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
        'is_blocked' => 'boolean',
    ];

    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

    public function isBlocked(): bool
    {
        return $this->is_blocked;
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendUserCreatedNotification()
    {
        $this->notify(new UserCreated);
    }
}
