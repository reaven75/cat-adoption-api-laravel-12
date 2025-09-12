<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Cat::all(), 201);
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

        // upload image kalau ada
        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('cats', 'public');
            $validated['image_url'] = $path; // simpan nama file/ path ke DB
        }

        // simpan data ke db
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
        // Debug dengan format yang benar
        Log::info('Raw request input:', ['data' => $request->all()]);
        Log::info('Request method:', ['method' => $request->method()]);
        Log::info('Content type:', ['content_type' => $request->header('Content-Type')]);
        Log::info('Has name:', ['has_name' => $request->has('name')]);

        $cat = Cat::find($id);

        if (!$cat) {
            return response()->json(['message' => 'Cat not found'], 404);
        }

        // Validasi data
        // SOLUSI - hapus 'required' untuk field yang optional dalam update
        $validated = $request->validate([
            'name'          => 'sometimes|string|max:100',
            'breed'         => 'sometimes|string|max:100',
            'gender'        => 'sometimes|in:Male,Female',
            'age'           => 'sometimes|integer|min:0',
            'location'      => 'sometimes|string|max:255',
            'is_available'  => 'sometimes|boolean',
            'is_vaccinated' => 'sometimes|boolean',
            'description'   => 'sometimes|nullable|string',
            'image_url'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        Log::info('Validated data:', ['data' => $validated]);

        // Jika ada file baru diupload
        if ($request->hasFile('image_url')) {
            // Hapus file lama kalau ada
            if ($cat->image_url && Storage::disk('public')->exists($cat->image_url)) {
                Storage::disk('public')->delete($cat->image_url);
            }

            // Simpan file baru
            $path = $request->file('image_url')->store('cats', 'public');
            $validated['image_url'] = $path;
        }

        // Update data
        $cat->update($validated);
        $cat->refresh();

        Log::info('Data after update:', ['data' => $cat->toArray()]);

        return response()->json([
            'message' => 'Cat updated successfully',
            'data' => $cat
        ], 200);
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

        // Hapus file image kalau ada
        if ($cat->image_url && Storage::disk('public')->exists($cat->image_url)) {
            Storage::disk('public')->delete($cat->image_url);
        }

        // Hapus data di database
        $cat->delete();

        return response()->json(['message' => 'Cat deleted successfully'], 200);
    }
}
