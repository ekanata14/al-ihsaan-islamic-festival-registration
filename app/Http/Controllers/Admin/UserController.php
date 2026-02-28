<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

// Models
use App\Models\User;
use App\Models\Group;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Ambil keyword pencarian dari request
        $search = $request->input('search');

        // 2. Buat query dasar: hanya ambil role 'user' atau 'khitan'
        // Gunakan whereIn agar lebih aman saat digabungkan dengan kondisi OR pada pencarian
        $query = User::whereIn('role', ['user', 'khitan']);

        // 3. Jika ada input pencarian, tambahkan filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone_number', 'like', "%{$search}%")
                    // Mencari berdasarkan nama grup/TPQ di tabel relasi
                    ->orWhereHas('group', function ($groupQuery) use ($search) {
                        $groupQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // 4. Eksekusi query dengan pagination dan sertakan keyword search di link pagination
        $viewData = [
            "title" => "User Datas",
            "datas" => $query->latest()->paginate(10)->appends(['search' => $search]),
            "search" => $search // Kirim keyword ke view untuk ditampilkan kembali di input box
        ];

        return view('admin.user.index', $viewData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $viewData = [
            'title' => 'Tambah Data User',
            'groups' => Group::orderBy('name', 'asc')->get(), // Ambil data group untuk opsi dropdown
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
            DB::commit();
            return redirect()->route('admin.dashboard.user')->with('success', 'User created successfully.');
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
            'title' => 'Edit Data User',
            'user' => User::findOrFail($id), // Ambil data user spesifik
            'groups' => Group::orderBy('name', 'asc')->get(),
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
            return redirect()->route('admin.dashboard.user')->with('success', 'User updated successfully.');
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
            return redirect()->route('admin.dashboard.user')->with('success', 'User deleted successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }
}
