<?php
/**
 * User: Slice
 * Date: 07/11/15
 * Time: 21:21
 */

namespace App\Util\Profiling;


class TimingProfile
{

	public $startTime;
	public $endTime;
	public $laps;
	public $name;

	public function __construct($name)
	{
		$this->name = $name;
		$this->startTime = 0;
		$this->endTime = 0;
		$this->laps = [];
	}

	/**
	 * @return \App\Util\Profiling\TimingProfile
	 */

	public function start()
	{

		$this->startTime = microtime(true);

		return $this;

	}

	/**
	 * @param $lapName
	 * @return \App\Util\Profiling\TimingProfile
	 */

	public function setLap($lapName)
	{

		$this->laps[$lapName] = microtime(true);

		return $this;

	}

	/**
	 * @param $lapName
	 * @return float
	 */

	public function getLap($lapName)
	{

		if (!isset($this->laps[$lapName])) {
			return 0;
		}

		return $this->laps[$lapName];

	}

	/**
	 * @param $lapName
	 * @return float
	 */

	public function timeToLap($lapName)
	{

		if (!isset($this->laps[$lapName])) {
			return 0;
		}

		return $this->laps[$lapName] - $this->startTime;

	}

	/**
	 * @return \App\Util\Profiling\TimingProfile
	 */

	public function end()
	{

		$this->endTime = microtime(true);

		return $this;

	}

	/**
	 * @return float
	 */

	public function totalTime()
	{

		return $this->endTime - $this->startTime;

	}

}