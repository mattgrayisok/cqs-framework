<?php

class AuthenticationCest
{

    function obtainPasswordGrant(APITester $I)
    {

        $client = factory(App\Models\OAuthClient::class, 1)->create();
        $grant = \App\Models\OAuthGrant::find('password');
        $client->oauth_grants()->attach($grant);
        $scope = \App\Models\OAuthScope::find('user_read');
        $client->oauth_scopes()->attach($scope);
        $user = factory(App\Models\User::class, 1)->create();
        $user->password = 'password';
        $user->save();

        $I->wantTo('Send a username and password and receive an access token');

        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPOST('oauth/access_token', [
            'username'      => $user->username,
            'password'      => 'password',
            'grant_type'    => 'password',
            'client_id'     => $client->id,
            'client_secret' => $client->secret,
            'scope'         => 'user_read'
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'access_token' => 'string',
        ]);

    }

    function cantObtainPasswordGrantWithInvalidCredentials(APITester $I)
    {

        $client = factory(App\Models\OAuthClient::class, 1)->create();
        $grant = \App\Models\OAuthGrant::find('password');
        $client->oauth_grants()->attach($grant);
        $scope = \App\Models\OAuthScope::find('user_read');
        $client->oauth_scopes()->attach($scope);
        $user = factory(App\Models\User::class, 1)->create();
        $user->password = 'password';
        $user->save();

        $I->wantTo('Send a bad username and password and receive an error');

        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPOST('oauth/access_token', [
            'username'      => $user->username,
            'password'      => 'badpassword',
            'grant_type'    => 'password',
            'client_id'     => $client->id,
            'client_secret' => $client->secret,
            'scope'         => 'user_read'
        ]);
        $I->seeResponseCodeIs(401);
        $I->seeResponseIsJson();

    }

    function cantObtainPasswordGrantWithInvalidScope(APITester $I)
    {

        $client = factory(App\Models\OAuthClient::class, 1)->create();
        $grant = \App\Models\OAuthGrant::find('password');
        $client->oauth_grants()->attach($grant);
        $scope = \App\Models\OAuthScope::find('user_read');
        $client->oauth_scopes()->attach($scope);
        $user = factory(App\Models\User::class, 1)->create();
        $user->password = 'password';
        $user->save();

        $I->wantTo('Send an invalid scope and receive an error');

        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPOST('oauth/access_token', [
            'username'      => $user->username,
            'password'      => 'password',
            'grant_type'    => 'password',
            'client_id'     => $client->id,
            'client_secret' => $client->secret,
            'scope'         => 'user_write'
        ]);
        $I->seeResponseCodeIs(400);
        $I->seeResponseIsJson();

    }

    function obtainClientGrant(APITester $I)
    {

        $client = factory(App\Models\OAuthClient::class, 1)->create();
        $grant = \App\Models\OAuthGrant::find('client_credentials');
        $client->oauth_grants()->attach($grant);
        $scope = \App\Models\OAuthScope::find('content');
        $client->oauth_scopes()->attach($scope);

        $I->wantTo('Send client credentials and receive an access token');

        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPOST('oauth/access_token', [
            'grant_type'    => 'client_credentials',
            'client_id'     => $client->id,
            'client_secret' => $client->secret,
            'scope'         => 'content'
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'access_token' => 'string',
        ]);

    }

    function cantObtainClientGrantWithInvalidCredentials(APITester $I)
    {

        $client = factory(App\Models\OAuthClient::class, 1)->create();
        $grant = \App\Models\OAuthGrant::find('client_credentials');
        $client->oauth_grants()->attach($grant);
        $scope = \App\Models\OAuthScope::find('user_read');
        $client->oauth_scopes()->attach($scope);

        $I->wantTo('Send bad client credentials and receive an error');

        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPOST('oauth/access_token', [
            'grant_type'    => 'client_credentials',
            'client_id'     => $client->id,
            'client_secret' => 'badsecret',
            'scope'         => 'user_read'
        ]);
        $I->seeResponseCodeIs(401);
        $I->seeResponseIsJson();

    }

    function obtainAuthCodeGrant(ApiTester $I)
    {

        $user = factory(App\Models\User::class, 1)->create();
        $user->password = 'password';
        $user->save();

        $I->amLoggedAs($user);

        $client = factory(App\Models\OAuthClient::class, 1)->create();
        $grant = \App\Models\OAuthGrant::find('authorization_code');
        $client->oauth_grants()->attach($grant);
        $scope = \App\Models\OAuthScope::find('user_read');
        $client->oauth_scopes()->attach($scope);
        $endpoint = factory(App\Models\OAuthClientEndpoint::class, 1)->make();
        $endpoint->oauth_client()->associate($client);
        $endpoint->save();

        $I->wantTo('Perform a full 3rd party authorisation flow and get an access token');

        $I->amOnPage('authorize?client_id='.$client->id.'&redirect_uri='.$endpoint->redirect_uri.'&response_type=code&scope=user_read');
        $I->click('approve');
        
        $I->seeInCurrentUrl('code=');

        $url = Request::fullUrl();
        $parts = parse_url($url);
        parse_str($parts['query'], $query);
        $code = $query['code'];

        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPOST('oauth/access_token', [
            'grant_type'    => 'authorization_code',
            'client_id'     => $client->id,
            'client_secret' => $client->secret,
            'redirect_uri'  => $endpoint->redirect_uri,
            'code'          => $code,
        ]);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'access_token' => 'string',
        ]);

    }

    function obtainAuthCodeGrantRedirectsToLogin(ApiTester $I)
    {

        $client = factory(App\Models\OAuthClient::class, 1)->create();
        $grant = \App\Models\OAuthGrant::find('authorization_code');
        $client->oauth_grants()->attach($grant);
        $scope = \App\Models\OAuthScope::find('user_read');
        $client->oauth_scopes()->attach($scope);
        $endpoint = factory(App\Models\OAuthClientEndpoint::class, 1)->make();
        $endpoint->oauth_client()->associate($client);
        $endpoint->save();

        $I->wantTo('Be redirected to login page when un authenticated user visits auth code page');

        $I->amOnPage('authorize?client_id='.$client->id.'&redirect_uri='.$endpoint->redirect_uri.'&response_type=code&scope=user_read');

        $I->seeInCurrentUrl('login');

    }
}