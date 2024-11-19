<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Laravel\Facades\Image;

use function PHPUnit\Framework\returnSelf;

class ImageController extends Controller
{
   public function fileUpload(){
    return view('image-upload');
   }

   public function storeImage(Request $request){
    $request-> validate([
        'image' => 'required|image|mimes:png,jpg,jpeg,gif|max:2048'
    ]);

    // Upload Image functionality

    $image = $request->file('image');

    // Unique image name generation

     $imageName = time().'.'.$image->getClientOriginalExtension();

    //Upload Image

      $image->move('uploads', $imageName);

    // Resizing Image Using Intervention

      $imgmanager = new ImageManager(new Driver());

     // Reading uploaded image from local file system
 
       $thumbImage =  $imgmanager->read('uploads/'.$imageName);

     // Resize The Image 

     $thumbImage->resize(300, 200);

     //Store the resized image in different directory
      
     $response = $thumbImage->save(public_path('uploads/thumbnails/'.$imageName));

     if ($response) {
        return back()->with('success','Image uploaded and resized successfully');

     }
     return back()->with('error','Unable to uploaded and resized image');


     
   }
}
