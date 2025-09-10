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
        return response()->json(Cat::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cat = Cat::create($request->all());
        return response()->json($cat, 201);
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
        if ($cat) {
            return response()->json(['message' => 'cat not found'], 404);
        }
        $cat->update($request->all());
        return response()->json($cat);
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
        return response()->json(['message' => 'Cat deleted successfully']);
    }
}
