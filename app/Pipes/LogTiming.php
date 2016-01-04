<?php
/**
 * User: Slice
 * Date: 11/08/15
 * Time: 08:52
 */

namespace App\Pipes;

use App\Jobs\Commands\BaseCommand;
use App\Util\Profiling\TimingLoggerContract;
use App\Util\Profiling\TimingProfiler;
use Log;

class LogTiming {

	/**
	 * @var TimingProfiler
	 */
	private $timer;

	/**
	 * @var TimingLoggerContract
	 */
	private $logger;

	public function __construct(TimingProfiler $timer, TimingLoggerContract $logger){
		$this->timer = $timer;
		$this->logger = $logger;
	}

	public function handle(BaseCommand $command, $next)
	{

		$this->timer->profiles('CommandRunTimeProfile')->start();

		$response = $next($command);

		$totalTime = $this->timer->profiles('CommandRunTimeProfile')->end()->totalTime();

		$this->logger->log($totalTime, "JobProfiler:".get_class($command), 'complete');

		return $response;

	}

}