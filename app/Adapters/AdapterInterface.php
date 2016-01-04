<?php
/**
 * User: Slice
 * Date: 11/08/15
 * Time: 23:01
 */

namespace App\Adapters;

use App\Jobs\Commands\BaseCommand;

interface AdapterInterface{

    function dispatchCommand(BaseCommand $command);

    function getAuthState();

}