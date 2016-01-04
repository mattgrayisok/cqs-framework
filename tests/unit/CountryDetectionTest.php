<?php


use App\Jobs\Commands\Users\UserCreateCommand;

class CountryDetectionTest extends \Codeception\TestCase\Test
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
	public function testCountryDetection_userCountryAndTimezoneDetected()
	{

		$adapter = app('App\Adapters\MockAdapter');
		$adapter->setAuthState(null, null, false);

		$_SERVER['REMOTE_ADDR'] = '78.144.152.139';

		$command = new UserCreateCommand('slice-beans', 'matt.gray@retrofuzz.com', 'password');
		$uid = $adapter->dispatchCommand($command);

		$user = \App\Models\User::find($uid);
		$this->assertEquals(826, $user->country->id);
		$this->assertEquals('Europe/London', $user->timezone->name);
	}


}