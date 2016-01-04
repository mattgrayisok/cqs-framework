<?php
/**
 * User: Slice
 * Date: 07/11/15
 * Time: 21:48
 */

namespace App\Util\Profiling;


use Storage;

class FileTimingLogger implements TimingLoggerContract{

	private $fileSystem;

	public function __construct()
	{

		$this->fileSystem = Storage::disk('local');

	}

	public function log($time, $name, $subName = null)
	{

		$stringRepresentation = $name.($subName != null ? ":" . $subName : "")."|".number_format($time, 6, '.', ',');

		$this->fileSystem->append('timings.log', $stringRepresentation);

	}
}