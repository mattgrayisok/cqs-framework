<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 31/07/15
 * Time: 18:12
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Image extends Model{

    protected $fillable = ['width', 'height', 'mime_type', 'extension', 'path', 'description', 'average_colour'];

}