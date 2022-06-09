<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\image;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    use ImageTrait;

    public function store(Request $request)
    {

        foreach($request->file('photo') as $image) {

            $file             = new image();
            $file->photo      = $image->store('files', 'public');
            $file->product_id = $request->product_id;
            $file->save();

        }
  
        if($file) {
            return $this->imageApiResponse($file,'The photo Saved',201);
        }
    }
}
