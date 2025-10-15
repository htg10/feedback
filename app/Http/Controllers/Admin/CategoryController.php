<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            //
        ]);

        $data = $request->all();

        Category::create($data);
        return redirect('/admin/categories')->with('success', 'Category Add successfully.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            //
        ]);

        $category = Category::findOrFail($id);

        $data = $request->all();

        $category->update($data);

        return redirect('/admin/categories')->with('success', 'Category updated successfully.');
    }

    function delete($id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect()->route('admin.categories')->with('success', 'Category deleted successfully.');

    }
}
