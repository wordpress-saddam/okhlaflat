<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Locality;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Display a listing of verified & published properties with filters.
     */
    public function index(Request $request)
    {
        $query = Property::verified()->published()->with(['locality', 'images']);

        // Filters
        if ($request->filled('bhk')) {
            $query->where('bhk', $request->bhk);
        }

        if ($request->filled('locality_id')) {
            $query->where('locality_id', $request->locality_id);
        }

        if ($request->filled('max_rent')) {
            $query->where('rent', '<=', $request->max_rent);
        }

        if ($request->filled('furnishing')) {
            $query->where('furnishing', $request->furnishing);
        }

        $properties = $query->orderBy('id', 'desc')->paginate(9);
        $localities = Locality::where('is_active', true)->orderBy('name')->get();

        return view('properties.index', compact('properties', 'localities'));
    }

    /**
     * Display a public details view of the property.
     */
    public function show(Property $property)
    {
        if ($property->verification_status !== 'verified' || $property->publication_status !== 'published') {
            abort(404);
        }

        $property->load(['locality', 'amenities', 'images']);

        return view('properties.show', compact('property'));
    }
}
