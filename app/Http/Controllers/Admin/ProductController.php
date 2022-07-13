<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
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
        $this->authorize('view-any', Product::class);
        $products = Product::with('category')->paginate(5);
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
//        if(!Gate::allows('products.create')){
//            abort(403);
//        }
        $this->authorize('create', Product::class);
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
//        if(!Gate::allows('products.create')){
//            abort(403);
//        }
        $this->authorize('create', Product::class);
         $request->validate(Product::rules());
        $all_request = $request->except(['image']);
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $image = $file->store('/',[
                'disk' => 'uploads'
            ]);
            $all_request['image'] = $image;
        }
//        $all_request['slug'] = Str::slug($request->get('name'));
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
        $product = Product::findOrFail($id);
        return $product->ratings()->get();
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
        $this->authorize('update', $product);
        $categories = Category::withTrashed()->pluck('name', 'id');
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
        $this->authorize('update', $product);
        $request->validate(Product::rules());
        $all_request = $request->except(['image']);
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $image = $file->store('/',[
                'disk' => 'uploads'
            ]);
            $all_request['image'] = $image;
        }
//        $all_request['slug'] = Str::slug($request->get('name'));
        $product->update( $all_request );
        return redirect()->route('products.index')
            ->with('success', 'Updated Product Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        //
//        if(!Gate::allows('products.delete')){
//            abort(403);
//        }
        $product = Product::find($id);
        $this->authorize('delete', $product);
        $product->delete();
//        Storage::disk('uploads')->delete($product->image);
        return redirect()->back()
            ->with('success', 'Deleted Product Successfully');
//        if($isDeleted){
//            return response()->json([
//                'title'=>'Success',
//                'text'=>'Admin deleted successfully',
//                'icon'=>'success'
//            ]);
//
//        }else{
//            return response()->json([
//                'title'=>'Failed',
//                'text'=>'Failed to delete admin',
//                'icon'=>'error'
//            ]);
//
//        }
    }

    public function trash() {
        $products = Product::onlyTrashed()->paginate();
        return view('admin.products.trash', [
            'products' => $products
        ]);
    }

    public function restore($id = null) {
        if($id) {
            $product = Product::onlyTrashed()->find($id);
            $this->authorize('restore', $product);
            $product->restore();
            return redirect()->route('products.index')
                ->with('success', 'Restored Product Successfully');
        }
        $products = Product::onlyTrashed();
        $this->authorize('restore', $products);
        $products->restore();
        return redirect()->route('products.index')
            ->with('success', 'Restored All Products Successfully');

    }

    public function force_delete($id = null) {
        if($id) {
            $product = Product::onlyTrashed()->find($id);
            $this->authorize('force_delete', $product);
            $product->forceDelete();
            return redirect()->route('products.index')
                ->with('success', 'Deleted Product Successfully');
        }
        $products = Product::onlyTrashed();
        $this->authorize('force_delete', $products);
        $products->forceDelete();
        return redirect()->route('products.index')
            ->with('success', 'Deleted All Products Successfully');
    }

}
