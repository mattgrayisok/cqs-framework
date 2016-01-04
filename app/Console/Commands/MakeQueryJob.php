<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeQueryJob extends MakeJob
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
	protected $signature = 'jobs:makeQuery
    						{name : The class name of the new query including namespace}
    						{--prop= : If defined the job will be pushed to a queue}
    						{--au|authoriser : If defined creates an authoriser}
    						{--va|validator : If defined creates a validator}
    						';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Creates a new query job to be used with the command bus';

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
	public function handle()
	{

		$fullName = $this->argument('name');
		$parts = explode('\\', $fullName);
		$classname = array_pop($parts);
		$namespace = implode('\\', $parts);

		$authoriser = $this->option('authoriser');
		$validator = $this->option('validator');
		$properties = explode(',',$this->option('prop'));

		$this->createQueryJob($classname, $namespace, $properties);
		$this->createQueryJobHandler($classname, $namespace);

		if($authoriser) $this->createAuthoriser(false, $classname, $namespace);
		if($validator) $this->createValidator(false, $classname, $namespace, $properties);

	}


	private function createQueryJob($classname, $namespace, $properties){

		$stub = \File::get(app_path().'/Console/Commands/stubs/QueryJob.stub');

		$stub = str_replace('{{classname}}', $classname, $stub);
		$stub = str_replace('{{namespace}}', (strlen($namespace)>0?'\\':'').$namespace, $stub);

		$prop1 = "";
		foreach($properties as $property){
			$prop1 .= "\tpublic $".$property.";\n";
		}

		$prop2 = "";
		foreach($properties as $property){
			$prop2 .= "$".$property.", ";
		}
		$prop2 = trim($prop2, ", ");

		$prop3 = "";
		foreach($properties as $property){
			$prop3 .= "\t\t\$this->".$property." = $".$property.";\n";
		}

		$stub = str_replace('{{prop1}}', $prop1, $stub);
		$stub = str_replace('{{prop2}}', $prop2, $stub);
		$stub = str_replace('{{prop3}}', $prop3, $stub);

		$path = $this->getPathForQueryJob($classname, $namespace);
		$parts = explode('/', $path);
		array_pop($parts);
		if(!file_exists(implode('/', $parts))) {
			\File::makeDirectory(implode('/', $parts), 0777, true);
		}

		\File::put($path, $stub);

	}

	private function getPathForQueryJob($classname, $namespace){

		return app_path().'/Jobs/Queries/'.str_ireplace('\\', '/', $namespace).(strlen($namespace)>0?'/':'').$classname.'.php';

	}

	private function createQueryJobHandler($classname, $namespace){

		$stub = \File::get(app_path().'/Console/Commands/stubs/QueryHandler.stub');

		$stub = str_replace('{{classname}}', $classname, $stub);
		$stub = str_replace('{{namespace}}', (strlen($namespace)>0?'\\':'').$namespace, $stub);

		$path = $this->getPathForQueryJobHandler($classname, $namespace);
		$parts = explode('/', $path);
		array_pop($parts);
		if(!file_exists(implode('/', $parts))) {
			\File::makeDirectory(implode('/', $parts), 0777, true);
		}

		\File::put($path, $stub);

	}

	private function getPathForQueryJobHandler($classname, $namespace){

		return app_path().'/Handlers/Queries/'.str_ireplace('\\', '/', $namespace).(strlen($namespace)>0?'/':'').$classname.'Handler.php';

	}
}
