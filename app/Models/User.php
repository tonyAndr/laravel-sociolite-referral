<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Enums\OAuthProvider;
use App\Models\Referral;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'oauth_id',
        'oauth_provider',
        'oauth_token',
        'oauth_refresh_token',
        'avatar_url',
        'robux'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'oauth_token',
        'oauth_refresh_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'oauth_provider' => OAuthProvider::class,
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'oauth_token' => 'encrypted',
        'oauth_refresh_token' => 'encrypted',
    ];


    /**
     * Get referrals associated with specified user
     */
    public function referrals()
    {
        return $this->hasMany(Referral::class, 'parent_id');
    }

        /**
     * Get referrals associated with specified user
     */
    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class, 'user_id');
    }

    /**
     * Get referrals associated with specified user
     */
    public function addRobux(int $robux)
    {
        $this->robux = $this->robux + $robux;
        $this->save();
    }

    public function isAdmin(): bool
    {
        return $this->is_admin === 1;
    }
}
