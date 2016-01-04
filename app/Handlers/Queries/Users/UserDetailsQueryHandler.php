<?php
/**
 * User: Slice
 * Date: 17/10/15
 * Time: 13:11
 */

namespace App\Handlers\Queries\Users;


use App\Jobs\Queries\Users\UserDetailsQuery;
use App\Models\User;

class UserDetailsQueryHandler {

	public function handle(UserDetailsQuery $query)
	{

		if(!is_null($query->username)){
			return User::where('username', '=', $query->username)->first();
		}

		return User::find( $query->userId );

	}

}