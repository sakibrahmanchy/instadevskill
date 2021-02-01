<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Repository\Interfaces\ImageRepositoryInterface;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    private $imageRepo;
    public function __construct(ImageRepositoryInterface $imageRepo)
    {
        $this->imageRepo = $imageRepo;
    }

    public function storeTestImage(Request $request)
    {
        $this->validate($request, [
           'image' => 'required|file'
        ]);
        $file = fopen($request->image, 'r+');
        try {
            $imageUrl = $this->imageRepo->uploadImageToDrive('test-images', $file);
            $image = $this->imageRepo->storeImage($imageUrl, Post::class, 1);
            return response()->json([
                'message' => 'Image uploaded successfully',
                'url' => $image->url
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}
