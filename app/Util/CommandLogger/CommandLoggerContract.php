<?php

namespace App\Util\CommandLogger;

use App\Jobs\Commands\BaseCommand;

/**
 * User: Slice
 * Date: 07/11/15
 * Time: 16:33
 */

interface CommandLoggerContract {

	public function storeCommand(BaseCommand $command, $timestamp, $version);

}