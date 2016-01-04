<?php
/**
 * User: Slice
 * Date: 11/08/15
 * Time: 09:09
 */

namespace App\Jobs\Commands;

use App\Exceptions\CommandParameterException;
use App\Jobs\Job;
use App\Jobs\JobAuthState;
use Illuminate\Support\MessageBag;
use ReflectionClass;
use ReflectionMethod;

class BaseCommand extends Job{

    protected $transact = false;
    protected $log = true;
	protected $cache = false;
	protected $cacheTime = 10;
	protected $cacheTags = [];
    protected $authState;

    public function attachAuthState(JobAuthState $state){
        $this->authState = $state;
    }

	/**
	 * @return \App\Jobs\JobAuthState
	 */
    public function getAuthState(){
        return $this->authState;
    }

	public function shouldTransact(){
		return $this->transact;
	}

	public function shouldLog(){
		return $this->log;
	}

	public function shouldCache(){
		return $this->cache;
	}

	public function getCacheTime(){
		return $this->cacheTime;
	}

	public function getCacheTags(){
		return $this->cacheTags;
	}

    public static function hydrateFromInput()
    {

        $className = get_called_class();

        $reflectionMethod = new ReflectionMethod($className, '__construct');

        $params = $reflectionMethod->getParameters();

        $paramsToPass = [];

        $throwError = false;
        $errors = new MessageBag();

        foreach ($params as $param) {

            $paramName = $param->getName();

            if(\Input::has($paramName)){
                $paramsToPass[] = \Input::get($paramName);
            }else{
                if(!$param->isOptional()){
                    $throwError = true;
                    $errors->add('missing_parameters', $paramName);
                }
            }

        }

        if($throwError) {
            throw new CommandParameterException($errors);
        }

        $reflect  = new ReflectionClass($className);

        return $reflect->newInstanceArgs($paramsToPass);

    }


}