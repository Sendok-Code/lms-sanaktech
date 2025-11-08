<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'site_name' => Setting::get('site_name', 'MyLMS'),
            'site_name_subtitle' => Setting::get('site_name_subtitle', 'Learning Management System'),
            'site_name_color' => Setting::get('site_name_color', '#f1f5f9'),
            'site_subtitle_color' => Setting::get('site_subtitle_color', '#94a3b8'),
            'site_name_font_size' => Setting::get('site_name_font_size', '18'),
            'site_subtitle_font_size' => Setting::get('site_subtitle_font_size', '11'),
            'site_logo' => Setting::get('site_logo'),
            'site_description' => Setting::get('site_description', 'Platform Pembelajaran Online Terbaik'),
            'logo_height' => Setting::get('logo_height', '40'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function testSimple()
    {
        return view('admin.settings.test-simple');
    }

    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'site_name' => 'required|string|max:255',
                'site_name_subtitle' => 'nullable|string|max:255',
                'site_name_color' => 'nullable|string|max:7',
                'site_subtitle_color' => 'nullable|string|max:7',
                'site_name_font_size' => 'nullable|integer|min:10|max:32',
                'site_subtitle_font_size' => 'nullable|integer|min:8|max:24',
                'site_description' => 'nullable|string|max:500',
                'site_logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
                'logo_height' => 'nullable|integer|min:20|max:100',
            ]);

            // Update site name
            Setting::set('site_name', $validated['site_name'], 'string', 'general');

            // Update site name subtitle
            if (isset($validated['site_name_subtitle'])) {
                Setting::set('site_name_subtitle', $validated['site_name_subtitle'], 'string', 'general');
            }

            // Update site name color
            if (isset($validated['site_name_color'])) {
                Setting::set('site_name_color', $validated['site_name_color'], 'string', 'general');
            }

            // Update site subtitle color
            if (isset($validated['site_subtitle_color'])) {
                Setting::set('site_subtitle_color', $validated['site_subtitle_color'], 'string', 'general');
            }

            // Update site description
            if (isset($validated['site_description'])) {
                Setting::set('site_description', $validated['site_description'], 'string', 'general');
            }

            // Update logo height
            if (isset($validated['logo_height'])) {
                Setting::set('logo_height', $validated['logo_height'], 'number', 'general');
            } else {
                // Set default if not provided
                Setting::set('logo_height', '40', 'number', 'general');
            }

            // Handle logo upload
            if ($request->hasFile('site_logo')) {
                // Verify upload is valid
                if ($request->file('site_logo')->isValid()) {
                    // Delete old logo if exists
                    $oldLogo = Setting::get('site_logo');
                    if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                        Storage::disk('public')->delete($oldLogo);
                    }

                    // Store new logo
                    $logoPath = $request->file('site_logo')->store('logos', 'public');

                    if ($logoPath) {
                        Setting::set('site_logo', $logoPath, 'string', 'general');
                    } else {
                        return back()->with('error', 'Gagal menyimpan logo. Silakan coba lagi.');
                    }
                } else {
                    return back()->with('error', 'File logo tidak valid.');
                }
            }

            // Clear all setting cache to ensure fresh data
            \Illuminate\Support\Facades\Cache::flush();

            return back()->with('success', 'Pengaturan berhasil diperbarui!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Settings update error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function deleteLogo()
    {
        $logo = Setting::get('site_logo');

        if ($logo && Storage::disk('public')->exists($logo)) {
            Storage::disk('public')->delete($logo);
            Setting::set('site_logo', null, 'string', 'general');

            return back()->with('success', 'Logo berhasil dihapus!');
        }

        return back()->with('error', 'Logo tidak ditemukan!');
    }
}
