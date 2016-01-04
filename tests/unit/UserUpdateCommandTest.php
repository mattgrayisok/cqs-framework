<?php


use App\Jobs\Commands\Users\UserUpdateCommand;

class UserUpdateCommandTest extends ExtendedTest
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
	public function testUserUpdateCommand_userEmailCanBeUpdated()
	{

		$user = factory(App\Models\User::class)->create([
			'email' => 'temp@temp.com'
		]);

		$adapter = app('App\Adapters\MockAdapter');
		$adapter->setAuthState($user->id, $user->id, false);

		$command = new UserUpdateCommand('matt.gray@retrofuzz.com');
		$adapter->dispatchCommand($command);

		$this->tester->seeRecord('users', ['email' => 'matt.gray@retrofuzz.com']);
		$this->tester->seeEventTriggered(\App\Events\UserUpdatedEvent::class);

	}

	public function testUserUpdateCommand_userMustBeLoggedIn()
	{

		$adapter = app('App\Adapters\MockAdapter');
		$adapter->setAuthState(null, null, false);

		\PHPUnit_Framework_TestCase::setExpectedException('App\Exceptions\AuthorisationException');

		$command = new UserUpdateCommand('matt.gray@retrofuzz.com');
		$adapter->dispatchCommand($command);

	}

	public function testUserUpdateCommand_userCanUpdateOtherUser()
	{

		$user = factory(App\Models\User::class)->create([
			'email' => 'temp@temp.com'
		]);

		$adapter = app('App\Adapters\MockAdapter');
		$adapter->setAuthState(999, $user->id, false);

		$command = new UserUpdateCommand('matt.gray@retrofuzz.com');
		$adapter->dispatchCommand($command);

		$this->tester->seeRecord('users', ['id' => $user->id, 'email' => 'matt.gray@retrofuzz.com']);
		$this->tester->seeEventTriggered(\App\Events\UserUpdatedEvent::class);

	}

	public function testUserUpdateCommand_invalidEmailThrowsException()
	{

		$user = factory(App\Models\User::class)->create([
			'email' => 'temp@temp.com'
		]);

		$adapter = app('App\Adapters\MockAdapter');
		$adapter->setAuthState($user->id, $user->id, false);

		\PHPUnit_Framework_TestCase::setExpectedException('App\Exceptions\ValidationException');

		$command = new UserUpdateCommand('asdfasdf');
		$adapter->dispatchCommand($command);

		$this->tester->seeRecord('users', ['id' => $user->id, 'email' => 'temp@temp.com']);
		$this->tester->dontSeeEventTriggered(\App\Events\UserUpdatedEvent::class);

	}

}