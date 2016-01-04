<?php
/**
 * User: Slice
 * Date: 11/08/15
 * Time: 09:57
 */

namespace App\PipeHandlers;


use App\Exceptions\ValidationException;
use Validator;

abstract class BaseValidator {

    protected function baseValidate($command, $rules){

        $validator = Validator::make(with(new \ArrayObject($command))->getArrayCopy(), $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors());
        }

    }

}