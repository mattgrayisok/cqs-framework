<?php

namespace App\Console\Commands;

class MakeCommandJob extends MakeJob
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobs:makeCommand
    						{name : The class name of the new command including namespace}
    						{--prop= : If defined the job will be pushed to a queue}
    						{--async : If defined the job will be pushed to a queue}
    						{--authoriser : If defined creates an authoriser}
    						{--validator : If defined creates a validator}
    						';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new command job to be used with the command bus';

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

		$async = $this->option('async');
		$authoriser = $this->option('authoriser');
		$validator = $this->option('validator');
		$properties = explode(',',$this->option('prop'));

		$this->createCommandJob($classname, $namespace, $async, $properties);
		$this->createCommandJobHandler($classname, $namespace);

		if($authoriser) $this->createAuthoriser(true, $classname, $namespace);
		if($validator) $this->createValidator(true, $classname, $namespace, $properties);

    }


	private function createCommandJob($classname, $namespace, $async, $properties){

		$stub = \File::get(app_path().'/Console/Commands/stubs/CommandJob.stub');

		$stub = str_replace('{{classname}}', $classname, $stub);
		$stub = str_replace('{{namespace}}', (strlen($namespace)>0?'\\':'').$namespace, $stub);

		$stub = str_replace('{{async1}}', ($async ? "use Illuminate\\Contracts\\Queue\\ShouldQueue;\nuse Illuminate\\Queue\\InteractsWithQueue;" : ''), $stub);
		$stub = str_replace('{{async2}}', ($async ? 'implements ShouldQueue' : ''), $stub);
		$stub = str_replace('{{async3}}', ($async ? 'use InteractsWithQueue, SerializesModels;' : ''), $stub);

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

		$path = $this->getPathForCommandJob($classname, $namespace);
		$parts = explode('/', $path);
		array_pop($parts);
		if(!file_exists(implode('/', $parts))) {
			\File::makeDirectory(implode('/', $parts), 0777, true);
		}

		\File::put($path, $stub);

	}

	private function getPathForCommandJob($classname, $namespace){

		return app_path().'/Jobs/Commands/'.str_ireplace('\\', '/', $namespace).(strlen($namespace)>0?'/':'').$classname.'.php';

	}

	private function createCommandJobHandler($classname, $namespace){

		$stub = \File::get(app_path().'/Console/Commands/stubs/CommandHandler.stub');

		$stub = str_replace('{{classname}}', $classname, $stub);
		$stub = str_replace('{{namespace}}', (strlen($namespace)>0?'\\':'').$namespace, $stub);

		$path = $this->getPathForCommandJobHandler($classname, $namespace);
		$parts = explode('/', $path);
		array_pop($parts);
		if(!file_exists(implode('/', $parts))) {
			\File::makeDirectory(implode('/', $parts), 0777, true);
		}

		\File::put($path, $stub);

	}

	private function getPathForCommandJobHandler($classname, $namespace){

		return app_path().'/Handlers/Commands/'.str_ireplace('\\', '/', $namespace).(strlen($namespace)>0?'/':'').$classname.'Handler.php';

	}
}
