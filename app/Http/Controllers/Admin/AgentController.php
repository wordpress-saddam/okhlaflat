<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class AgentController extends Controller
{
    /**
     * Display a listing of agents.
     */
    public function index(): View
    {
        $agents = User::role('agent')->orderBy('name')->get();
        return view('admin.agents.index', compact('agents'));
    }

    /**
     * Show the form for creating a new agent.
     */
    public function create(): View
    {
        return view('admin.agents.create');
    }

    /**
     * Store a newly created agent in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'mobile' => ['required', 'string', 'max:20', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $agent = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);

        $agent->assignRole(Role::findOrCreate('agent'));

        return redirect()->route('admin.agents.index')
            ->with('success', 'Agent registered successfully.');
    }

    /**
     * Show the form for editing the specified agent.
     */
    public function edit(User $agent): View
    {
        // Safety check to ensure we only edit actual agents
        if (!$agent->hasRole('agent')) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.agents.edit', compact('agent'));
    }

    /**
     * Update the specified agent in storage.
     */
    public function update(Request $request, User $agent): RedirectResponse
    {
        if (!$agent->hasRole('agent')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $agent->id],
            'mobile' => ['required', 'string', 'max:20', 'unique:users,mobile,' . $agent->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $agent->update($data);

        return redirect()->route('admin.agents.index')
            ->with('success', 'Agent details updated successfully.');
    }

    /**
     * Remove the specified agent from storage.
     */
    public function destroy(User $agent): RedirectResponse
    {
        if (!$agent->hasRole('agent')) {
            abort(403, 'Unauthorized action.');
        }

        $agent->delete();

        return redirect()->route('admin.agents.index')
            ->with('success', 'Agent deleted successfully.');
    }
}
