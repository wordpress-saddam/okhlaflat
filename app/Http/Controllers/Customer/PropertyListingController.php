<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Locality;
use App\Models\Amenity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PropertyListingController extends Controller
{
    /**
     * Display the multi-step form for property creation.
     */
    public function create()
    {
        $localities = Locality::where('is_active', true)->get();
        $amenities = Amenity::where('is_active', true)->get();

        return view('customer.properties.create', compact('localities', 'amenities'));
    }

    /**
     * Store or update a draft property step by step via AJAX.
     */
    public function storeStep(Request $request)
    {
        $propertyId = $request->input('property_id');
        $step = $request->input('step');

        if ($propertyId) {
            $property = Property::where('id', $propertyId)
                ->where('created_by', auth()->id())
                ->firstOrFail();
        } else {
            // Step 1: Create a new draft
            $latest = Property::withTrashed()->orderBy('id', 'desc')->first();
            $nextId = $latest ? ($latest->id + 1) : 1;
            
            $property = new Property();
            $property->property_code = 'OF-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
            $property->created_by = auth()->id();
            $property->publication_status = 'draft';
            $property->verification_status = 'pending';
        }

        switch ($step) {
            case 1:
                $request->validate([
                    'title' => 'required|string|max:255',
                    'locality_id' => 'required|exists:localities,id',
                    'property_type' => 'required|string',
                    'bhk' => 'required|integer',
                ]);
                $property->title = $request->title;
                $property->locality_id = $request->locality_id;
                $property->property_type = $request->property_type;
                $property->bhk = $request->bhk;
                break;
                
            case 2:
                $request->validate([
                    'rent' => 'required|numeric|min:0',
                    'deposit' => 'required|numeric|min:0',
                    'area' => 'required|numeric|min:1',
                    'floor' => 'required|string',
                    'furnishing' => 'required|string',
                    'availability' => 'required|string',
                ]);
                $property->rent = $request->rent;
                $property->deposit = $request->deposit;
                $property->area = $request->area;
                $property->floor = $request->floor;
                $property->furnishing = $request->furnishing;
                $property->availability = $request->availability;
                break;

            case 3:
                $request->validate([
                    'approximate_location' => 'required|string|max:255',
                    'exact_address' => 'required|string',
                    'building_number' => 'required|string',
                    'owner_name' => 'required|string|max:255',
                    'owner_contact' => 'required|string|max:20',
                ]);
                $property->approximate_location = $request->approximate_location;
                $property->exact_address = $request->exact_address;
                $property->building_number = $request->building_number;
                $property->owner_name = $request->owner_name;
                $property->owner_contact = $request->owner_contact;
                $property->description = $request->description;
                break;

            case 4:
                // Final submission
                if ($request->has('amenities')) {
                    $property->amenities()->sync($request->input('amenities'));
                }
                
                // Final check to ensure all required fields are present
                $property->publication_status = 'pending'; // Change status to pending review
                break;
        }

        $property->save();

        return response()->json([
            'success' => true,
            'property_id' => $property->id,
            'message' => 'Step saved successfully.'
        ]);
    }

    /**
     * Handle AJAX image upload for the property.
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'image' => 'required|image|max:5120', // Max 5MB
        ]);

        $property = Property::where('id', $request->property_id)
            ->where('created_by', auth()->id())
            ->firstOrFail();

        $path = $request->file('image')->store('properties', 'public');
        
        $isFeatured = $property->images()->count() === 0;

        $image = $property->images()->create([
            'file_path' => $path,
            'is_featured' => $isFeatured,
            'order' => $property->images()->count(),
        ]);

        return response()->json([
            'success' => true,
            'image' => [
                'id' => $image->id,
                'url' => asset('storage/' . $path)
            ]
        ]);
    }
}
