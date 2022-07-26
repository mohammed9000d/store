<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
use App\Models\Order;
use App\Models\OrderItems;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Intl\Countries;


class CheckoutController extends Controller
{
    //

    protected $cart;

    public function __construct(CartRepository $cart)
    {
        $this->cart = $cart;
    }

    public function create()
    {
        return view('front.checkout',[
            'cart' => $this->cart,
            'user' => Auth::user(),
            'countries' => Countries::getNames(),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'billing_name' => 'required|string',
            'billing_email' => 'required|email',
            'billing_phone' => 'required',
            'billing_address' => 'required',
            'billing_city' => 'required',
            'billing_country' => 'required',
        ]);

        DB::beginTransaction();
        try {
            // merge total to request
            $request->merge([
                'total' => $this->cart->total(),
            ]);
            $order = Order::create($request->all());

            $items = [];
            foreach($this->cart->all() as $item) {
                $items[] = [
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ];
//                $order->items()->create([
//                    'product_id' => $item->product_id,
//                    'quantity' => $item->quantity,
//                    'price' => $item->product->price,
//                ]);
            }
            DB::table('order_items')->insert($items);
            DB::commit();
            event(new OrderCreated($order));
            return redirect()->route('orders')->with('success', 'Order created successfully');
        } catch(\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

    }
}
