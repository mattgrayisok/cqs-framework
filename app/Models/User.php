<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 31/07/15
 * Time: 09:14
 */

namespace App\Models;


use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract{

    use Authenticatable, CanResetPassword;

    protected $fillable = ['username', 'email', 'country_id', 'timezone_id', 'profile_image_id', 'cover_image_id'];

    public function checkins(){
        return $this->hasMany(UserCheckin::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function timezone(){
        return $this->belongsTo(Timezone::class);
    }

    public function profile_image(){
        return $this->belongsTo(Image::class, 'profile_image_id');
    }

    public function cover_image(){
        return $this->belongsTo(Image::class, 'cover_image_id');
    }

    public function roles(){
        return $this->belongsToMany('App\Models\UserRole')->withTimestamps();
    }


    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = \Hash::make($value);
    }

    public function hasRole($role){

        $roles = $this->roles;

        foreach($roles as $checkRole){
            if($checkRole->name == $role){
                return true;
            }
        }

        return false;
    }

}