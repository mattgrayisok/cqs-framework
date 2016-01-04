<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Define all API routes here including authorisation. The API is versioned
| allowing breaking changes in the future
|
*/


//oAuth Stuff

Route::post('oauth/access_token', function() {
    return Response::json(Authorizer::issueAccessToken());
});

Route::get('oauth/authorize', ['as' => 'oauth.authorize.get','middleware' => ['check-authorization-params', 'auth'], function() {
	// display a form where the user can authorize the client to access it's data
	$authParams = Authorizer::getAuthCodeRequestParams();
	$formParams = array_except($authParams,'client');
	$formParams['client_id'] = $authParams['client']->getId();
    $formParams['scope'] = Input::get('scope');
	return View::make('api.oauth.authorization-form', ['params'=>$formParams,'client'=>$authParams['client']]);
}]);

Route::post('oauth/authorize', ['as' => 'oauth.authorize.post','middleware' => ['check-authorization-params', 'auth'], function() {

	$params = Authorizer::getAuthCodeRequestParams();
	$params['user_id'] = Auth::user()->id;
	$redirectUri = '';

	// if the user has allowed the client to access its data, redirect back to the client with an auth code
	if (Input::get('approve') !== null) {
		$redirectUri = Authorizer::issueAuthCode('user', $params['user_id'], $params);
	}

	// if the user has denied the client to access its data, redirect back to the client with an error message
	if (Input::get('deny') !== null) {
		$redirectUri = Authorizer::authCodeRequestDeniedRedirectUri();
	}
	return Redirect::to($redirectUri);
}]);

Route::get('/', function () {
    return View::make('api.introduction');
});

Route::post('/users', ['as' => 'api.v1.users.store', 'uses' => 'UsersController@store']);

Route::post('/me/avatar', ['as' => 'api.v1.users.updateavatar', 'uses' => 'UsersController@updateAvatar']);

//GET users - list users
//POST users - create new user
//GET users/1 - get user details
//PUT users/1

//Update user details
//Update user password

//Reset password request
//Reset password action

//