<?php
use App\Handlers\Queries\Users\UserDetailsQueryHandler;
use App\Jobs\Queries\Users\UserDetailsQuery;
use App\Pipes\CacheQuery;

/**
 * User: Slice
 * Date: 17/10/15
 * Time: 13:44
 */

class JobCacheTest extends ExtendedTest
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
	public function testJobCache_cacheableQueryShouldCache()
	{

		$command = Mockery::mock(UserDetailsQuery::class)->makePartial();
		$command->shouldReceive('shouldCache')->andReturn(true);

		$mock = \Mockery::mock('CallCounter');
		$mock->shouldReceive('call')->once()->andReturn('asd');

		$cacher = new CacheQuery();
		$result = $cacher->handle($command, function() use ($mock){
			return $mock->call();
		});

		$result2 = $cacher->handle($command, function() use ($mock){
			return $mock->call();
		});

		$this->assertEquals('asd', $result);
		$this->assertEquals('asd', $result2);

	}

	public function testJobCache_nonCachedQueryShouldNotCache()
	{

		$command = Mockery::mock(UserDetailsQuery::class)->makePartial();
		$command->shouldReceive('shouldCache')->andReturn(false);

		$mock = \Mockery::mock('CallCounter');
		$mock->shouldReceive('call')->twice()->andReturn('asd');

		$cacher = new CacheQuery();
		$result = $cacher->handle($command, function() use ($mock){
			return $mock->call();
		});

		$result2 = $cacher->handle($command, function() use ($mock){
			return $mock->call();
		});

		$this->assertEquals('asd', $result);
		$this->assertEquals('asd', $result2);


	}


}