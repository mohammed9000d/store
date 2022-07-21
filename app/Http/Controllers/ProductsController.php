<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    //
    public function index()
    {
        $products = Product::active()->all();
        return view('front.products.index', [
            'products' => $products
        ]);
    }

    public function show($slug)
    {
        $product = Product::where('slug', '=', $slug)->firstOrFail();
        return view('front.products.show', [
            'product' => $product
        ]);
    }
}
