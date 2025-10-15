<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);
        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        $users = User::where('role_id', 2)->get();
        return view('admin.product.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $data = $request->all();

        Product::create($data);
        return redirect('/admin/product')->with('success', 'Product Create successfully.');
    }

    function delete($id)
    {
        $product = Product::find($id);
        $product->delete();


    }
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $users = User::where('role_id', 2)->get();
        return view('admin.product.edit', compact('product', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            //
        ]);

        $product = Product::findOrFail($id);

        $data = $request->all();

        $product->update($data);

        return redirect('/admin/product')->with('success', 'Product updated successfully.');
    }



}
