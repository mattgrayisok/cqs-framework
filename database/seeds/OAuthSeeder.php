<?php
use App\Models\OAuthClient;
use App\Models\OAuthGrant;
use App\Models\OAuthScope;
use Illuminate\Database\Seeder;

/**
 * User: Slice
 * Date: 18/08/15
 * Time: 20:06
 */

class OAuthSeeder extends Seeder{

	private $grants = ['authorization_code', 'password', 'client_credentials'];
	private $scopes = [
        'user_read' => 'Read access to all user data',
        'user_write' => 'Write access to user content',
        'user_core' => 'Core user functionality, such as creating and deleting accounts',
        'content' => 'Write access to core service data'
    ];

    public function run()
    {

    	foreach($this->grants as $grant){
    		$thisGrant = new OAuthGrant([
    			'id' => $grant
    		]);
    		$thisGrant->save();
    	}

    	foreach($this->scopes as $scopeName => $scopeDescription){
    		$thisScope = new OAuthScope([
    			'id' => $scopeName,
    			'description' => $scopeDescription
    		]);
    		$thisScope->save();	
    	}

    }

}