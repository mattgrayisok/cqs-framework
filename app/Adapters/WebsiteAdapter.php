<?php
/**
 * User: Slice
 * Date: 11/08/15
 * Time: 22:57
 */

namespace App\Adapters;

use App\Jobs\Commands\BaseCommand;
use App\Jobs\JobAuthState;
use Illuminate\Foundation\Bus\DispatchesJobs;

class WebsiteAdapter implements AdapterInterface{

    const AUTH_MECHANISM = 'websiteAdapter';

    use DispatchesJobs;

    public function dispatchCommand(BaseCommand $command)
    {

        $command->attachAuthState($this->getAuthState());
        return $this->dispatch($command);

    }

    public function getAuthState()
    {

        $state = new JobAuthState();
        $state->authMechanism = self::AUTH_MECHANISM;

        if(\Auth::check()){
            $user = \Auth::user();
            $state->userId = $user->id;
            $state->rememberMe = \Auth::viaRemember();
            $state->actingUserId = \Acting::asWho()->id;
        }

        return $state;

    }
}