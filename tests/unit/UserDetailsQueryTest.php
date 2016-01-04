<?php


use App\Jobs\Queries\Users\UserDetailsQuery;

class UserDetailsQueryTest extends ExtendedTest
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
	public function testUserDetailsQuery_userDetailsReturnedGivenUsername()
	{

		$user = factory(App\Models\User::class, 1)->create();
		$user->password = 'password';
		$user->save();

		$adapter = app('App\Adapters\MockAdapter');
		$adapter->setAuthState(null, null, false);

		$command = new UserDetailsQuery($user->username, null);
		$result = $adapter->dispatchCommand($command);

		$this->assertNotNull($result);
		$this->assertEquals($result->id, $user->id);
	}

	public function testUserDetailsQuery_userDetailsReturnedGivenUserId()
	{

		$user = factory(App\Models\User::class, 1)->create();
		$user->password = 'password';
		$user->save();

		$adapter = app('App\Adapters\MockAdapter');
		$adapter->setAuthState(null, null, false);

		$command = new UserDetailsQuery(null, $user->id);
		$result = $adapter->dispatchCommand($command);

		$this->assertNotNull($result);
		$this->assertEquals($result->id, $user->id);
	}

	public function testUserDetailsQuery_userNullWhenSearchIncorrect()
	{

		$user = factory(App\Models\User::class, 1)->create();
		$user->password = 'password';
		$user->save();

		$adapter = app('App\Adapters\MockAdapter');
		$adapter->setAuthState(null, null, false);

		$command = new UserDetailsQuery(null, $user->id + 1);
		$result = $adapter->dispatchCommand($command);

		$this->assertNull($result);

	}

	public function testUserDetailsQuery_exceptionThrownWhenNoInfoProvided()
	{

		$user = factory(App\Models\User::class, 1)->create();
		$user->password = 'password';
		$user->save();

		$adapter = app('App\Adapters\MockAdapter');
		$adapter->setAuthState(null, null, false);

		\PHPUnit_Framework_TestCase::setExpectedException('App\Exceptions\ValidationException');

		$command = new UserDetailsQuery();
		$adapter->dispatchCommand($command);

	}

}