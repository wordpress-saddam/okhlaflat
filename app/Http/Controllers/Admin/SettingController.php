<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SettingController extends Controller
{
    /**
     * Display the settings configuration page.
     */
    public function index(): View
    {
        // For now, we specifically manage brokerage_fee_percentage
        $brokerageFee = Setting::getValue('brokerage_fee_percentage', 25);
        
        return view('admin.settings.index', compact('brokerageFee'));
    }

    /**
     * Store/update the platform settings.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'brokerage_fee_percentage' => 'required|numeric|min:0|max:100',
        ]);

        Setting::setValue('brokerage_fee_percentage', $request->brokerage_fee_percentage);

        return redirect()->back()->with('success', 'Platform settings updated successfully.');
    }
}
