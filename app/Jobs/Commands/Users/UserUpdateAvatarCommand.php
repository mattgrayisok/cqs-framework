<?php

namespace App\Jobs\Commands\Users;

use App\Jobs\Commands\BaseCommand;
use App\Models\Image;
use Illuminate\Queue\SerializesModels;


/**
 * Class UserUpdateAvatarCommand
 * @package App\Jobs\Commands\Users
 */
class UserUpdateAvatarCommand extends BaseCommand {

    

    protected $log = true;
    protected $transact = false;

    //Define command properties here

	public $image;


    public function __construct( $image )
    {

		$this->image = $image;


    }

}