<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use App\Models\Property;
use App\Models\VisitRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DealController extends Controller
{
    /**
     * Show the form to close a deal.
     */
    public function create(VisitRequest $visit): View
    {
        // Enforce authorization: Admin or assigned Agent can close the deal
        if (!auth()->user()->hasRole('admin') && $visit->agent_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Fetch properties for selection if visit request property is null (general consultation)
        $properties = collect();
        if (!$visit->property_id) {
            $properties = Property::verified()->published()->orderBy('title')->get();
        }

        return view('agent.deals.close', compact('visit', 'properties'));
    }

    /**
     * Store a newly created deal in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $visit = VisitRequest::findOrFail($request->visit_request_id);

        // Enforce authorization
        if (!auth()->user()->hasRole('admin') && $visit->agent_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'visit_request_id' => ['required', 'exists:visit_requests,id'],
            'property_id' => ['required', 'exists:properties,id'],
            'rent_amount' => ['required', 'integer', 'min:1'],
            'agreement_doc' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
            'id_proof' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
        ]);

        $property = Property::findOrFail($request->property_id);

        // Upload documents
        $agreementPath = $request->file('agreement_doc')->store('deals/agreements', 'public');
        $idProofPath = $request->file('id_proof')->store('deals/id_proofs', 'public');

        // Calculate service fee dynamically based on configured platform setting
        $feePercentage = \App\Models\Setting::getValue('brokerage_fee_percentage', 25);
        $serviceFee = (int) round($request->rent_amount * ($feePercentage / 100));

        // Create deal
        $deal = Deal::create([
            'visit_request_id' => $visit->id,
            'property_id' => $property->id,
            'customer_id' => $visit->customer_id,
            'agent_id' => $visit->agent_id ?? auth()->id(), // Use current admin/agent if none assigned
            'rent_amount' => $request->rent_amount,
            'service_fee' => $serviceFee,
            'payment_status' => 'pending_payment',
            'agreement_doc_path' => $agreementPath,
            'id_proof_path' => $idProofPath,
            'closed_at' => now(),
        ]);

        // Complete the visit request
        $visit->update([
            'property_id' => $property->id, // Set property in case it was a general consultation
            'status' => 'completed',
        ]);

        // Archive the property listing so it's no longer live
        $property->update([
            'publication_status' => 'archived',
        ]);

        return redirect()->route('agent.visits.index')
            ->with('success', "Deal closed successfully! Invoice generated for ₹" . number_format($serviceFee));
    }

    /**
     * Display the printable invoice.
     */
    public function invoice(Deal $deal): View
    {
        // Admins can see any invoice. Agents can see invoices they closed. Customers can see their own invoices.
        $user = auth()->user();
        if (!$user->hasRole('admin') && $deal->agent_id !== $user->id && $deal->customer_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('agent.deals.invoice', compact('deal'));
    }

    /**
     * Update the payment status of a deal.
     */
    public function updatePaymentStatus(Request $request, Deal $deal): RedirectResponse
    {
        // Only admins can update the payment status of a deal
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'payment_status' => ['required', 'in:pending_payment,paid,written_off'],
        ]);

        $deal->update([
            'payment_status' => $request->payment_status,
        ]);

        return redirect()->back()
            ->with('success', 'Deal payment status updated successfully.');
    }
}
