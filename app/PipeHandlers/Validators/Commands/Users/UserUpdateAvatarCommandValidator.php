<?php

namespace App\PipeHandlers\Validators\Commands\Users;

use App\Jobs\Commands\BaseCommand;
use App\Exceptions\ValidationException;
use App\Models\Image;
use App\PipeHandlers\BaseValidator;

class UserUpdateAvatarCommandValidator extends BaseValidator{

    public function validate(BaseCommand $command){

        $this->baseValidate($command, [
			'image' => 'required|integer|exists:images,id',
        ]);

    }

}