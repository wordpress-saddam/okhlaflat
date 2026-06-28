<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\VisitRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    /**
     * Show the form for creating a new review.
     */
    public function create(VisitRequest $visit): View|\Illuminate\Http\RedirectResponse
    {
        // Guard access
        if ($visit->customer_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($visit->status !== 'completed') {
            abort(403, 'Reviews can only be submitted for completed visit requests.');
        }

        if ($visit->review()->exists()) {
            return redirect()->route('customer.dashboard')
                ->with('error', 'You have already submitted a review for this visit request.');
        }

        $visit->load(['property.locality', 'agent']);

        return view('customer.reviews.create', compact('visit'));
    }

    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request, VisitRequest $visit): RedirectResponse
    {
        // Guard access
        if ($visit->customer_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($visit->status !== 'completed') {
            abort(403, 'Reviews can only be submitted for completed visit requests.');
        }

        if ($visit->review()->exists()) {
            return redirect()->route('customer.dashboard')
                ->with('error', 'You have already submitted a review for this visit request.');
        }

        $request->validate([
            'property_rating' => 'required|integer|min:1|max:5',
            'agent_rating' => 'nullable|required_with:agent_id|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'visit_request_id' => $visit->id,
            'property_id' => $visit->property_id,
            'customer_id' => $visit->customer_id,
            'agent_id' => $visit->agent_id,
            'property_rating' => $request->property_rating,
            'agent_rating' => $visit->agent_id ? $request->agent_rating : null,
            'comment' => $request->comment,
        ]);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Thank you for your feedback! Your review has been saved.');
    }
}
