<?php


namespace App\Models;

use Rhumsaa\Uuid\Uuid;

class OAuthClient extends \Eloquent{

    protected $table = 'oauth_clients';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        /**
         * Attach to the 'creating' Model Event to provide a UUID
         * for the `id` field (provided by $model->getKeyName())
         */
        static::creating(function ($model) {
            $model->id = (string)Uuid::uuid4();
        });

    }


    public function oauth_grants(){
        return $this->belongsToMany('\App\Models\OAuthGrant', 'oauth_client_grants', 'client_id', 'grant_id')->withTimestamps();
    }

    public function oauth_scopes(){
        return $this->belongsToMany('\App\Models\OAuthScope', 'oauth_client_scopes', 'client_id', 'scope_id')->withTimestamps();
    }

    public function oauth_client_endpoints(){
        return $this->hasMany('\App\Models\OAuthClientEndpoint', 'client_id');
    }
} 