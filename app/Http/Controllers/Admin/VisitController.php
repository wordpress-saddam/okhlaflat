<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VisitRequest;
use App\Notifications\VisitRequestAssigned;
use App\Notifications\VisitAssignedAgentAlert;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VisitController extends Controller
{
    /**
     * Display a listing of all visit requests.
     */
    public function index(): View
    {
        $visits = VisitRequest::with(['customer', 'property.locality', 'agent'])
            ->latest()
            ->paginate(15);

        $agents = User::role('agent')->orderBy('name')->get();

        return view('admin.visits.index', compact('visits', 'agents'));
    }

    /**
     * Assign an agent to a specific visit request.
     */
    public function assign(Request $request, VisitRequest $visit): RedirectResponse
    {
        $request->validate([
            'agent_id' => ['required', 'exists:users,id'],
        ]);

        $agent = User::findOrFail($request->agent_id);

        if (!$agent->hasRole('agent')) {
            return redirect()->back()->with('error', 'Selected user is not an office agent.');
        }

        $visit->update([
            'agent_id' => $agent->id,
            'status' => $visit->status === 'pending' ? 'assigned' : $visit->status,
        ]);

        // Send notifications
        if ($visit->customer) {
            $visit->customer->notify(new VisitRequestAssigned($visit));
        }
        $agent->notify(new VisitAssignedAgentAlert($visit));

        return redirect()->route('admin.visits.index')
            ->with('success', 'Agent assigned to visit request successfully.');
    }
}
