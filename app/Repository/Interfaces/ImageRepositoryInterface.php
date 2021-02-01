<?php
namespace App\Repository\Interfaces;

use App\Models\Image;
use Illuminate\Support\Collection;

interface ImageRepositoryInterface extends EloquentRepositoryInterface {
    public function uploadImageToDrive($folderName, $imageContent);
    public function storeImage($imageUrl, $imageType, $imageTypeId);
    public function retrieveImageUrl($imageName);
    public function retrieveImage(): Image;
}
