<?php

namespace App\PipeHandlers\Validators\Commands\Users;

use App\Jobs\Commands\BaseCommand;
use App\Exceptions\ValidationException;
use App\PipeHandlers\BaseValidator;

class UserUpdateCommandValidator extends BaseValidator{

    public function validate(BaseCommand $command){

        $this->baseValidate($command, [
			'email' => 'sometimes|email|unique:users,email',
        ]);

    }

}