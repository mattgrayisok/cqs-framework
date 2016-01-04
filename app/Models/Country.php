<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 31/07/15
 * Time: 18:05
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Country extends Model{

    protected $fillable = [];

    public function defaultTimezone(){
        return $this->belongsTo(Timezone::class, 'timezone_id');
    }



}