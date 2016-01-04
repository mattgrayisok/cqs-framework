<?php
/**
 * User: Slice
 * Date: 07/11/15
 * Time: 21:19
 */

namespace App\Util\Profiling;


class TimingProfiler
{

	private $activeProfiles;

	public function __construct()
	{
		$this->activeProfiles = [];
	}

	/**
	 * @param $name
	 * @return \App\Util\Profiling\TimingProfile
	 */

	public function profiles($name)
	{

		if (isset($this->activeProfiles[$name])) {
			return $this->activeProfiles[$name];
		}

		$profile = new TimingProfile($name);
		$this->activeProfiles[$name] = $profile;

		return $profile;

	}

}