<?php
/**
 * User: Slice
 * Date: 18/08/15
 * Time: 20:47
 */

class ExtendedTest extends \Codeception\TestCase\Test{

	/**
	 * @var \UnitTester
	 */
	protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {

		Mockery::close();

	}

}