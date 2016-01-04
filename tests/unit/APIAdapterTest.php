<?php


use App\Adapters\APIAdapter;
use \Acting;
use App\Adapters\WebsiteAdapter;
use App\Models\User;
use App\Models\UserRole;

class APIAdapterTest extends \Codeception\TestCase\Test
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
    public function testAuthState_authStateAccurateForNonLoggedInState()
    {

        App::bindShared('oauth2-server.authorizer', function(){
            $mock = Mockery::mock(\LucaDegasperi\OAuth2Server\Authorizer::class);
            $mock->shouldReceive('getResourceOwnerId')->andReturn(null);
            $mock->shouldReceive('getResourceOwnerType')->andReturn(null);
            return $mock;
        });

        $adapter = App::make(APIAdapter::class);
        $state = $adapter->getAuthState();

        $this->assertFalse($state->rememberMe);
        $this->assertNull($state->userId);
        $this->assertNull($state->actingUserId);
        $this->assertEquals(APIAdapter::AUTH_MECHANISM, $state->authMechanism);

    }

    public function testAuthState_authStateAccurateForLoggedInState()
    {

        $user = factory(App\Models\User::class, 1)->create();
        $user->password = 'password';
        $user->save();

        App::bindShared('oauth2-server.authorizer', function() use ($user){
            $mock = Mockery::mock(\LucaDegasperi\OAuth2Server\Authorizer::class);
            $mock->shouldReceive('getResourceOwnerId')->andReturn($user->id);
            $mock->shouldReceive('getResourceOwnerType')->andReturn("user");
            return $mock;
        });

        Input::merge(array('access_token' => 'random_token'));

        $adapter = App::make(APIAdapter::class);
        $state = $adapter->getAuthState();

        $this->assertFalse($state->rememberMe);
        $this->assertEquals($user->id, $state->userId);
        $this->assertEquals($user->id, $state->actingUserId);
        $this->assertEquals(APIAdapter::AUTH_MECHANISM, $state->authMechanism);

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

        App::bindShared('oauth2-server.authorizer', function() use ($user){
            $mock = Mockery::mock(\LucaDegasperi\OAuth2Server\Authorizer::class);
            $mock->shouldReceive('getResourceOwnerId')->andReturn($user->id);
            $mock->shouldReceive('getResourceOwnerType')->andReturn("user");
            return $mock;
        });

        Input::merge(array('access_token' => 'random_token'));
        Input::merge(array('act_as' => $user2->id));

        $adapter = App::make(APIAdapter::class);
        $state = $adapter->getAuthState();

        $this->assertFalse( $state->rememberMe );
        $this->assertEquals( $user->id, $state->userId );
        $this->assertEquals( $user2->id, $state->actingUserId );
        $this->assertEquals( APIAdapter::AUTH_MECHANISM, $state->authMechanism );

    }



}