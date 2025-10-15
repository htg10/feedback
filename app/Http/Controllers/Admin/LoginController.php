<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login()
    {
        return view('admin.login.login');
    }

    public function register()
    {
        $departments = Department::all();
        return view('admin.login.register', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed'],
        ]);
        // dd($request);
        User::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'department_id' => $request->department_id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users')->with('success', 'User Create successful.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $departments = Department::all();
        return view('admin.login.edit', compact('user', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'mobile' => 'nullable|regex:/^\d{10}$/',
        ]);

        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->department_id = $request->department_id;
        $user->email = $request->email;

        // Only update the password if it's not empty
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users')->with('success', 'Doctor updated successfully');
    }


    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended(route('dashboard'));
        }
        return redirect(route('login'))->with('error', 'Login details are not valid');
    }
    public function logout()
    {
        auth()->guard('web')->logout();
        return redirect(route('login'))->with('success', 'You are logout successfully');
    }
}
