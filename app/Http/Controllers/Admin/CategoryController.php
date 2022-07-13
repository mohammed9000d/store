<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        $categories = Category::paginate(5);
        session()->get('success');
        return view('admin.categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        //
        $parents = Category::all();
        return view('admin.categories.create', ['parents' => $parents]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(CategoryRequest $request)
    {
        //
        $request->merge([
            'slug' => Str::slug($request->get('name'))
        ]);
        Category::create($request->all());
        return redirect()->back()
            ->with('success', 'Created Category Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(Category $category)
    {
        return $category->products()
            ->with('category:id,name')
            ->where('price', '>', 0)
            ->orderBy('price', 'desc')
            ->get();
//        dd($products);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        //
        $category = Category::findOrFail($id);
        if(!$category){
            abort(404);
        }
        $parents = Category::withTrashed()->where('id', '<>', $category->id)->get();
        return view('admin.categories.edit', ['parents' => $parents, 'category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(CategoryRequest $request, $id)
    {
        //
        $category = Category::findOrfail($id);
        $request->merge([
            'slug' => Str::slug($request->get('name'))
        ]);
        $category->update($request->all());
        return redirect()->route('categories.index')
            ->with('success', 'Updated Category Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return string
     */
    public function destroy($id)
    {
        Category::destroy($id);
        return redirect()->back()
            ->with('success', 'Deleted Category Successfully');
    }

    public function trash(){
        $categories = Category::onlyTrashed()->paginate(5);
        return view('admin.categories.trash', ['categories' => $categories]);
    }

    public function restore(Request $request, $id = null){
        if($id){
            $category = Category::onlyTrashed()->find($id);
            $category->restore();
            return redirect()->route('categories.index')
                ->with('success', 'Restored Category Successfully');
        }
        Category::onlyTrashed()->restore();
        return redirect()->route('categories.index')
            ->with('success', 'Restored All Categories Successfully');

    }

    public function force_delete($id = null){
        if($id){
            $category = Category::onlyTrashed()->find($id);
            $category->forceDelete();
            return redirect()->route('categories.index')
                ->with('success', 'Deleted Category Successfully');
        }
        Category::onlyTrashed()->forceDelete();
        return redirect()->route('categories.index')
            ->with('success', 'Deleted All Categories Successfully');
    }
}
