<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CartController extends Controller
{
    //
    protected $cart;
    public function __construct(CartRepository $cart)
    {
        $this->cart = $cart;
    }
    public function index()
    {
        $cart = $this->cart->all();
        return view('front.cart', [
            'cart' => $cart,
            'total' => $this->cart->total(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
           'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['integer', 'min:1', function($att, $value, $fail) {
                $id = request()->input('product_id');
                $product = Product::find($id);
                if($value > $product->quantitiy){
                    $fail('There are only ' . $product->quantitiy . ' items in stock');
                }
            }]
        ]);

        $cart = $this->cart->add($request->post('product_id'), $request->post('quantity', 1));

        if($request->expectsJson()){
            return $this->cart->all();
        }
        return redirect()->back()->with('success', 'Product added to cart');
    }
}
