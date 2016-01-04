<?php
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * User: Slice
 * Date: 18/08/15
 * Time: 20:06
 */

class TestUserSeeder extends Seeder{

    public function run()
    {

        $user = new User([
            'username' => 'test-user',
            'email' => 'testuser@lanyard.fm'
        ]);

        $user->password = 'password';
        $user->save();

        $user2 = new User([
            'username' => 'test-user-2',
            'email' => 'testuser2@lanyard.fm'
        ]);

        $user2->password = 'password';
        $user2->save();

    }

}