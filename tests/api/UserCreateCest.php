<?php

class UserCreateCest
{

    function createAUser(APITester $I)
    {

        $client = factory(App\Models\OAuthClient::class, 1)->create();
        $grant = \App\Models\OAuthGrant::find('password');
        $client->oauth_grants()->attach($grant);
        $scopes = \App\Models\OAuthScope::all()->lists('id')->toArray();
        $client->oauth_scopes()->attach($scopes);

        $I->wantTo('Create a new user');

        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPOST('users', [
            'username' => 'username',
            'email' => 'test@test.com',
            'password' => 'password',
            'password_conf' => 'password',
        ]);
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'status' => 'success', // works with strings as well
        ]);

    }

    function createAUserWithInvalidEmail(APITester $I)
    {

        $client = factory(App\Models\OAuthClient::class, 1)->create();
        $grant = \App\Models\OAuthGrant::find('password');
        $client->oauth_grants()->attach($grant);
        $scopes = \App\Models\OAuthScope::all()->lists('id')->toArray();
        $client->oauth_scopes()->attach($scopes);

        $I->wantTo('See an error message when providing an incorrect email');

        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPOST('users', [
            'username' => 'username',
            'email' => 'testnotcorrect',
            'password' => 'password',
            'password_conf' => 'password',
        ]);
        $I->seeResponseCodeIs(400);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'status' => 'fail', // works with strings as well
        ]);

    }

    function createAUserWithMissingEmail(APITester $I)
    {

        $I->wantTo('See an error message when missing an email');

        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPOST('users', [
            'username' => 'username',
            'password' => 'password',
            'password_conf' => 'password',
        ]);
        $I->seeResponseCodeIs(400);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'status' => 'fail', // works with strings as well
        ]);

    }

}