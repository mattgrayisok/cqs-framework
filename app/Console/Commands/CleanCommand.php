<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanCommand extends MakeJob
{

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'jobs:cleanCommand
    						{name : The class name of the command to be deleted including namespace}
    						';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Deletes a command job and associated handlers';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle(){

		$fullName = $this->argument('name');
		$parts = explode('\\', $fullName);
		$classname = array_pop($parts);
		$namespace = implode('\\', $parts);

		$jobLocation = app_path().'/Jobs/Commands/'.str_ireplace('\\', '/', $namespace).(strlen($namespace)>0?'/':'').$classname.'.php';

		if(file_exists($jobLocation)){
			unlink($jobLocation);
		}

		$handlerLocation = app_path().'/Handlers/Commands/'.str_ireplace('\\', '/', $namespace).(strlen($namespace)>0?'/':'').$classname.'Handler.php';

		if(file_exists($handlerLocation)) {
			unlink($handlerLocation);
		}

		$authLocation = $this->getPathForAuthoriser(true, $classname, $namespace);

		if(file_exists($authLocation)) {
			unlink($authLocation);
		}

		$validationLocation = $this->getPathForValidator(true, $classname, $namespace);

		if(file_exists($validationLocation)) {
			unlink($validationLocation);
		}

	}

}
