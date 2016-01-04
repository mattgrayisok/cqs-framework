<?php

namespace App\Handlers\Commands\Users;

use App\Jobs\Commands\Users\UserUpdateAvatarCommand;
use App\Models\User;
use App\Util\Images\ImagePrepService;

class UserUpdateAvatarCommandHandler {

    public function handle(UserUpdateAvatarCommand $command)
    {

		$user = User::find($command->getAuthState()->actingUserId);

		$user->profile_image_id = $command->image;

		$user->save();

    }

}