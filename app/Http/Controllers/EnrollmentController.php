<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Progress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EnrollmentController extends Controller
{
    /**
     * Display student's enrollments
     */
    public function index()
    {
        $enrollments = Enrollment::with(['course.instructor.user', 'course.modules'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get()
            ->map(function ($enrollment) {
                $totalVideos = $enrollment->course->modules->sum(function ($module) {
                    return $module->videos->count();
                });

                $completedVideos = Progress::whereHas('video', function ($query) use ($enrollment) {
                    $query->whereHas('module', function ($q) use ($enrollment) {
                        $q->where('course_id', $enrollment->course_id);
                    });
                })
                ->where('enrollment_id', $enrollment->id)
                ->where('completed', true)
                ->count();

                $enrollment->progress_percentage = $totalVideos > 0
                    ? round(($completedVideos / $totalVideos) * 100)
                    : 0;

                return $enrollment;
            });

        return view('student.enrollments.index', compact('enrollments'));
    }

    /**
     * Admin view of all enrollments
     */
    public function adminIndex()
    {
        $enrollments = Enrollment::with(['user', 'course.modules.videos'])
            ->latest()
            ->paginate(20);

        $enrollments->getCollection()->transform(function ($enrollment) {
            $totalVideos = $enrollment->course->modules->sum(function ($module) {
                return $module->videos->count();
            });

            $completedVideos = Progress::whereHas('video', function ($query) use ($enrollment) {
                $query->whereHas('module', function ($q) use ($enrollment) {
                    $q->where('course_id', $enrollment->course_id);
                });
            })
            ->where('enrollment_id', $enrollment->id)
            ->where('completed', true)
            ->count();

            $enrollment->progress_percentage = $totalVideos > 0
                ? round(($completedVideos / $totalVideos) * 100)
                : 0;

            return $enrollment;
        });

        return view('admin.enrollments.index', compact('enrollments'));
    }

    /**
     * Enroll in a course
     */
    public function store(Request $request, Course $course)
    {
        $user = Auth::user();

        // Check if already enrolled
        $existingEnrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existingEnrollment) {
            return redirect()->route('student.courses.show', $course)
                ->with('info', 'Anda sudah terdaftar di kursus ini.');
        }

        // Create enrollment
        DB::beginTransaction();
        try {
            $enrollment = Enrollment::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'price_paid' => $course->price,
                'enrolled_at' => now(),
            ]);

            // Initialize progress for all videos in the course
            $videos = $course->modules->flatMap->videos;
            foreach ($videos as $video) {
                Progress::create([
                    'enrollment_id' => $enrollment->id,
                    'video_id' => $video->id,
                    'completed' => false,
                ]);
            }

            DB::commit();

            return redirect()->route('student.courses.learn', $course)
                ->with('success', 'Selamat! Anda berhasil terdaftar di kursus ini.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mendaftar kursus.');
        }
    }

    /**
     * Check enrollment status
     */
    public function checkEnrollment(Course $course)
    {
        $isEnrolled = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->exists();

        return response()->json(['enrolled' => $isEnrolled]);
    }
}
