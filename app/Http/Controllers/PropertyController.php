<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Locality;
use App\Models\Amenity;
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

        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }

        if ($request->filled('min_rent')) {
            $query->where('rent', '>=', $request->min_rent);
        }

        if ($request->filled('max_rent')) {
            $query->where('rent', '<=', $request->max_rent);
        }

        if ($request->filled('furnishing')) {
            $query->where('furnishing', $request->furnishing);
        }

        if ($request->filled('nearest_metro')) {
            $query->where('nearest_metro', 'like', '%' . $request->nearest_metro . '%');
        }

        if ($request->filled('amenity_ids') && is_array($request->amenity_ids)) {
            foreach ($request->amenity_ids as $amenityId) {
                $query->whereHas('amenities', function ($q) use ($amenityId) {
                    $q->where('amenities.id', $amenityId);
                });
            }
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'newest');
        switch ($sortBy) {
            case 'rent_asc':
                $query->orderBy('rent', 'asc');
                break;
            case 'rent_desc':
                $query->orderBy('rent', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        $properties = $query->paginate(9);
        $localities = Locality::where('is_active', true)->orderBy('name')->get();
        $amenities = Amenity::orderBy('name')->get();

        return view('properties.index', compact('properties', 'localities', 'amenities'));
    }

    /**
     * Display a public details view of the property.
     */
    public function show(Property $property)
    {
        if ($property->verification_status !== 'verified' || $property->publication_status !== 'published') {
            abort(404);
        }

        $property->load(['locality', 'amenities', 'images', 'reviews.customer']);

        return view('properties.show', compact('property'));
    }
}
