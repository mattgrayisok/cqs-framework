<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Models\User::class, function ($faker) {
    return [
        'username' => $faker->name,
        'email' => $faker->email,
        'password' => str_random(10),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\OAuthClient::class, function ($faker) {
    return [
        'secret' => str_random(32),
        'name' => $faker->word(),
    ];
});

$factory->define(App\Models\OAuthScope::class, function ($faker) {
    return [
    	'id' => $faker->word(),
        'description' => $faker->words(5),
    ];
});

$factory->define(App\Models\OAuthGrant::class, function ($faker) {
    return [
    	'id' => $faker->word(),
    ];
});

$factory->define(App\Models\OAuthClientEndpoint::class, function ($faker) {
    return [
        'client_id' => $faker->uuid(),
        'redirect_uri' => $faker->url()
    ];
});

$factory->defineAs(App\Models\Image::class, 'small', function ($faker) {

	$mime = 'image/jpeg';
	$url = 'http://placehold.it/100x100';

	return [
		'width' => 100,
		'height' => 100,
		'mime_type' => $mime,
		'extension' => 'jpg',
		'path' => $url,
		'description' => 'A small image',
		'average_colour' => null
	];
});

$factory->defineAs(App\Models\Image::class, 'medium', function ($faker) {

	$mime = 'image/jpeg';
	$url = 'http://placehold.it/800x800';

	return [
		'width' => 800,
		'height' => 800,
		'mime_type' => $mime,
		'extension' => 'jpg',
		'path' => $url,
		'description' => 'A medium image',
		'average_colour' => null
	];
});

$factory->defineAs(App\Models\Image::class, 'large', function ($faker) {

	$mime = 'image/jpeg';
	$url = 'http://placehold.it/1500x1500';

	return [
		'width' => 1500,
		'height' => 1500,
		'mime_type' => $mime,
		'extension' => 'jpg',
		'path' => $url,
		'description' => 'A large image',
		'average_colour' => null
	];
});