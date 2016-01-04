<?php
/**
 * User: macbook
 * Date: 03/08/15
 * Time: 23:04
 */

namespace App\Jobs\Commands\Users;

use App\Jobs\Commands\BaseCommand;

/**
 * Class UserCreateCommand
 * @package App\Commands\Users
 */
class UserCreateCommand extends BaseCommand{

    protected $log = true;
    protected $transact = false;

    public $username;
    public $email;
    public $password;

    public function __construct( $username, $email,  $password)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

}