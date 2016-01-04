<?php


use App\Jobs\Commands\Users\UserCreateCommand;

class UserCreateCommandTest extends ExtendedTest
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
    public function testUserCreateCommand_userCanBeCreated()
    {

        $adapter = app('App\Adapters\MockAdapter');
        $adapter->setAuthState(null, null, false);

        $command = new UserCreateCommand('slice-beans', 'matt.gray@retrofuzz.com', 'password');
        $adapter->dispatchCommand($command);

		$this->tester->seeRecord('users', ['email' => 'matt.gray@retrofuzz.com', 'username' => 'slice-beans']);
		$this->tester->seeEventTriggered(\App\Events\UserCreatedEvent::class);

	}

    public function testUserCreateCommand_exceptionThrownWhenUsernameTooShort()
    {

        $adapter = app('App\Adapters\MockAdapter');
        $adapter->setAuthState(null, null, false);

        \PHPUnit_Framework_TestCase::setExpectedException('App\Exceptions\ValidationException');

        $command = new UserCreateCommand('', 'matt.gray@retrofuzz.com', 'password');
        $adapter->dispatchCommand($command);

    }

    public function testUserCreateCommand_exceptionThrownWhenEmailTooShort()
    {

        $adapter = app('App\Adapters\MockAdapter');
        $adapter->setAuthState(null, null, false);

        \PHPUnit_Framework_TestCase::setExpectedException('App\Exceptions\ValidationException');

        $command = new UserCreateCommand('slice-beans', '', 'password');
        $adapter->dispatchCommand($command);

    }

    public function testUserCreateCommand_exceptionThrownWhenEmailWrongFormat()
    {

        $adapter = app('App\Adapters\MockAdapter');
        $adapter->setAuthState(null, null, false);

        \PHPUnit_Framework_TestCase::setExpectedException('App\Exceptions\ValidationException');

        $command = new UserCreateCommand('slice-beans', 'asdasdasd', 'password');
        $adapter->dispatchCommand($command);

    }

    public function testUserCreateCommand_userCannotBeCreatedByLoggedInUser()
    {

        $adapter = app('App\Adapters\MockAdapter');
        $adapter->setAuthState(1, 1, false);

        \PHPUnit_Framework_TestCase::setExpectedException('App\Exceptions\AuthorisationException');

        $command = new UserCreateCommand('slice-beans', 'asdasd@asdas.com', 'password');
        $adapter->dispatchCommand($command);

    }

    public function testUserCreateCommand_userCanBeCreatedByLoggedInUserActingAsGuest()
    {

        $adapter = app('App\Adapters\MockAdapter');
        $adapter->setAuthState(1, null, false);

        $command = new UserCreateCommand('slice-beans', 'matt.gray@retrofuzz.com', 'password');
        $adapter->dispatchCommand($command);

		$this->tester->seeRecord('users', ['email' => 'matt.gray@retrofuzz.com', 'username' => 'slice-beans']);

	}


}