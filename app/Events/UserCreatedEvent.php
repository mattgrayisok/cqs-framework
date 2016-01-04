<?php
/**
 * User: Slice
 * Date: 15/08/15
 * Time: 18:27
 */

namespace App\Events;


class UserCreatedEvent extends Event{

    public $user = null;

    public function __construct($user){
        $this->user = $user;
    }

}