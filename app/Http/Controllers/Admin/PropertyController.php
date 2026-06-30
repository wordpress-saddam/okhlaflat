<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Locality;
use App\Models\Amenity;
use App\Models\User;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Property::with(['locality', 'agent']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('property_code', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('building_number', 'like', "%{$search}%")
                  ->orWhereHas('locality', function ($sub) use ($search) {
                      $sub->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('verification_status')) {
            $query->where('verification_status', $request->input('verification_status'));
        }

        if ($request->filled('publication_status')) {
            $query->where('publication_status', $request->input('publication_status'));
        }

        if ($request->filled('locality_id')) {
            $query->where('locality_id', $request->input('locality_id'));
        }

        $properties = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();
        $localities = Locality::where('is_active', true)->orderBy('name')->get();

        return view('admin.properties.index', compact('properties', 'localities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $localities = Locality::where('is_active', true)->get();
        $amenities = Amenity::where('is_active', true)->get();
        $agents = User::role('agent')->get();

        return view('admin.properties.create', compact('localities', 'amenities', 'agents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePropertyRequest $request)
    {
        $data = $request->validated();
        
        // Generate unique Property Code
        $latest = Property::withTrashed()->orderBy('id', 'desc')->first();
        $nextId = $latest ? ($latest->id + 1) : 1;
        $data['property_code'] = 'OF-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
        
        // Assign creator
        $data['created_by'] = auth()->id();
        
        // Default verification & publication status for agents is pending/draft
        if (!auth()->user()->hasRole('admin')) {
            $data['verification_status'] = 'pending';
            $data['publication_status'] = 'draft';
        } else {
            $data['verification_status'] = $request->input('verification_status', 'pending');
            $data['publication_status'] = $request->input('publication_status', 'draft');
        }

        // Create property
        $property = Property::create($data);

        // Sync amenities
        if ($request->has('amenities')) {
            $property->amenities()->sync($request->input('amenities'));
        }

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $path = $file->store('properties', 'public');
                $property->images()->create([
                    'file_path' => $path,
                    'is_featured' => $index === 0,
                    'order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.properties.index')
            ->with('success', "Property {$property->property_code} created successfully.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        $property->load(['locality', 'amenities', 'images', 'agent']);
        return view('admin.properties.show', compact('property'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        $localities = Locality::where('is_active', true)->get();
        $amenities = Amenity::where('is_active', true)->get();
        $agents = User::role('agent')->get();

        return view('admin.properties.edit', compact('property', 'localities', 'amenities', 'agents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePropertyRequest $request, Property $property)
    {
        $data = $request->validated();

        // Admin can edit statuses, agents default to current or draft on edits
        if (!auth()->user()->hasRole('admin')) {
            // Keep current status, or force pending if critical details change
            $data['verification_status'] = $property->verification_status;
        } else {
            $data['verification_status'] = $request->input('verification_status', $property->verification_status);
            $data['publication_status'] = $request->input('publication_status', $property->publication_status);
        }

        $property->update($data);

        // Sync amenities
        if ($request->has('amenities')) {
            $property->amenities()->sync($request->input('amenities'));
        } else {
            $property->amenities()->detach();
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            $currentCount = $property->images()->count();
            foreach ($request->file('images') as $index => $file) {
                $path = $file->store('properties', 'public');
                $property->images()->create([
                    'file_path' => $path,
                    'is_featured' => ($currentCount === 0 && $index === 0),
                    'order' => $currentCount + $index,
                ]);
            }
        }

        return redirect()->route('admin.properties.index')
            ->with('success', "Property {$property->property_code} updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        $property->delete();
        return redirect()->route('admin.properties.index')
            ->with('success', "Property {$property->property_code} deleted successfully.");
    }

    /**
     * Toggle property verification.
     */
    public function verify(Request $request, Property $property)
    {
        $request->validate([
            'status' => 'required|in:pending,verified,rejected',
        ]);

        $property->update([
            'verification_status' => $request->input('status')
        ]);

        return redirect()->back()->with('success', "Property {$property->property_code} verification status set to {$request->input('status')}.");
    }
}
