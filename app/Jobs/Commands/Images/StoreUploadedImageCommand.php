<?php

namespace App\Jobs\Commands\Images;

use App\Jobs\Commands\BaseCommand;
use Illuminate\Queue\SerializesModels;


/**
 * Class StoreUploadedImageCommand
 * @package App\Jobs\Commands\Images
 */
class StoreUploadedImageCommand extends BaseCommand {

    

    protected $log = false;
    protected $transact = false;

	/**
	 * @var \Symfony\Component\HttpFoundation\File\UploadedFile
	 */
	public $image;


    public function __construct( $image )
    {

		$this->image = $image;


    }

}