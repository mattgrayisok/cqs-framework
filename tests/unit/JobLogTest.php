<?php

use App\Jobs\Commands\BaseCommand;
use App\Pipes\LogCommand;
use App\Util\CommandLogger\CommandLoggerContract;
use App\Util\CommandLogger\FileCommandLogger;
use Carbon\Carbon;

/**
 * User: Slice
 * Date: 17/10/15
 * Time: 13:44
 */

class JobLogTest extends ExtendedTest
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
	public function testJobLog_loggableQueryShouldLog()
	{

		$command = Mockery::mock(BaseCommand::class);
		$command->shouldReceive('shouldLog')->andReturn(true);

		$mock = \Mockery::mock('CallCounter');
		$mock->shouldReceive('call')->once()->andReturnNull();

		$loggerMock = Mockery::mock(CommandLoggerContract::class);
		$loggerMock->shouldReceive('storeCommand')->once()->andReturnNull();

		$logger = new LogCommand($loggerMock);

		$result = $logger->handle($command, function() use ($mock){
			return $mock->call();
		});

		$this->assertEquals(null, $result);

	}

	public function testJobLog_fileLoggerLogsToFile()
	{

		$command = Mockery::mock(BaseCommand::class);
		$command->shouldReceive('shouldLog')->andReturn(true);

		$logger = new FileCommandLogger();
		$logger->storeCommand($command, Carbon::now()->timestamp, '0.0.1');

		$this->assertFileExists(storage_path().'/app/commands.log');

		//TODO: This test isn't very good but it's difficult to mock the filesystem
		//The file should be written to a temp test location and deleted afterwards

	}


}