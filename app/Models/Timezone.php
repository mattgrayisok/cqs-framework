<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 31/07/15
 * Time: 18:06
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timezone extends Model {

    protected $fillable = ['name', 'utc_offset', 'utc_offset_string'];

}