<?php

namespace App\Http\Controllers;

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
        $this->cart->add([
            'id' => 1,
            'name' => 'Item 1',
            'price' => 10,
        ]);
        return $this->cart->all();
    }
}
