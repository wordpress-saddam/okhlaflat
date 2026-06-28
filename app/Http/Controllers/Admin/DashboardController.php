<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use App\Models\Locality;
use App\Models\Property;
use App\Models\User;
use App\Models\VisitRequest;
use App\Models\Review;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the dynamic dashboard statistics and analytics.
     */
    public function index(): View
    {
        // Core metrics
        $totalFlats = Property::count();
        $verifiedFlats = Property::verified()->published()->count();
        $activeLeads = VisitRequest::whereIn('status', ['pending', 'assigned', 'scheduled'])->count();
        $scheduledVisits = VisitRequest::where('status', 'scheduled')->count();

        // Business metrics
        $totalRevenue = Deal::where('payment_status', 'paid')->sum('service_fee');
        $pendingRevenue = Deal::where('payment_status', 'pending_payment')->sum('service_fee');
        
        $totalVisitsCount = VisitRequest::count();
        $completedVisitsCount = VisitRequest::where('status', 'completed')->count();
        $conversionRate = $totalVisitsCount > 0 
            ? round(($completedVisitsCount / $totalVisitsCount) * 100, 1) 
            : 0;

        // Platform rating
        $averagePlatformRating = round(Review::avg('property_rating') ?? 0.0, 1);

        // Recent Activity
        $recentListings = Property::with(['locality', 'creator'])->latest()->take(5)->get();
        $recentVisits = VisitRequest::with(['customer', 'property.locality', 'agent'])->latest()->take(5)->get();

        // Agent Performance calculations
        $agents = User::role('agent')
            ->withCount([
                'assignedVisits as total_leads',
                'assignedVisits as scheduled_visits' => function ($query) {
                    $query->where('status', 'scheduled');
                },
                'dealsAsAgent as closed_deals'
            ])
            ->get()
            ->map(function ($agent) {
                // Calculate revenue, conversion rate, and average rating
                $agent->revenue_generated = Deal::where('agent_id', $agent->id)->where('payment_status', 'paid')->sum('service_fee');
                $agent->conversion_rate = $agent->total_leads > 0 
                    ? round(($agent->closed_deals / $agent->total_leads) * 100, 1) 
                    : 0;
                $agent->average_rating = round($agent->reviewsAsAgent()->avg('agent_rating') ?? 0.0, 1);
                return $agent;
            })
            ->sortByDesc('revenue_generated');

        // Locality performance breakdown
        $localities = Locality::withCount([
            'properties',
            'properties as deals_count' => function ($query) {
                $query->whereHas('deals');
            }
        ])
        ->orderByDesc('properties_count')
        ->take(8)
        ->get();

        return view('admin.dashboard', compact(
            'totalFlats',
            'verifiedFlats',
            'activeLeads',
            'scheduledVisits',
            'totalRevenue',
            'pendingRevenue',
            'conversionRate',
            'averagePlatformRating',
            'recentListings',
            'recentVisits',
            'agents',
            'localities'
        ));
    }
}
