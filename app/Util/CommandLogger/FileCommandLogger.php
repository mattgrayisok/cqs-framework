<?php
/**
 * User: Slice
 * Date: 07/11/15
 * Time: 16:36
 */

namespace App\Util\CommandLogger;


use App\Jobs\Commands\BaseCommand;
use Carbon\Carbon;
use Storage;

class FileCommandLogger implements CommandLoggerContract{

	private $fileSystem;

	public function __construct(){
		$this->fileSystem = Storage::disk('local');
	}

	public function storeCommand(BaseCommand $command, $timestamp, $version)
	{

		$stringRepresentation = serialize($command);

		$this->fileSystem->append('commands.log', $timestamp."|*|".$version."|*|".$stringRepresentation);

	}
}