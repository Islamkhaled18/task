<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductContrller extends Controller
{
    public function index(){
        $proodcuts = Product::all();
        return view('products',compact('products'));
    }
}
