<?php
/**
 * User: Slice
 * Date: 11/08/15
 * Time: 08:52
 */

namespace App\Pipes;

use App\Jobs\Commands\BaseCommand;
use Log;

class AuthGate {

    public function handle(BaseCommand $command, $next)
    {

		$authoriserClassName = get_class($command).'Authoriser';
        $authoriserClassName = str_replace('\\Jobs\\','\\PipeHandlers\\Authorisers\\',$authoriserClassName);

        if(class_exists($authoriserClassName)){
            $validator = \App::make($authoriserClassName);
            $validator->authorise($command);
        }

        return $next($command);

    }

}