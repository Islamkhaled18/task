<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Product;
use App\Traits\ProductTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    use ProductTrait;

    public function index(){

        $products = ProductResource::collection(Product::get());
        return $this->productApiResponse($products,'ok',200);
        
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'desc' => 'required',
  
        ]);

        if ($validator->fails()) {
            return $this->productApiResponse(null,$validator->errors(),400);
        }
    
        $product = Product::create([
            'name' => $request->name,
            'desc' => $request->desc,
            'user_id'=>$request->user_id,
        ]);

        if($product){
            return $this->productApiResponse(new ProductResource($product),'The Product Saved',201);
        }

        return $this->productApiResponse(null,'The Product Not Save',400);
    }


    public function update(Request $request ,$id){

        $product = Product::find($id);

        if(!$product){
            return $this->productApiResponse(null,'The product Not Found',404);
        }

        $product->update([
            'name' => $request->name,
            'desc' => $request->desc,

        ]);

        if($product){
            return $this->productApiResponse(new ProductResource($product),'The product update',201);
        }

    }

    public function destroy($id)
    {    
        $product = Product::find($id);
        if($product->photo){

            Storage::disk('local')->delete('public/files'. $product->photo);
        }
        if($product->photos){
            $photos = explode("," ,$product->photos);

            foreach($photos as $photo){
                Storage::disk('local')->delete('public/files'. $product->photo);
                
            }
        }
        $product->delete();

    }// end of estory


    public function productsUsers(){
        
        $products = Product::with('user')->get();
        return $products ;

        return $this->productApiResponse($products,'ok',200);
    }
}
