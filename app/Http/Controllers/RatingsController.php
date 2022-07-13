<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;

class RatingsController extends Controller
{
    //

    public function store(Request $request, $type)
    {
        //
        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'id' => 'required|integer|exists:products,id'
        ]);
        if($type == 'product') {
            $model = Product::find($request->id);
        } elseif($type == 'user') {
            $model = User::find($request->id);
        }
        $rating = $model->ratings()->create([
            'rating' => $request->post('rating')
        ]);
//        $rating = Rating::create([
//            'rateable_type' => User::class,
//            'rateable_id' => $request->post('id'),
//            'rating' => $request->post('rating'),
//        ]);

        return $rating;
    }
}
