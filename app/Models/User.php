<?php

namespace App\Models;

use App\Models\Country;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use Notifiable;
    use HasRoles;
    

    public const LOCALES = [
        'en' => 'English',
        'es' => 'Español',
        'fr' => 'Francais',
        'nl' => 'Dutch',
        'de' => 'Deutsch'
    ];






    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'country_id'
    ];



    public function country()
    {
        return $this->belongsTo(Country::class);
    }



    /**
     * Dim: Get the user's profile photo.
     */
    public function avatarURL()
    {
        $avatarpath = "/storage/avatars/{$this->id}.jpg";
        if (file_exists(public_path($avatarpath))) {
            return $avatarpath;
        } else {
            return "/img/user.jpg";
        }
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Hash password when create new user
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }


    public function get_roles()
    {
        $roles = [];
        foreach ($this->getRoleNames() as $key => $role) {
            $roles[$key] = $role;
        }

        return $roles;
    }



    public function getemail($id)
    {
        $this->attributes['password'] = Hash::make($value);
    }








}
