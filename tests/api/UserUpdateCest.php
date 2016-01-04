<?php

class UserUpdateCest
{

	function updateAUser(APITester $I)
	{

		$client = factory(App\Models\OAuthClient::class, 1)->create();
		$grant = \App\Models\OAuthGrant::find('password');
		$client->oauth_grants()->attach($grant);
		$scopes = \App\Models\OAuthScope::all()->lists('id')->toArray();
		$client->oauth_scopes()->attach($scopes);

		$I->wantTo('Update a user');

	}

	function updateAUserAvatar(APITester $I)
	{

		$client = factory(App\Models\OAuthClient::class, 1)->create();
		$grant = \App\Models\OAuthGrant::find('password');
		$client->oauth_grants()->attach($grant);
		$scopes = \App\Models\OAuthScope::all()->lists('id')->toArray();
		$client->oauth_scopes()->attach($scopes);

		$I->wantTo('Update a user avatar');

	}

}