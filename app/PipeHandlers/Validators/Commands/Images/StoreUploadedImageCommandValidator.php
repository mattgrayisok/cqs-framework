<?php

namespace App\PipeHandlers\Validators\Commands\Images;

use App\Jobs\Commands\BaseCommand;
use App\Exceptions\ValidationException;
use App\PipeHandlers\BaseValidator;

class StoreUploadedImageCommandValidator extends BaseValidator{

    public function validate(BaseCommand $command){

        $this->baseValidate($command, [
			'image' => 'required|image',

        ]);

    }

}