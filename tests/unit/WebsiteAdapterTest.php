<?php


use App\Adapters\WebsiteAdapter;
use \Acting;
use App\Models\User;
use App\Models\UserRole;

class WebsiteAdapterTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testAuthState_authStateAccurateForNonLoggedInState()
    {

        $adapter = new WebsiteAdapter();
        $state = $adapter->getAuthState();

        $this->assertFalse($state->rememberMe);
        $this->assertNull($state->userId);
        $this->assertNull($state->actingUserId);
        $this->assertEquals(WebsiteAdapter::AUTH_MECHANISM, $state->authMechanism);

    }

    public function testAuthState_authStateAccurateForLoggedInState()
    {

        $user = factory(App\Models\User::class, 1)->create();
        $user->password = 'password';
        $user->save();

        Auth::attempt(['username' => $user->username, 'password' => 'password']);

        $adapter = new WebsiteAdapter();
        $state = $adapter->getAuthState();

        $this->assertFalse($state->rememberMe);
        $this->assertEquals($user->id, $state->userId);
        $this->assertEquals($user->id, $state->actingUserId);
        $this->assertEquals(WebsiteAdapter::AUTH_MECHANISM, $state->authMechanism);

    }

    public function testAuthState_authStateAccurateForLoggedInStateWithActing()
    {

        $role = UserRole::where('name', '=', UserRole::ACTOR_ROLE)->first();

        $user = factory(App\Models\User::class, 1)->create();
        $user->password = 'password';
        $user->save();

        $user2 = factory(App\Models\User::class, 1)->create();
        $user2->password = 'password';
        $user2->save();

        $user->roles()->attach($role);

        Auth::attempt(['username' => $user->username, 'password' => 'password']);

        Acting::asUser($user2);

        $adapter = new WebsiteAdapter();
        $state = $adapter->getAuthState();

        $this->assertFalse( $state->rememberMe );
        $this->assertEquals( $user->id, $state->userId );
        $this->assertEquals( $user2->id, $state->actingUserId );
        $this->assertEquals( WebsiteAdapter::AUTH_MECHANISM, $state->authMechanism );

    }



}