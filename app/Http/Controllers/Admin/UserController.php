<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

// Models
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $viewData = [
            "title" => "User Datas",
            "datas" => User::where('role', 'user')->latest()->paginate(10)
        ];

        return view('admin.user.index', $viewData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $viewData = [
            'title' => 'Create User',
        ];

        return view('admin.user.create', $viewData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'group_id' => 'required|exists:groups,id',
            'role' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $user = User::create($validatedData);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create user: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $viewData = [
            'title' => 'Edit User',
        ];

        return view('admin.user.edit', $viewData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $request->id,
            'phone_number' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'group_id' => 'required|exists:groups,id',
            'role' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $user = User::findOrFail($request->id);
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->phone_number = $validatedData['phone_number'];
            if (!empty($validatedData['password'])) {
                $user->password = bcrypt($validatedData['password']);
            }
            $user->group_id = $validatedData['group_id'];
            $user->role = $validatedData['role'];
            $user->save();

            DB::commit();
            return redirect()->route('admin.user.index')->with('success', 'User updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update user: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            DB::beginTransaction();

            $user = User::findOrFail($request->id);
            $user->delete();

            DB::commit();
            return redirect()->route('admin.user.index')->with('success', 'User deleted successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }
}
