<?php
/**
 * User: Slice
 * Date: 11/08/15
 * Time: 22:57
 */

namespace App\Adapters;

use App\Jobs\Commands\BaseCommand;
use App\Jobs\JobAuthState;
use App\Models\OAuthClient;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\MessageBag;
use Input;
use App\Exceptions\AuthorisationException;
use LucaDegasperi\OAuth2Server\Authorizer;

class APIAdapter implements AdapterInterface{

    const AUTH_MECHANISM = 'apiAdapter';

    use DispatchesJobs;

    private $authServer;

    public function __construct(Authorizer $authServer){
        $this->authServer = $authServer;
    }

    public function dispatchCommand(BaseCommand $command)
    {

        $command->attachAuthState($this->getAuthState());
        return $this->dispatch($command);

    }

    public function getAuthState()
    {

        $state = new JobAuthState();
        $state->authMechanism = self::AUTH_MECHANISM;

        if(!Input::has('access_token')){
            return $state;
        }

		$ownerId = $this->authServer->getResourceOwnerId();
		$type = $this->authServer->getResourceOwnerType();

        if($type == 'user'){

        	//oAuth token belongs to a user
            $user = User::find($ownerId);

            $actAs = $user->id;
	        if(Input::has('act_as')) {
	        	if($user->hasRole(UserRole::ACTOR_ROLE)){
					$actAs = Input::get('act_as');        	
	        	}else{
                    $bag = new MessageBag();
                    $bag->add('authorisation', 'The current user cannot act as another user');
	        		throw new AuthorisationException($bag);
	        	}
	        } 

            $state->userId = $user->id;
            $state->rememberMe = false;
            $state->actingUserId = $actAs;

        }else{

        	//oAuth token belongs to a client
        	//$client = OAuthClient::find($ownerId);

        	//There is no user context and act_as shouldn't be needed as clients can use 
        	//access tokens if they want to execute as a user

        }

        return $state;

    }
}