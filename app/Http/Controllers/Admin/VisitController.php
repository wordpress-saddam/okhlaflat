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
    public function index(Request $request): View
    {
        $query = VisitRequest::with(['customer', 'property.locality', 'agent']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('customer', function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('mobile', 'like', "%{$search}%");
                })
                ->orWhereHas('property', function ($sub) use ($search) {
                    $sub->where('property_code', 'like', "%{$search}%")
                        ->orWhere('title', 'like', "%{$search}%");
                })
                ->orWhereHas('agent', function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%");
                });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('agent_id')) {
            $query->where('agent_id', $request->input('agent_id'));
        }

        $visits = $query->latest()->paginate(15)->withQueryString();
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
