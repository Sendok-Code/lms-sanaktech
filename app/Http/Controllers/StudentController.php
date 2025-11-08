<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Progress;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * Student Dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Get student's enrollments with progress
        $enrollments = Enrollment::with(['course.instructor.user', 'course.modules.videos'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(4)
            ->get()
            ->map(function ($enrollment) {
                $totalVideos = $enrollment->course->modules->sum(function ($module) {
                    return $module->videos->count();
                });

                $completedVideos = Progress::where('enrollment_id', $enrollment->id)
                    ->where('completed', true)
                    ->count();

                $enrollment->progress_percentage = $totalVideos > 0
                    ? round(($completedVideos / $totalVideos) * 100)
                    : 0;

                return $enrollment;
            });

        // Statistics
        $stats = [
            'total_courses' => Enrollment::where('user_id', $user->id)->count(),
            'completed_courses' => $enrollments->where('progress_percentage', 100)->count(),
            'in_progress' => $enrollments->where('progress_percentage', '>', 0)->where('progress_percentage', '<', 100)->count(),
            'certificates' => 0, // Will be implemented later
        ];

        return view('student.dashboard', compact('enrollments', 'stats'));
    }

    /**
     * Browse all courses
     */
    public function courses(Request $request)
    {
        $query = Course::with(['instructor.user', 'category', 'modules'])
            ->where('published', true);

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Sort
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'popular':
                $query->withCount('enrollments')->orderBy('enrollments_count', 'desc');
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->latest();
        }

        $courses = $query->paginate(12);

        // Get categories for filter
        $categories = Category::withCount('courses')->get();

        // Check which courses user is enrolled in
        $enrolledCourseIds = Enrollment::where('user_id', Auth::id())
            ->pluck('course_id')
            ->toArray();

        return view('student.courses.index', compact('courses', 'categories', 'enrolledCourseIds'));
    }

    /**
     * Show course detail
     */
    public function showCourse(Course $course)
    {
        $course->load(['instructor.user', 'category', 'modules.videos', 'reviews.user']);

        // Check if user is enrolled
        $isEnrolled = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->exists();

        // Calculate course statistics
        $totalVideos = $course->modules->sum(function ($module) {
            return $module->videos->count();
        });

        $totalDuration = $course->modules->sum(function ($module) {
            return $module->videos->sum('duration_seconds');
        });

        $averageRating = $course->reviews->avg('rating') ?? 0;
        $totalReviews = $course->reviews->count();

        return view('student.courses.show', compact(
            'course',
            'isEnrolled',
            'totalVideos',
            'totalDuration',
            'averageRating',
            'totalReviews'
        ));
    }

    /**
     * Course learning interface
     */
    public function learnCourse(Course $course)
    {
        // Check if user is enrolled
        $enrollment = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->first();

        if (!$enrollment) {
            return redirect()->route('student.courses.show', $course)
                ->with('error', 'Anda harus mendaftar terlebih dahulu untuk mengakses kursus ini.');
        }

        $course->load(['modules.videos']);

        // Get first video or continue from last watched
        $currentVideo = Video::whereHas('module', function ($query) use ($course) {
            $query->where('course_id', $course->id);
        })
        ->whereHas('progress', function ($query) use ($enrollment) {
            $query->where('enrollment_id', $enrollment->id)
                  ->where('completed', false);
        })
        ->orderBy('sort_order')
        ->first();

        // If all videos completed, show first video
        if (!$currentVideo) {
            $currentVideo = $course->modules->first()?->videos->first();
        }

        // Get progress for all videos
        $progress = Progress::where('enrollment_id', $enrollment->id)->get()->keyBy('video_id');

        return view('student.courses.learn', compact('course', 'currentVideo', 'progress', 'enrollment'));
    }

    /**
     * Update video progress
     */
    public function updateProgress(Request $request, Video $video)
    {
        $enrollment = Enrollment::where('user_id', Auth::id())
            ->whereHas('course', function ($query) use ($video) {
                $query->where('id', $video->course_id);
            })
            ->first();

        if (!$enrollment) {
            return response()->json(['error' => 'Not enrolled'], 403);
        }

        $progress = Progress::where('enrollment_id', $enrollment->id)
            ->where('video_id', $video->id)
            ->first();

        if ($progress) {
            $progress->update([
                'watched_seconds' => $request->watched_seconds,
                'completed' => $request->completed ?? false,
                'watched_at' => now(),
            ]);
        }

        return response()->json(['success' => true]);
    }
}
