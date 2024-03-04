<?php

namespace App\Models;
 
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($roleIdOrSlug)
    {
        return $this->roles()->where('id', $roleIdOrSlug)
                            ->orWhere('slug', $roleIdOrSlug)
                            ->exists();
    }

        // /////////////////////////////////////////////////////////

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permissions', 'userID', 'permissionID');
    }
 
    // check if the user have permission 
    public function hasAnyPermission($permissionNames)
        {
            return collect($permissionNames)->contains(fn($name) => $this->permissions->contains('permission_code', $name));
        }


}


// par 9
// raf 11
// zinc 12
//  nails 5 5