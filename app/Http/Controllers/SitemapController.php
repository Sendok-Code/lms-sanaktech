<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Homepage
        $sitemap .= $this->addUrl(url('/'), now(), 'daily', '1.0');

        // Student dashboard
        $sitemap .= $this->addUrl(route('student.dashboard'), now(), 'daily', '0.9');

        // Courses listing
        $sitemap .= $this->addUrl(route('student.courses.index'), now(), 'daily', '0.9');

        // Categories
        $categories = Category::all();
        foreach ($categories as $category) {
            $sitemap .= $this->addUrl(
                route('student.courses.index', ['category' => $category->id]),
                $category->updated_at,
                'weekly',
                '0.8'
            );
        }

        // Published courses
        $courses = Course::where('published', true)
            ->with('instructor.user')
            ->get();

        foreach ($courses as $course) {
            $sitemap .= $this->addUrl(
                route('student.courses.show', $course),
                $course->updated_at,
                'weekly',
                '0.8'
            );
        }

        $sitemap .= '</urlset>';

        return response($sitemap, 200)
            ->header('Content-Type', 'application/xml');
    }

    private function addUrl($loc, $lastmod = null, $changefreq = 'weekly', $priority = '0.5')
    {
        $url = '<url>';
        $url .= '<loc>' . htmlspecialchars($loc) . '</loc>';

        if ($lastmod) {
            $url .= '<lastmod>' . $lastmod->toAtomString() . '</lastmod>';
        }

        $url .= '<changefreq>' . $changefreq . '</changefreq>';
        $url .= '<priority>' . $priority . '</priority>';
        $url .= '</url>';

        return $url;
    }
}
