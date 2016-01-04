<?php
/**
 * User: Slice
 * Date: 07/11/15
 * Time: 21:43
 */

namespace App\Util\Profiling;


interface TimingLoggerContract {

	public function log($time, $name, $subName = null);

}