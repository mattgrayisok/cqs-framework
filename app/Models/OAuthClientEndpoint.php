<?php


namespace App\Models;

class OAuthClientEndpoint extends \Eloquent{

    protected $table = 'oauth_client_endpoints';

    public function oauth_client(){
        return $this->belongsTo('\App\Models\OAuthClient', 'client_id');
    }

} 