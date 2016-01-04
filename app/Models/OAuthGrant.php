<?php


namespace App\Models;


class OAuthGrant extends \Eloquent{

    protected $table = 'oauth_grants';
    public $incrementing = false;

    public function oauth_clients(){
        return $this->belongsToMany('\App\Models\OAuthClient', 'oauth_client_grants', 'grant_id', 'client_id')->withTimestamps();
    }

} 