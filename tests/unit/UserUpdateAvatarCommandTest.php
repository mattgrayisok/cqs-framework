<?php


use App\Jobs\Commands\Users\UserUpdateAvatarCommand;
use App\Jobs\Commands\Users\UserUpdateCommand;

class UserUpdateAvatarCommandTest extends ExtendedTest
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
	public function testUserUpdateAvatarCommand_userAvatarCanBeUpdated()
	{

		$email = 'temp@temp.com';

		$user = factory(App\Models\User::class)->create([
			'email' => $email
		]);

		$image = factory(App\Models\Image::class, 'medium')->create();

		$adapter = app('App\Adapters\MockAdapter');
		$adapter->setAuthState($user->id, $user->id, false);

		$command = new UserUpdateAvatarCommand($image->id);
		$adapter->dispatchCommand($command);

		$this->tester->seeRecord('users', ['profile_image_id' => $image->id, 'email' => $email]);

	}

	/*public function testUserUpdateAvatarCommand_userMustBeLoggedIn()
	{

		$adapter = app('App\Adapters\MockAdapter');
		$adapter->setAuthState(null, null, false);

		\PHPUnit_Framework_TestCase::setExpectedException('App\Exceptions\AuthorisationException');

		$command = new UserUpdateCommand('matt.gray@retrofuzz.com');
		$adapter->dispatchCommand($command);

	}*/

}