<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*
    * Relations
    */

    /**
    * Get all of the news for the User
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function news(): HasMany
    {
        return $this->hasMany(News::class, 'author_name', 'name');
    }

    /**
        * Get all of the comments for the User
        * @return \Illuminate\Database\Eloquent\Relations\HasMany
        */
    public function comments(): HasMany
    {
            return $this->hasMany(Comment::class, 'author_name', 'name');
    }
}
