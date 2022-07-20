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
        return view('cart', [
            'cart' => $cart
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
           'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['integer', 'min:1', function($att, $value, $fail) {
                $id = request()->input('product_id');
                $product = Product::find($id);
                if($value > $product->quantity){
                    $fail('There are only ' . $product->quantity . ' items in stock');
                }
            }]
        ]);

        $this->cart->add($request->post('product_id'), $request->post('quantity', 1));

        return redirect()->back()->with('success', 'Product added to cart');
    }
}
