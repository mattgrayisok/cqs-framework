<?php
/**
 * User: Slice
 * Date: 25/08/15
 * Time: 09:34
 */

namespace App\Adapters;


use App\Jobs\Commands\BaseCommand;
use App\Jobs\JobAuthState;
use Illuminate\Foundation\Bus\DispatchesJobs;

class MockAdapter implements AdapterInterface
{

    const AUTH_MECHANISM = 'mockAdapter';

    use DispatchesJobs;

    public $authState;

    public function dispatchCommand(BaseCommand $command)
    {
        $command->attachAuthState($this->getAuthState());
        return $this->dispatch($command);
    }

    public function getAuthState()
    {
        return $this->authState;
    }

    public function setAuthState($userId, $actingUserId, $viaRemember){
        $state = new JobAuthState();
        $state->authMechanism = self::AUTH_MECHANISM;
        $state->userId = $userId;
        $state->actingUserId = $actingUserId;
        $state->rememberMe = $viaRemember;

        $this->authState = $state;

    }


}