<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 03/08/15
 * Time: 23:13
 */

namespace App\Http\Controllers;

use App\Commands\Users\UserCreateCommand;
use Illuminate\Http\Request;

class TestController extends Controller{

    public function run(){
        $command = new UserCreateCommand(
            'sdfg', 'sdfg', 'dfg'
        );

        $this->dispatch($command);

        return 'done';
    }

}