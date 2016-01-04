<?php
/**
 * User: Slice
 * Date: 20/08/15
 * Time: 23:59
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ActingFacade extends Facade {

    protected static function getFacadeAccessor() { return 'actingModel'; }

}