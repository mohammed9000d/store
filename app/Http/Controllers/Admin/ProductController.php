<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Response
     */
    public function index()
    {
        //
        $products = Product::paginate(5);
        return view('admin.products.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Response
     */
    public function create()
    {
        //
        $categories = Category::pluck('name', 'id');
        return view('admin.products.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate(Product::rules());
        $all_request = $request->except(['image']);
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $image = $file->store('/',[
                'disk' => 'uploads'
            ]);
            $all_request['image'] = $image;
        }
        $all_request['slug'] = Str::slug($request->get('name'));
        Product::create( $all_request );
        return redirect()->route('products.index')
            ->with('success', 'Created Product Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Response
     */
    public function edit($id)
    {
        //
        $product = product::findOrfail($id);
        $categories = Category::pluck('name', 'id');
        return view('admin.products.edit', ['categories' => $categories, 'product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $request->validate(Product::rules());
        $all_request = $request->except(['image']);
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $image = $file->store('/',[
                'disk' => 'uploads'
            ]);
            $all_request['image'] = $image;
        }
        $all_request['slug'] = Str::slug($request->get('name'));
        $product->update( $all_request );
        return redirect()->route('products.index')
            ->with('success', 'Updated Product Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        //
        $isDeleted = Product::distroy($id);

        Storage::disk('uploads')->delete($product->image);
        if($isDeleted){
            return response()->json([
                'title'=>'Success',
                'text'=>'Admin deleted successfully',
                'icon'=>'success'
            ]);

        }else{
            return response()->json([
                'title'=>'Failed',
                'text'=>'Failed to delete admin',
                'icon'=>'error'
            ]);

        }
    }
}
