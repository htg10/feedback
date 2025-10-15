<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Category;
use App\Models\Floor;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return view('admin.room.index', compact('rooms'));
    }

    public function create()
    {
        $buildings = Building::all();
        $floors = Floor::all();
        $categories = Category::all();
        return view('admin.room.create', compact('buildings', 'floors', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            //
        ]);

        $data = $request->all();

        Room::create($data);
        return redirect('/admin/rooms')->with('success', 'Room Add successfully.');
    }

    public function edit($id)
    {
        $buildings = Building::all();
        $floors = Floor::all();
        $categories = Category::all();
        $room = Room::findOrFail($id);
        return view('admin.room.edit', compact('room', 'buildings', 'floors', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            //
        ]);

        $room = Room::findOrFail($id);

        $data = $request->all();

        $room->update($data);

        return redirect('/admin/rooms')->with('success', 'Room updated successfully.');
    }

    function delete($id)
    {
        $room = Room::find($id);
        $room->delete();
        return redirect()->route('admin.rooms')->with('success', 'Room deleted successfully.');

    }
}
