<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\VisitRequest;
use App\Notifications\VisitRequestScheduled;
use App\Notifications\VisitRequestStatusUpdated;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VisitAssignmentController extends Controller
{
    /**
     * Display a listing of assigned visit requests.
     */
    public function index(): View
    {
        $visits = auth()->user()->assignedVisits()
            ->with(['customer', 'property.locality', 'deal'])
            ->latest()
            ->paginate(15);

        return view('agent.visits.index', compact('visits'));
    }

    /**
     * Update the status and scheduled time of an assigned visit request.
     */
    public function updateStatus(Request $request, VisitRequest $visit): RedirectResponse
    {
        // Enforce ownership check
        if ($visit->agent_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => ['required', 'in:assigned,scheduled,completed,cancelled'],
            'scheduled_date' => ['required_if:status,scheduled', 'nullable', 'date'],
            'scheduled_time' => ['required_if:status,scheduled', 'nullable', 'string'],
        ]);

        $data = [
            'status' => $request->status,
        ];

        if ($request->status === 'scheduled' && $request->filled('scheduled_date') && $request->filled('scheduled_time')) {
            $data['scheduled_at'] = \Carbon\Carbon::parse($request->scheduled_date . ' ' . $request->scheduled_time);
        }

        $oldStatus = $visit->status;
        $visit->update($data);

        // Send notifications if status changed
        if ($oldStatus !== $visit->status && $visit->customer) {
            if ($visit->status === 'scheduled') {
                $visit->customer->notify(new VisitRequestScheduled($visit));
            } elseif ($visit->status === 'completed' || $visit->status === 'cancelled') {
                $visit->customer->notify(new VisitRequestStatusUpdated($visit));
            }
        }

        return redirect()->route('agent.visits.index')
            ->with('success', 'Visit status updated successfully.');
    }
}
