<?php

namespace App\Handlers\Commands\Users;

use App\Events\UserUpdatedEvent;
use App\Jobs\Commands\Users\UserUpdateCommand;
use App\Models\User;

class UserUpdateCommandHandler {

    public function handle(UserUpdateCommand $command)
    {

		$user = User::find($command->getAuthState()->actingUserId);

		$user->email = $command->email;

		$user->save();

		\Event::fire(new UserUpdatedEvent($user));

	}

}