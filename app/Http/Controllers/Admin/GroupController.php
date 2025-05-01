<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Models
use App\Models\Group;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $viewData = [
            'title' => 'Groups',
            'datas' => Group::latest()->paginate(10)
        ];

        return view('admin.group.index', $viewData);
    }

    public function getAllGroups()
    {
        $groups = Group::latest()->get();

        return response()->json($groups);
    }

    public function getGroupByName(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $group = Group::where('name', 'like', '%' . $validatedData['name'] . '%')->get();

        return response()->json($group);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $viewData = [
            'title' => 'Create Group',
        ];

        return view('admin.group.create', $viewData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            Group::create($validatedData);
            DB::commit();
            return redirect()->route('admin.dashboard.group')->with('success', 'Group created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
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
            'data' => Group::findOrFail($id)
        ];

        return view('admin.group.edit', $viewData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $group = Group::findOrFail($request->id); // pastikan $id sudah tersedia
            $group->update($validatedData);
            DB::commit();

            return redirect()->route('admin.dashboard.group')->with('success', 'Group updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();

        try {
            $group = Group::findOrFail($request->id); // pastikan $id sudah tersedia
            $group->delete();
            DB::commit();
            return redirect()->route('admin.dashboard.group')->with('success', 'Group deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
