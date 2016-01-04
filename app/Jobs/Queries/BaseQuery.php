<?php

namespace App\Jobs\Queries;

use App\Jobs\Commands\BaseCommand;

/**
 * User: Slice
 * Date: 17/10/15
 * Time: 01:29
 */

class BaseQuery extends BaseCommand{

	protected $transact = false;

}