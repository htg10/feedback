<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BuildingController extends Controller
{
    public function index()
    {
        $buildings = Building::all();
        return view('admin.building.index', compact('buildings'));
    }

    public function create()
    {
        return view('admin.building.create');
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         //
    //     ]);

    //     $data = $request->all();

    //     Building::create($data);
    //     return redirect('/admin/buildings')->with('success', 'Building Add successfully.');
    // }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $data = $request->only(['name']);
        $data['slug'] = Str::slug($request->name);

        Building::create($data);
        return redirect('/admin/buildings')->with('success', 'Building added successfully.');
    }

    public function edit($id)
    {
        $building = Building::findOrFail($id);
        return view('admin.building.edit', compact('building'));
    }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         //
    //     ]);

    //     $building = Building::findOrFail($id);

    //     $data = $request->all();

    //     $building->update($data);

    //     return redirect('/admin/buildings')->with('success', 'Building updated successfully.');
    // }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $building = Building::findOrFail($id);

        $data = $request->only(['name']);
        $data['slug'] = Str::slug($request->name);

        $building->update($data);

        return redirect('/admin/buildings')->with('success', 'Building updated successfully.');
    }

    function delete($id)
    {
        $building = Building::find($id);
        if (!$building) {
            return redirect()->route('admin.buildings')->with('error', 'Building not found.');
        }
        $building->delete();
        return redirect()->route('admin.buildings')->with('success', 'Building deleted successfully.');

    }
}
