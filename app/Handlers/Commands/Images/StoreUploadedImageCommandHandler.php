<?php

namespace App\Handlers\Commands\Images;

use App\Jobs\Commands\Images\StoreUploadedImageCommand;
use App\Models\Image;
use Intervention\Image\ImageManagerStatic as IntImage;

class StoreUploadedImageCommandHandler {

    public function handle(StoreUploadedImageCommand $command)
    {

		$intImg = IntImage::make($command->image->getRealPath())->orientate();

		$randomFilename = uniqid();
		$fullPath = 'uploads/'.$randomFilename.'.jpg';

		\Storage::disk('images')->put( $fullPath, $intImg->encode('jpg', 75) );

		$width = $intImg->width();
		$height = $intImg->height();

		$average = $intImg->resize(1,1)->pickColor(0,0, 'rgba');

		$newImage = Image::create([
			'width' => $width,
			'height' => $height,
			'mime_type' => 'image/jpeg',
			'extension' => '.jpg',
			'path' => $fullPath,
			'description' => '',
			'average_colour' => $average
		]);

		return $newImage->id;

    }

}