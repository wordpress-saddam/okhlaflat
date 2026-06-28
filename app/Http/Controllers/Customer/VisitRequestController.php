<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\VisitRequest;
use App\Models\User;
use App\Notifications\VisitRequestSubmitted;
use App\Notifications\NewVisitRequestAdminAlert;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VisitRequestController extends Controller
{
    /**
     * Store a newly created visit request in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'property_id' => ['nullable', 'exists:properties,id'],
            'visit_date' => ['required_without:property_id', 'nullable', 'date', 'after_or_equal:today'],
            'visit_time' => ['required_without:property_id', 'nullable', 'string'],
            'customer_notes' => ['nullable', 'string', 'max:1000'],
            'notes' => ['nullable', 'string', 'max:1000'], // Fallback name from generic form
        ]);

        $propertyId = $request->property_id;
        $notes = $request->customer_notes ?? $request->notes;
        $scheduledAt = null;

        if ($request->filled('visit_date') && $request->filled('visit_time')) {
            $scheduledAt = \Carbon\Carbon::parse($request->visit_date . ' ' . $request->visit_time);
        }

        if ($propertyId) {
            $property = Property::findOrFail($propertyId);

            // Ensure the property is verified and published
            if ($property->verification_status !== 'verified' || $property->publication_status !== 'published') {
                return redirect()->back()->with('error', 'This property is not currently accepting visit bookings.');
            }

            // Prevent double booking for the same customer + property
            $existing = VisitRequest::where('property_id', $property->id)
                ->where('customer_id', auth()->id())
                ->first();

            if ($existing) {
                return redirect()->back()->with('error', 'You have already requested a visit for this property.');
            }
        }

        $visit = VisitRequest::create([
            'property_id' => $propertyId,
            'customer_id' => auth()->id(),
            'status' => 'pending',
            'scheduled_at' => $scheduledAt,
            'customer_notes' => $notes,
        ]);

        // Trigger notifications
        $customer = auth()->user();
        $customer->notify(new VisitRequestSubmitted($visit));

        $admins = User::role('admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewVisitRequestAdminAlert($visit));
        }

        return redirect()->back()->with('success', 'Your physical office visit has been requested. We will contact you shortly!');
    }
}
