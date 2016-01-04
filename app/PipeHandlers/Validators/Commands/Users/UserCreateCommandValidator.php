<?php
/**
 * User: Slice
 * Date: 11/08/15
 * Time: 09:49
 */

namespace App\PipeHandlers\Validators\Commands\Users;


use App\Jobs\Commands\BaseCommand;
use App\Exceptions\ValidationException;
use App\PipeHandlers\BaseValidator;
use Validator;

class UserCreateCommandValidator extends BaseValidator{

    public function validate(BaseCommand $command){

        $this->baseValidate($command, [
            'email' => 'required|email|unique:users,email',
            'username' => 'required|unique:users,username|string',
            'password' => 'required|string|between:5,30'
        ]);

    }

}