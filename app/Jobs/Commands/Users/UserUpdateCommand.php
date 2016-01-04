<?php

namespace App\Jobs\Commands\Users;

use App\Jobs\Commands\BaseCommand;
use Illuminate\Queue\SerializesModels;


/**
 * Class UserUpdateCommand
 * @package App\Jobs\Commands\Users
 */
class UserUpdateCommand extends BaseCommand {

    

    protected $log = true;
    protected $transact = false;

    //Define command properties here
	public $email;
	public $timezone;

    public function __construct( $email = null )
    {

		$this->email = $email;

    }

}