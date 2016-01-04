<?php
/**
 * User: Slice
 * Date: 11/08/15
 * Time: 10:00
 */

namespace App\PipeHandlers;


use App\Jobs\Commands\BaseCommand;
use App\Exceptions\AuthorisationException;
use App\Models\User;
use Illuminate\Support\MessageBag;

abstract class BaseAuthoriser {

    public function authorise(BaseCommand $command){
        return;
    }

    public function requiresUser(BaseCommand $command){
        if($command->getAuthState()->actingUserId == null){
            $bag = new MessageBag();
            $bag->add('authorisation', 'Only authenticated users can perform this action');
            throw new AuthorisationException($bag);
        }
    }

    public function requiresRole(BaseCommand $command, $role){
        if($command->getAuthState()->actingUserId == null){
            $bag = new MessageBag();
            $bag->add('authorisation', 'Guests cannot perform this action');
            throw new AuthorisationException($bag);
        }

        $user = User::find($command->getAuthState()->userId);

        if(is_null($user)){
            $bag = new MessageBag();
            $bag->add('authorisation', 'The specified user cannot perform this action');
            throw new AuthorisationException($bag);
        }

        if(!$user->hasRole($role)){
            $bag = new MessageBag();
            $bag->add('authorisation', 'The specified user does not have the required '.$role.' role');
            throw new AuthorisationException($bag);
        }
    }

    public function requiresGuest(BaseCommand $command){
        if($command->getAuthState()->actingUserId != null){
            $bag = new MessageBag();
            $bag->add('authorisation', 'Only guests can perform this action');
            throw new AuthorisationException($bag);
        }
    }

    public function notRemember(BaseCommand $command){
        if($command->getAuthState()->rememberMe == true){
            $bag = new MessageBag();
            $bag->add('authorisation', 'This action cannot be performed using a `remembered` session');
            throw new AuthorisationException($bag);
        }
    }


}