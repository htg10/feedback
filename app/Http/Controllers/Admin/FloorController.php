<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Floor;
use Illuminate\Http\Request;

class FloorController extends Controller
{
    public function index()
    {
        $floors = Floor::all();
        return view('admin.floor.index', compact('floors'));
    }

    public function create()
    {
        return view('admin.floor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            //
        ]);

        $data = $request->all();

        Floor::create($data);
        return redirect('/admin/floors')->with('success', 'Floor Add successfully.');
    }

    public function edit($id)
    {
        $floor = Floor::findOrFail($id);
        return view('admin.floor.edit', compact('floor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            //
        ]);

        $floor = Floor::findOrFail($id);

        $data = $request->all();

        $floor->update($data);

        return redirect('/admin/floors')->with('success', 'Floor updated successfully.');
    }

    function delete($id)
    {
        $floor = Floor::find($id);
        $floor->delete();
        return redirect()->route('admin.floors')->with('success', 'Floor deleted successfully.');

    }
}
