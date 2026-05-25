<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    protected array $settingKeys = [
        'site_name',
        'site_description',
        'site_keywords',
        'site_phone',
        'site_email',
        'site_address',
        'social_instagram',
        'social_facebook',
        'social_youtube',
        'razorpay_key_id',
        'razorpay_key_secret',
    ];

    public function index()
    {
        $settings = SiteSetting::getAll();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'nullable|string|max:255',
            'site_description' => 'nullable|string|max:500',
            'site_keywords' => 'nullable|string|max:500',
            'site_phone' => 'nullable|string|max:50',
            'site_email' => 'nullable|email|max:255',
            'site_address' => 'nullable|string|max:500',
            'social_instagram' => 'nullable|url|max:255',
            'social_facebook' => 'nullable|url|max:255',
            'social_youtube' => 'nullable|url|max:255',
            'razorpay_key_id' => 'nullable|string|max:255',
            'razorpay_key_secret' => 'nullable|string|max:255',
        ]);

        foreach ($this->settingKeys as $key) {
            SiteSetting::set($key, $request->input($key));
        }

        return redirect()->route('admin.settings.index')->with('success', 'Site settings updated successfully.');
    }
}
