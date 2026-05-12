<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'site_name' => config('app.name', 'E-Commerce AI'),
            'site_description' => Cache::get('site_description', 'Modern E-Commerce Platform'),
            'contact_email' => Cache::get('contact_email', 'admin@example.com'),
            'contact_phone' => Cache::get('contact_phone', ''),
            'currency' => Cache::get('currency', 'IDR'),
            'tax_rate' => Cache::get('tax_rate', 11.0),
            'shipping_fee' => Cache::get('shipping_fee', 0),
            'maintenance_mode' => Cache::get('maintenance_mode', false),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'required|string|max:500',
            'contact_email' => 'required|email',
            'contact_phone' => 'nullable|string|max:20',
            'currency' => 'required|string|max:3',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'shipping_fee' => 'required|numeric|min:0',
            'maintenance_mode' => 'boolean',
        ]);

        // Store settings in cache (you might want to create a settings table for persistence)
        foreach ($validated as $key => $value) {
            Cache::forever($key, $value);
        }

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully');
    }
}
