<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $categories = Category::all();
        return view('admin.categories.index', ['categories' => $categories]);
        session()->get('success');
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
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string|max:100|min:3',
            'description' => 'nullable|string|min:5',
            'parent_id' => 'nullable|int|exists:categories,id',
            'image' => 'nullable|image'
        ]);
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
    public function show($id)
    {
        //
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
        $category = Category::find($id);
        $parents = Category::all();
        return view('admin.categories.edit', ['parents' => $parents, 'category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
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
    }
}
