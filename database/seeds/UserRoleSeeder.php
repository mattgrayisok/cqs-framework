<?php
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;

/**
 * User: Slice
 * Date: 18/08/15
 * Time: 20:06
 */

class UserRoleSeeder extends Seeder{

    private $roles = [UserRole::ACTOR_ROLE];

    public function run()
    {

        foreach($this->roles as $roleName){
            UserRole::create([
               'name' => $roleName
            ]);
        }

    }

}