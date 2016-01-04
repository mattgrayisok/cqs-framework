<?php
/**
 * User: Slice
 * Date: 11/08/15
 * Time: 09:59
 */

namespace App\PipeHandlers\Authorisers\Commands\Users;

use App\Jobs\Commands\BaseCommand;
use App\PipeHandlers\BaseAuthoriser;


class UserCreateCommandAuthoriser extends BaseAuthoriser{

    public function authorise(BaseCommand $command){

        $this->requiresGuest($command);

    }

}