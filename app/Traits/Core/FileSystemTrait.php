<?php

namespace App\Traits\Core;

use Intervention\Image\Image;

trait FileSystemTrait
{
	/**
	 * Every method will be describe here properly.
	 *
	 * 
	 */

	/**
	 * imageUpload() method should store the image and it will return the image path or false
	 * 
	 */

	public function imageUpload($file, $filePath, $fileName, $prefix = '', $suffix = '', $disk = null, $width = null, $height = null, $fullView=false, $fileExtension = 'png', $quality = 80)
	{

		if (is_null($disk)) {
            $disk = config('filesystems.uploads');
        }

        $mimeType = $file->getClientMimeType();
        $imageMimeTypes = config('configuration.image_mime_types');

        if (in_array($mimeType, $imageMimeTypes)) {

            $imageFile = Image::make($file);

            if (!is_null($width) && !is_null($height) && is_int($width) && is_int($height)) {

                if($fullView){

                    $imageFile->resize($width, $height);
                    $imageFile->resize($width, $height, function ($constraint) {

                        $constraint->aspectRatio();

                    });

                    $background = Image::canvas($width, $height);
                    $imageFile = $background->insert($imageFile, 'center');
                }else{

                    $imageFile->fit($width, $height);
                }

            }elseif (!is_null($width) && is_int($width)){

                $imageFile->resize($width, null, function ($constraint) {
                    $constraint->aspectRatio();

                });

            }elseif (!is_null($height) && is_int($height)){

                $imageFile->resize(null, $height, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }

            $imageFile->encode($fileExtension, $quality);
            $fileName = $prefix . '_' . $fileName . '_' . $suffix . '.' . $fileExtension;
            $path = $filePath . '/' . $fileName;
            $stored = Storage::disk($disk)->put($path, $imageFile->__toString());
        } else {
            $fileName = $prefix . '_' . $fileName . '_' . $suffix . '.' . $file->getClientOriginalExtension();
            $stored = $file->storeAs($filePath, $fileName, $disk);

        }

        return isset($stored) ? $fileName : false;

	}
}
