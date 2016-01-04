<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 03/08/15
 * Time: 23:07
 */

namespace App\Handlers\Commands\Users;

use App\Jobs\Commands\Users\UserCreateCommand;
use App\Events\UserCreatedEvent;
use App\Models\Country;
use App\Models\Timezone;
use App\Models\User;
use MaxMind\Db\Reader;

class UserCreateCommandHandler {

    public function __construct()
    {

    }

    public function handle(UserCreateCommand $command)
	{

		$reader = new Reader(storage_path() . '/geolite2city.mmdb');

		$ip = null;

		if (isset($_SERVER['REMOTE_ADDR'])){
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}

		$country = null;
		$timezone = null;

		if( !is_null($ip) ) {

			$record = $reader->get($ip);

			$timezone = Timezone::firstOrCreate(['name' => $record["location"]["time_zone"]]);

			$countryCode = $record["country"]["iso_code"];

			$country = Country::where('iso_3166_2', $countryCode)->first();

		}

        $user = new User([
            'username' => $command->username,
            'email' => $command->email,
			'country_id' => is_null($country) ? null : $country->id,
			'timezone_id' => is_null($timezone) ? null : $timezone->id
        ]);

        $user->password = $command->password;
        $user->save();

        \Event::fire(new UserCreatedEvent($user));

        return $user->id;

    }

}