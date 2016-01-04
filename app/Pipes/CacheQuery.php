<?php
/**
 * User: Slice
 * Date: 17/10/15
 * Time: 02:25
 */

namespace App\Pipes;


use App\Jobs\Commands\BaseCommand;

class CacheQuery {

	public function handle(BaseCommand $command, $next)
	{

		if(!$command->shouldCache()){
			return $next($command);
		}

		$parameters = serialize(get_object_vars($command));
		$parametersHash = md5($parameters);

		$cacheName = get_class($command).'|'.$parametersHash;
		$cacheHash = md5($cacheName);

		//Return existing cache or create a new one
		return \Cache::tags($command->getCacheTags())->remember($cacheHash, $command->getCacheTime(), function() use ($next, $command){
			\Log::info('Caching result for query '.get_class($command));
			return $next($command);
		});

	}

}