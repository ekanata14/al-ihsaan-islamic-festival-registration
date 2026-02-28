<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Models
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Ambil keyword dari input pencarian
        $search = $request->input('search');

        // 2. Buat query builder
        $query = Category::query();

        // 3. Jika ada input pencarian, filter berdasarkan nama
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        // 4. Eksekusi query dengan pagination dan sertakan keyword di URL pagination
        $viewData = [
            'title' => 'Manajemen Kategori',
            'datas' => $query->latest()->paginate(10)->appends(['search' => $search]),
            'search' => $search
        ];

        return view('admin.category.index', $viewData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $viewData = [
            'title' => 'Create Category',
        ];

        return view('admin.category.create', $viewData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();
            Category::create($validatedData);
            DB::commit();

            return redirect()->route('admin.dashboard.category')->with('success', 'Category created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create category: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);

        $viewData = [
            'title' => 'Edit Category',
            'data' => $category,
        ];

        return view('admin.category.edit', $viewData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $category = Category::findOrFail($validatedData['id']);
            $category->update(['name' => $validatedData['name']]);

            DB::commit();
            return redirect()->route('admin.dashboard.category')->with('success', 'Category updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update category: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            DB::beginTransaction();

            $category = Category::findOrFail($request->id);
            $category->delete();

            DB::commit();
            return redirect()->route('admin.dashboard.category')->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to delete category: ' . $e->getMessage());
        }
    }
}
