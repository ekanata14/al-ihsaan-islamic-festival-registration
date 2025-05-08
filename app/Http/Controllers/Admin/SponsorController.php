<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

// Models
use App\Models\Sponsor;

class SponsorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $viewData = [
            'title' => 'Sponsor',
            'description' => 'Sponsor Page',
            'datas' => Sponsor::paginate(10),
        ];
        return view('admin.sponsor.index', $viewData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $viewData = [
            'title' => 'Create Sponsor',
            'description' => 'Create Sponsor Page',
        ];
        return view('admin.sponsor.create', $viewData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'img_url' => 'required|image|mimes:jpeg,png,jpg,gif',
            'nominal' => 'nullable|integer|min:0',
        ]);

        try {
            DB::beginTransaction();

            // Handle file upload
            if ($request->hasFile('img_url')) {
                $file = $request->file('img_url');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('sponsors', $filename, 'public');
                $validatedData['img_url'] = "storage/{$path}";
            }

            // Create the sponsor
            Sponsor::create($validatedData);

            DB::commit();
            return redirect()->route('admin.dashboard.sponsor')->with('success', 'Sponsor created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'An error occurred while creating the sponsor: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sponsor $sponsor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request  $request)
    {
        $sponsor = Sponsor::find($request->id);
        if (!$sponsor) {
            return redirect()->back()->withErrors(['error' => 'Sponsor not found.']);
        }

        $viewData = [
            'title' => 'Edit Sponsor',
            'description' => 'Edit Sponsor Page',
            'data' => $sponsor,
        ];
        return view('admin.sponsor.edit', $viewData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'img_url' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'nominal' => 'nullable|integer|min:0',
        ]);

        try {
            DB::beginTransaction();

            $sponsor = Sponsor::find($request->id);
            if (!$sponsor) {
                return redirect()->back()->withErrors(['error' => 'Sponsor not found.']);
            }

            // Handle file upload
            if ($request->hasFile('img_url')) {
                // Delete old image if exists
                if ($sponsor->img_url && file_exists(public_path($sponsor->img_url))) {
                    unlink(public_path($sponsor->img_url));
                }

                $file = $request->file('img_url');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('sponsors', $filename, 'public');
                $validatedData['img_url'] = "storage/{$path}";
            }

            // Update the sponsor
            $sponsor->update($validatedData);

            DB::commit();
            return redirect()->route('admin.dashboard.sponsor')->with('success', 'Sponsor updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'An error occurred while updating the sponsor: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            DB::beginTransaction();

            $sponsor = Sponsor::find($request->id);
            if (!$sponsor) {
                return redirect()->back()->withErrors(['error' => 'Sponsor not found.']);
            }

            // Delete image if exists
            if ($sponsor->img_url && file_exists(public_path($sponsor->img_url))) {
                unlink(public_path($sponsor->img_url));
            }

            // Delete the sponsor
            $sponsor->delete();

            DB::commit();
            return redirect()->route('admin.dashboard.sponsor')->with('success', 'Sponsor deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'An error occurred while deleting the sponsor: ' . $e->getMessage()]);
        }
    }
}
