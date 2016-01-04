<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanQuery extends MakeJob
{

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'jobs:cleanQuery
    						{name : The class name of the query to be deleted including namespace}
    						';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Deletes a query job and associated handlers';

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

		$jobLocation = app_path().'/Jobs/Queries/'.str_ireplace('\\', '/', $namespace).(strlen($namespace)>0?'/':'').$classname.'.php';

		if(file_exists($jobLocation)){
			unlink($jobLocation);
		}

		$handlerLocation = app_path().'/Handlers/Queries/'.str_ireplace('\\', '/', $namespace).(strlen($namespace)>0?'/':'').$classname.'Handler.php';

		if(file_exists($handlerLocation)) {
			unlink($handlerLocation);
		}

		$authLocation = $this->getPathForAuthoriser(false, $classname, $namespace);

		if(file_exists($authLocation)) {
			unlink($authLocation);
		}

		$validationLocation = $this->getPathForValidator(false, $classname, $namespace);

		if(file_exists($validationLocation)) {
			unlink($validationLocation);
		}

	}

}
