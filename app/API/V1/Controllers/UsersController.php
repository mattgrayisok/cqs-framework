<?php
/**
 * User: Slice
 * Date: 23/09/15
 * Time: 22:16
 */

namespace App\API\V1\Controllers;

use App\Adapters\APIAdapter;
use App\Jobs\Commands\Users\UserCreateCommand;
use App\Exceptions\AuthenticationException;
use App\Exceptions\AuthorisationException;
use App\Exceptions\CommandParameterException;
use App\Exceptions\ValidationException;
use App\Jobs\Commands\Users\UserUpdateAvatarCommand;
use App\Models\Image;
use Illuminate\Foundation\Bus\DispatchesJobs;

class UsersController extends APIController
{

    private $adapter;

    public function __construct(APIAdapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function store()
    {

        return $this->wrapCommonExceptions(function(){

            $command = UserCreateCommand::hydrateFromInput();

            $userId = $this->adapter->dispatchCommand($command);

        	return $this->respondSuccess(['entity_id' => $userId], 201);

		});

    }

	public function updateAvatar()
	{

		return $this->wrapCommonExceptions(function(){

			$imageStoreCommand = UserUpdateAvatarCommand::hydrateFromInput();

			$imageId = $this->adapter->dispatchCommand($imageStoreCommand);

			$updateAvatarCommand = new UserUpdateAvatarCommand($imageId);

			$this->adapter->dispatchCommand($updateAvatarCommand);

			return $this->respondSuccess(['entity_id' => $imageId], 201);

		});

	}

}