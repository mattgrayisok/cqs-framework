<?php

use App\Jobs\Commands\BaseCommand;
use App\Pipes\LogCommand;
use App\Util\CommandLogger\CommandLoggerContract;
use App\Util\CommandLogger\FileCommandLogger;
use App\Util\Profiling\FileTimingLogger;
use App\Util\Profiling\TimingProfiler;
use Carbon\Carbon;

/**
 * User: Slice
 * Date: 17/10/15
 * Time: 13:44
 */

class JobProfileTest extends ExtendedTest
{
	/**
	 * @var \UnitTester
	 */
	protected $tester;

	protected function _before()
	{

		parent::_before();

	}

	protected function _after()
	{

		parent::_after();

	}

	// tests
	public function testJobProfile_profilerRecordsTime()
	{

		$profiler = new TimingProfiler();

		$profiler->profiles('TestProfile')->start();
		usleep(100000); //100ms
		$profiler->profiles('TestProfile')->setLap('Lap1');
		usleep(100000); //100ms
		$totalTime = $profiler->profiles('TestProfile')->end()->totalTime();

		$lapTime = $profiler->profiles('TestProfile')->timeToLap('Lap1');

		$this->assertGreaterThan(0, $lapTime);
		$this->assertLessThan(0.2, $lapTime);
		$this->assertGreaterThan(0.1, $totalTime);
		$this->assertLessThan(0.3, $totalTime);

	}

	public function testJobProfile_fileProfileLoggerLogsToFile()
	{

		$logger = new FileTimingLogger();
		$logger->log(1, "TestProfile", "complete");
		$this->assertFileExists(storage_path().'/app/timings.log');

		//TODO: This test isn't very good but it's difficult to mock the filesystem
		//The file should be written to a temp test location and deleted afterwards

	}

}