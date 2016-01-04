<?php
/**
 * User: Slice
 * Date: 17/10/15
 * Time: 13:14
 */

namespace App\PipeHandlers\Validators\Queries\Users;


use App\Jobs\Commands\BaseCommand;
use App\PipeHandlers\BaseValidator;

class UserDetailsQueryValidator extends BaseValidator{

	public function validate(BaseCommand $command){

		$this->baseValidate($command, [
			'userId' => 'required_without:username|integer',
			'username' => 'required_without:userId|string',
		]);

	}

}