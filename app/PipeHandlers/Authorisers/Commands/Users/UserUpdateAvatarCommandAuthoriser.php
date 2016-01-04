<?php

namespace App\PipeHandlers\Authorisers\Commands\Users;

use App\Jobs\Commands\BaseCommand;
use App\PipeHandlers\BaseAuthoriser;

class UserUpdateAvatarCommandAuthoriser extends BaseAuthoriser{

    public function authorise(BaseCommand $command){

        $this->requiresUser($command);

    }

}