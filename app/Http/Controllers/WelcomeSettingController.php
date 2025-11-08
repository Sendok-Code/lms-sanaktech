<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WelcomeSetting;

class WelcomeSettingController extends Controller
{
    /**
     * Display the welcome settings form
     */
    public function index()
    {
        $settings = WelcomeSetting::first();

        // If no settings exist, create default
        if (!$settings) {
            $settings = WelcomeSetting::create([
                'hero_title' => 'Belajar Tanpa Batas',
                'hero_subtitle' => 'Platform LMS Modern',
            ]);
        }

        return view('admin.welcome-settings.index', compact('settings'));
    }

    /**
     * Update the welcome settings
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'required|string|max:255',
            'hero_description' => 'nullable|string',
            'hero_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'search_title' => 'required|string|max:255',
            'search_placeholder' => 'required|string|max:255',

            'stats_students' => 'required|string|max:50',
            'stats_courses' => 'required|string|max:50',
            'stats_rating' => 'required|string|max:50',

            'feature_1_title' => 'required|string|max:255',
            'feature_1_description' => 'nullable|string',
            'feature_1_icon' => 'required|string|max:50',

            'feature_2_title' => 'required|string|max:255',
            'feature_2_description' => 'nullable|string',
            'feature_2_icon' => 'required|string|max:50',

            'feature_3_title' => 'required|string|max:255',
            'feature_3_description' => 'nullable|string',
            'feature_3_icon' => 'required|string|max:50',

            'cta_title' => 'required|string|max:255',
            'cta_description' => 'nullable|string',
            'cta_button_text' => 'required|string|max:100',

            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
        ]);

        $settings = WelcomeSetting::first();

        // Handle file upload
        if ($request->hasFile('hero_image')) {
            // Delete old image if exists
            if ($settings && $settings->hero_image && file_exists(public_path($settings->hero_image))) {
                unlink(public_path($settings->hero_image));
            }

            // Store new image
            $image = $request->file('hero_image');
            $imageName = 'hero-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/welcome'), $imageName);
            $validated['hero_image'] = 'images/welcome/' . $imageName;
        }

        if ($settings) {
            $settings->update($validated);
        } else {
            WelcomeSetting::create($validated);
        }

        return redirect()->route('admin.welcome-settings.index')
            ->with('success', 'Welcome page settings successfully updated!');
    }

    /**
     * Search courses
     */
    public function search(Request $request)
    {
        $query = $request->input('q');

        if (empty($query)) {
            return redirect('/');
        }

        $courses = \App\Models\Course::where('is_published', true)
            ->where(function($q) use ($query) {
                $q->where('title', 'like', '%' . $query . '%')
                  ->orWhere('description', 'like', '%' . $query . '%')
                  ->orWhereHas('category', function($q) use ($query) {
                      $q->where('name', 'like', '%' . $query . '%');
                  })
                  ->orWhereHas('instructor.user', function($q) use ($query) {
                      $q->where('name', 'like', '%' . $query . '%');
                  });
            })
            ->with(['category', 'instructor.user'])
            ->paginate(12);

        $settings = WelcomeSetting::first();

        return view('search', compact('courses', 'query', 'settings'));
    }
}
