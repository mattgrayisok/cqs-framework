<?php
/**
 * User: Slice
 * Date: 11/08/15
 * Time: 08:52
 */

namespace App\Pipes;

use App\Jobs\Commands\BaseCommand;
use DB;
use Log;

class UseDatabaseTransactions {

    public function handle(BaseCommand $command, $next)
    {

        if(!$command->shouldTransact()){
            return $next($command);
        }

        Log::debug('Starting command transaction');
        return DB::transaction(function() use ($command, $next)
        {
            return $next($command);
        });

	}

}