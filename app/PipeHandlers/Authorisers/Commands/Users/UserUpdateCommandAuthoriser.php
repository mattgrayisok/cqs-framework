<?php

namespace App\PipeHandlers\Authorisers\Commands\Users;

use App\Jobs\Commands\BaseCommand;
use App\PipeHandlers\BaseAuthoriser;

class UserUpdateCommandAuthoriser extends BaseAuthoriser{

    public function authorise(BaseCommand $command){

        //Authorise here
		$this->requiresUser($command);

    }

}