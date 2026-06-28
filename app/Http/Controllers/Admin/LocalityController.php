<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Locality;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LocalityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $localities = Locality::orderBy('name')->get();
        return view('admin.localities.index', compact('localities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:localities,name',
            'description' => 'nullable|string',
        ]);

        Locality::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.localities.index')
            ->with('success', 'Locality created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Locality $locality)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:localities,name,' . $locality->id,
            'description' => 'nullable|string',
        ]);

        $locality->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.localities.index')
            ->with('success', 'Locality updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Locality $locality)
    {
        $locality->delete();
        return redirect()->route('admin.localities.index')
            ->with('success', 'Locality deleted successfully.');
    }
}
