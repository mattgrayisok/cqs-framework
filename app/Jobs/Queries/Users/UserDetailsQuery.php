<?php

namespace App\Jobs\Queries\Users;

use App\Jobs\Queries\BaseQuery;

class UserDetailsQuery extends BaseQuery{

	public $username;
	public $userId;

	protected $cache = true;
	protected $cacheTime = 5;
	protected $cacheTags = ['user'];

	public function __construct( $username = null, $userId = null)
	{
		$this->username = $username;
		$this->userId = $userId;
	}

}