<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->hasAnyRole(['admin', 'agent']);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'rent' => 'required|integer|min:0',
            'deposit' => 'required|integer|min:0',
            'property_type' => 'required|string|in:flat,pg,room,house,studio',
            'bhk' => 'required|integer|min:1|max:10',
            'area' => 'required|integer|min:0',
            'floor' => 'required|string|max:255',
            'furnishing' => 'required|string|in:furnished,semi-furnished,unfurnished',
            'availability' => 'required|string|in:immediate,specific_date',
            'approximate_location' => 'required|string|max:255',
            'nearest_metro' => 'nullable|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'exact_address' => 'required|string',
            'building_number' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'owner_contact' => 'required|string|max:255',
            'locality_id' => 'required|exists:localities,id',
            'assigned_agent_id' => 'nullable|exists:users,id',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',
        ];
    }
}
