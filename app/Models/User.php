<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function roles() {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id', 'id', 'id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasAbility($ability)
    {
        $roles = Role::whereRaw('roles.id IN (SELECT role_id FROM role_user WHERE user_id = ?)',[
            $this->id
        ])->get();

        foreach ($roles as $role){
            if(in_array($ability, $role->abilities)){
                return true;
            }
        }
        return false;
    }
}
