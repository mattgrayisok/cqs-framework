<?php


namespace App\Models;


class OAuthScope extends \Eloquent{

    protected $table = 'oauth_scopes';
    public $incrementing = false;

    public function oauth_clients(){
        return $this->belongsToMany('\App\Models\OAuthClient', 'oauth_client_scopes', 'scope_id', 'client_id')->withTimestamps();
    }

}