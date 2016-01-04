<?php
/**
 * User: Slice
 * Date: 11/08/15
 * Time: 08:52
 */

namespace App\Pipes;

use App\Jobs\Commands\BaseCommand;
use Log;

class ValidationGate {

    public function handle(BaseCommand $command, $next)
    {

		$validatorClassName = get_class($command).'Validator';
		$validatorClassName = str_replace('\\Jobs\\','\\PipeHandlers\\Validators\\',$validatorClassName);

        if(class_exists($validatorClassName)){
            $validator = \App::make($validatorClassName);
            $validator->validate($command);
        }

        return $next($command);

    }

}