<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::whereIn('key', ['ceo_name', 'platform_name', 'ceo_signature', 'tax_rate', 'tax_enabled'])
            ->get()
            ->keyBy('key');

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // TEMPORARY DEBUG - Remove after testing
        dd([
            'all_data' => $request->all(),
            'ceo_name' => $request->input('ceo_name'),
            'platform_name' => $request->input('platform_name'),
            'has_ceo_name' => $request->has('ceo_name'),
            'has_platform_name' => $request->has('platform_name'),
        ]);

        $request->validate([
            'ceo_name' => 'nullable|string|max:255',
            'platform_name' => 'nullable|string|max:255',
            'ceo_signature' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'tax_enabled' => 'nullable|in:true,false',
        ]);

        // Update CEO name if provided
        if ($request->has('ceo_name')) {
            Setting::updateOrCreate(
                ['key' => 'ceo_name'],
                ['value' => $request->ceo_name, 'type' => 'string']
            );
            \Log::info('CEO name updated', ['value' => $request->ceo_name]);
        }

        // Update platform name if provided
        if ($request->has('platform_name')) {
            Setting::updateOrCreate(
                ['key' => 'platform_name'],
                ['value' => $request->platform_name, 'type' => 'string']
            );
            \Log::info('Platform name updated', ['value' => $request->platform_name]);
        }

        // Handle CEO signature upload
        if ($request->hasFile('ceo_signature')) {
            // Delete old signature if exists
            $oldSignature = Setting::where('key', 'ceo_signature')->first();
            if ($oldSignature && $oldSignature->value && \Storage::disk('public')->exists($oldSignature->value)) {
                \Storage::disk('public')->delete($oldSignature->value);
            }

            // Store new signature
            $signaturePath = $request->file('ceo_signature')->store('signatures', 'public');

            Setting::updateOrCreate(
                ['key' => 'ceo_signature'],
                ['value' => $signaturePath, 'type' => 'string']
            );
        }

        // Update tax rate if provided
        if ($request->has('tax_rate')) {
            Setting::updateOrCreate(
                ['key' => 'tax_rate'],
                ['value' => $request->tax_rate, 'type' => 'number']
            );
        }

        // Update tax enabled if provided
        if ($request->has('tax_enabled')) {
            Setting::updateOrCreate(
                ['key' => 'tax_enabled'],
                ['value' => $request->tax_enabled, 'type' => 'boolean']
            );
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan berhasil diperbarui!');
    }
}
