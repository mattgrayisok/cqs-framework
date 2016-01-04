<?php

namespace App\Facades;

use App\Exceptions\AuthorisationException;
use App\Models\User;
use App\Models\UserRole;
use Auth;

class ActingModel {

    private $currentUser = null;

    public function asUser(User $user)
    {
        if(Auth::guest()){
            throw new AuthorisationException();
        }

        if(!Auth::user()->hasRole(UserRole::ACTOR_ROLE)){
            throw new AuthorisationException();
        }

        $this->currentUser = $user;

    }

    public function asMyself()
    {
        if(Auth::guest()){
            throw new AuthorisationException();
        }

        $this->currentUser = Auth::user();

    }

    public function asWho()
    {
        if(is_null($this->currentUser)){
            return Auth::user();
        }

        return $this->currentUser;
    }

}