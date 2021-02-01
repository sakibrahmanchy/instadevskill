<?php

namespace App\Repository\Repositories;

use App\Models\Image;
use App\Repository\Interfaces\ImageRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageRepository extends BaseRepository implements ImageRepositoryInterface {
    protected $model;
    protected $disk = 's3';

    public function __construct(Image $model)
    {
        $this->model = $model;
    }


    public function uploadImageToDrive($folderName, $imageContent)
    {
        $randomlyGeneratedName = Str::uuid();
        $imageNameWithDir = "${folderName}/$randomlyGeneratedName";

        try {
            $fileUploaded = Storage::disk($this->disk)->put($imageNameWithDir, $imageContent);
            if ($fileUploaded) {
                return $this->retrieveImageUrl($imageNameWithDir);
            } else {
                throw new \Exception("Image could not be uploaded!");
            }
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function retrieveImage(): Image
    {
        // TODO: Implement retrieveImage() method.
    }

    public function retrieveImageUrl($imageName)
    {
        return Storage::disk($this->disk)->url($imageName);
    }

    public function storeImage($imageUrl, $imageType, $imageTypeId)
    {
        return $this->model->create([
           'url' => $imageUrl,
           'imageable_type' => $imageType,
           'imageable_id' => $imageTypeId
        ]);
    }
}
