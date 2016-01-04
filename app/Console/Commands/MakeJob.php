<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

abstract class MakeJob extends Command
{

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
	abstract public function handle();

	protected function createAuthoriser($isCommand, $classname, $namespace){

		$stub = \File::get(app_path().'/Console/Commands/stubs/JobAuthoriser.stub');

		$stub = str_replace('{{classname}}', $classname, $stub);
		$stub = str_replace('{{namespace}}', (strlen($namespace)>0?'\\':'').$namespace, $stub);

		$path = $this->getPathForAuthoriser($isCommand, $classname, $namespace);
		$parts = explode('/', $path);
		array_pop($parts);
		if(!file_exists(implode('/', $parts))) {
			\File::makeDirectory(implode('/', $parts), 0777, true);
		}

		\File::put($path, $stub);

	}

	protected function createValidator($isCommand, $classname, $namespace, $properties){

		$stub = \File::get(app_path().'/Console/Commands/stubs/JobValidator.stub');

		$stub = str_replace('{{classname}}', $classname, $stub);
		$stub = str_replace('{{namespace}}', (strlen($namespace)>0?'\\':'').$namespace, $stub);

		$prop1 = "";
		foreach($properties as $property){
			$prop1 .= "\t\t\t'".$property."' => '',\n";
		}

		$stub = str_replace('{{prop1}}', $prop1, $stub);

		$path = $this->getPathForValidator($isCommand, $classname, $namespace);
		$parts = explode('/', $path);
		array_pop($parts);
		if(!file_exists(implode('/', $parts))) {
			\File::makeDirectory(implode('/', $parts), 0777, true);
		}

		\File::put($path, $stub);

	}

	protected function getPathForAuthoriser($isCommand, $classname, $namespace){

		return app_path().'/PipeHandlers/Authorisers/'.($isCommand?'Commands':'Queries').'/'.str_ireplace('\\', '/', $namespace).(strlen($namespace)>0?'/':'').$classname.'Authoriser.php';

	}

	protected function getPathForValidator($isCommand, $classname, $namespace){

		return app_path().'/PipeHandlers/Validators/'.($isCommand?'Commands':'Queries').'/'.str_ireplace('\\', '/', $namespace).(strlen($namespace)>0?'/':'').$classname.'Validator.php';

	}
}
