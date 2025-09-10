<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cat;
use Illuminate\Http\Request;

class CatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Cat::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name'          => 'required|string|max:100',
            'breed'         => 'required|string|max:100',
            'gender'        => 'required|in:Male,Female',
            'age'           => 'required|integer|min:0',
            'location'      => 'required|string|max:255',
            'is_available'  => 'required|boolean',
            'is_vaccinated' => 'required|boolean',
            'description'   => 'nullable|string',
            'image_url' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('cats', 'public');
            $validated['image_url'] = $path; // simpan nama file/ path ke DB
        }

        $cat = Cat::create($validated);



        return response()->json([
            'message' => 'Cat created successfully',
            'data' => $cat
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cat = Cat::find($id);

        if (!$cat) {
            return response()->json(['message' => 'cat not found'], 404);
        }
        return response()->json($cat);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cat = Cat::find($id);

        if (!$cat) {
            return response()->json(['message' => 'cat not found'], 404);
        }

        $validated = $request->validate([
            'name'          => 'sometimes|required|string|max:100',
            'breed'         => 'sometimes|required|string|max:100',
            'gender'        => 'sometimes|required|in:Male,Female',
            'age'           => 'sometimes|required|integer|min:0',
            'location'      => 'sometimes|required|string|max:255',
            'is_available'  => 'sometimes|boolean',
            'is_vaccinated' => 'sometimes|boolean',
            'description'   => 'nullable|string',
            'image_url'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $cat->update($validated);

        return response()->json([
            'message' => 'Cat updated successfully',
            'data'    => $cat
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cat = Cat::find($id);
        if (!$cat) {
            return response()->json(['message' => 'Cat not found'], 404);
        }
        $cat->delete();
        return response()->json(['message' => 'Cat deleted successfully'], 200);
    }
}
