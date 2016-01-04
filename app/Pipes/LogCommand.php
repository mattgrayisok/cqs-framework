<?php
/**
 * User: Slice
 * Date: 11/08/15
 * Time: 08:52
 */

namespace App\Pipes;

use App\Jobs\Commands\BaseCommand;
use App\Util\CommandLogger\CommandLoggerContract;
use Carbon\Carbon;
use Log;

class LogCommand {

	private $commandLogger;

	public function __construct(CommandLoggerContract $commandLogger){
		$this->commandLogger = $commandLogger;
	}

    public function handle(BaseCommand $command, $next)
    {

        if(!$command->shouldLog()){
            return $next($command);
        }

		$this->commandLogger->storeCommand($command, Carbon::now()->timestamp, '0.0.1');

        return $next($command);

    }

}