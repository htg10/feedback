<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        return view('admin.department.index', compact('departments'));
    }

    public function create()
    {
        $buildings = Building::orderBy('name')->get();
        return view('admin.department.create', compact('buildings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            //
        ]);

        $data = $request->all();

        Department::create($data);
        return redirect('/admin/departments')->with('success', 'Department Add successfully.');
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);
        $buildings = Building::all();
        return view('admin.department.edit', compact('department', 'buildings'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            //
        ]);

        $department = Department::findOrFail($id);

        $data = $request->all();

        $department->update($data);

        return redirect('/admin/departments')->with('success', 'Department updated successfully.');
    }

    function delete($id)
    {
        $department = Department::find($id);
        $department->delete();
        return redirect()->route('admin.departments')->with('success', 'Department deleted successfully.');

    }
}
