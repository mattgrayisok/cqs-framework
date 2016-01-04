<?php

namespace App\Events;


class UserUpdatedEvent extends Event{

	public $user = null;

	public function __construct($user){
		$this->user = $user;
	}

}