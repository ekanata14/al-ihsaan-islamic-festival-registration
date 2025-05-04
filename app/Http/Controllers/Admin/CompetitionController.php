<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// Models
use App\Models\Competition;
use App\Models\Category;

class CompetitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $viewData = [
            'title' => 'Competitions',
            'datas' => Competition::latest()->paginate(10)
        ];

        return view('admin.competition.index', $viewData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $viewData = [
            'title' => 'Create Competition',
            'categories' => Category::all(),
        ];

        return view('admin.competition.create', $viewData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image file
            'type' => 'required|string',
            'category_id' => 'required|integer|exists:categories,id',
            'registration_start' => 'required|date',
            'registration_end' => 'required|date|after_or_equal:registration_start',
            'status' => 'required|string',
        ]);

        try {
            // Handle file upload for image_url
            // if ($request->hasFile('image_url')) {
            //     $date = now()->format('dmY'); // Get the current date in dmy format
            //     $uniqueId = uniqid(); // Generate a unique ID
            //     $extension = $request->file('image_url')->getClientOriginalExtension(); // Get the file extension
            //     $fileName = "{$date}-{$uniqueId}.{$extension}"; // Combine to create the file name

            //     // Store the uploaded file in the 'public/competitions' directory with the custom name
            //     $imagePath = $request->file('image_url')->storeAs('public/competitions', $fileName);

            //     // Save the relative path to the file in the database
            //     $validatedData['image_url'] = str_replace('public/', 'storage/', $imagePath);
            // }
            $validatedData['image_url'] = $validatedData['image_url']->store('competitions', 'public');

            Competition::create($validatedData);
            return redirect()->route('admin.dashboard.competition')->with('success', 'Competition created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create competition: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Competition $competition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $competition = Competition::findOrFail($id);
        $viewData = [
            'title' => 'Edit Competition',
            'categories' => Category::all(),
            'data' => $competition,
        ];

        return view('admin.competition.edit', $viewData);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer|exists:competitions,id',
            'name' => 'required|string',
            'description' => 'required|string',
            'type' => 'required|string',
            'category_id' => 'required|integer|exists:categories,id',
            'registration_start' => 'required|date',
            'registration_end' => 'required|date|after_or_equal:registration_start',
            'status' => 'required|string',
            'certificate_url' => 'nullable|file|mimes:jpeg,png,pdf|max:2048', // Validate file if provided
        ]);
        try {
            // Find the competition
            $competition = Competition::findOrFail($validatedData['id']);

            // // Handle file upload for image_url
            // if ($request->hasFile('image_url')) {
            //     $date = now()->format('dmY'); // Get the current date in dmy format
            //     $uniqueId = uniqid(); // Generate a unique ID
            //     $extension = $request->file('image_url')->getClientOriginalExtension(); // Get the file extension
            //     $fileName = "{$date}-{$uniqueId}.{$extension}"; // Combine to create the file name

            //     // Store the uploaded file in the 'public/competitions' directory with the custom name
            //     $imagePath = $request->file('image_url')->storeAs('public/competitions', $fileName);

            //     // Delete the old image file if it exists
            //     if ($competition->image_url && Storage::exists(str_replace('storage/', 'public/', $competition->image_url))) {
            //         Storage::delete(str_replace('storage/', 'public/', $competition->image_url));
            //     }

            //     // Save the relative path to the file in the database
            //     $validatedData['image_url'] = str_replace('public/', 'storage/', $imagePath);
            // }
            if ($request->hasFile('image_url')) {
                // Delete the old image file if it exists
                if ($competition->image_url && Storage::exists(str_replace('storage/', 'public/', $competition->image_url))) {
                    Storage::delete(str_replace('storage/', 'public/', $competition->image_url));
                }

                // Store the new image file
                $validatedData['image_url'] = $request->file('image_url')->store('competitions', 'public');
            }

            // Update the competition record
            $competition->update($validatedData);

            return redirect()->route('admin.dashboard.competition')->with('success', 'Competition updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update competition: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer|exists:competitions,id',
        ]);

        try {
            // Find the competition
            $competition = Competition::findOrFail($validatedData['id']);

            // Delete the associated image file
            if ($competition->image_url && Storage::exists(str_replace('storage/', 'public/', $competition->image_url))) {
                Storage::delete(str_replace('storage/', 'public/', $competition->image_url));
            }

            // Delete the competition record
            $competition->delete();

            return redirect()->route('admin.dashboard.competition')->with('success', 'Competition deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete competition: ' . $e->getMessage());
        }
    }
}
