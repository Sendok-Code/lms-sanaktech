<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Course;
use App\Models\Module;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    /**
     * Tampilkan daftar video berdasarkan module.
     */
    public function index()
    {
        // Jika instructor, hanya tampilkan courses, modules, dan videos miliknya
        if (Auth::user()->role === 'instructor') {
            $instructor = Instructor::where('user_id', Auth::id())->first();

            if (!$instructor) {
                return redirect()->back()->with('error', 'Akses ditolak! Anda bukan instructor.');
            }

            $videos = Video::with(['course', 'module'])
                ->whereHas('course', function($query) use ($instructor) {
                    $query->where('instructor_id', $instructor->id);
                })
                ->orderBy('id', 'desc')
                ->get();

            $courses = Course::with('modules')
                ->where('instructor_id', $instructor->id)
                ->get();
        } else {
            // Admin bisa lihat semua
            $videos = Video::with(['course', 'module'])->orderBy('id', 'desc')->get();
            $courses = Course::with('modules')->get();
        }

        return view('admin.videos.index', compact('videos', 'courses'));
    }

    /**
     * Simpan video baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'module_id' => 'required|exists:modules,id',
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'video_url' => 'required|url',
            'duration_seconds' => 'nullable|integer|min:0',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Jika instructor, pastikan course dan module miliknya
        if (Auth::user()->role === 'instructor') {
            $instructor = Instructor::where('user_id', Auth::id())->first();
            $course = Course::find($validated['course_id']);

            if (!$course || $course->instructor_id !== $instructor->id) {
                return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menambah video ke course ini.');
            }
        }

        Video::create($validated);

        return back()->with('success', 'Video berhasil ditambahkan!');
    }

    /**
     * Perbarui video.
     */
    public function update(Request $request, Video $video)
    {
        // Jika instructor, pastikan video dari course miliknya
        if (Auth::user()->role === 'instructor') {
            $instructor = Instructor::where('user_id', Auth::id())->first();

            if (!$video->course || $video->course->instructor_id !== $instructor->id) {
                return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengedit video ini.');
            }
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'video_url' => 'required|url',
            'duration_seconds' => 'nullable|integer|min:0',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $video->update($validated);

        return back()->with('success', 'Video berhasil diperbarui!');
    }

    /**
     * Hapus video.
     */
    public function destroy(Video $video)
    {
        // Jika instructor, pastikan video dari course miliknya
        if (Auth::user()->role === 'instructor') {
            $instructor = Instructor::where('user_id', Auth::id())->first();

            if (!$video->course || $video->course->instructor_id !== $instructor->id) {
                return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus video ini.');
            }
        }

        $video->delete();
        return back()->with('success', 'Video berhasil dihapus!');
    }
}
