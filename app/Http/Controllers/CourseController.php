<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use App\Models\Instructor;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        // Jika admin, tampilkan semua courses
        if (Auth::user()->role === 'admin') {
            $courses = Course::with(['category', 'instructor.user'])
                ->withCount('enrollments')
                ->paginate(10);
            $instructors = Instructor::with('user')->get();

            return view('admin.courses.index', compact('courses', 'categories', 'instructors'));
        }

        // Jika instructor, tampilkan courses milik sendiri
        $instructor = Instructor::where('user_id', Auth::id())->first();

        if (!$instructor) {
            return redirect()->back()->with('error', 'Akses ditolak! Anda bukan instructor.');
        }

        $courses = Course::where('instructor_id', $instructor->id)
            ->with('category')
            ->withCount('enrollments')
            ->paginate(10);

        return view('admin.courses.index', compact('courses', 'categories', 'instructor'));
    }

    public function store(Request $request)
    {
        // Jika instructor, otomatis gunakan instructor_id sendiri
        if (Auth::user()->role === 'instructor') {
            $instructor = Instructor::where('user_id', Auth::id())->first();

            if (!$instructor) {
                return redirect()->back()->with('error', 'Akses ditolak! Anda bukan instructor.');
            }

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'category_id' => 'nullable|exists:categories,id',
                'thumbnail' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
                'preview_video_url' => 'nullable|url',
                'resource_file' => 'nullable|file|mimes:zip,rar,pdf,doc,docx,ppt,pptx,xls,xlsx|max:51200', // max 50MB
            ]);

            $validated['instructor_id'] = $instructor->id;
        } else {
            // Admin bisa memilih instructor
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'category_id' => 'nullable|exists:categories,id',
                'instructor_id' => 'required|exists:instructors,id',
                'thumbnail' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
                'preview_video_url' => 'nullable|url',
                'resource_file' => 'nullable|file|mimes:zip,rar,pdf,doc,docx,ppt,pptx,xls,xlsx|max:51200', // max 50MB
            ]);
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            $validated['thumbnail'] = $thumbnailPath;
        }

        // Handle resource file upload
        if ($request->hasFile('resource_file')) {
            $file = $request->file('resource_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('resources', $fileName, 'public');
            $validated['resource_file'] = $filePath;
            $validated['resource_file_name'] = $file->getClientOriginalName();
        }

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_published'] = false;
        $validated['published'] = false;

        Course::create($validated);

        return back()->with('success', 'Kelas berhasil dibuat!');
    }

    public function update(Request $request, Course $course)
    {
        // Jika instructor, pastikan course milik instructor tersebut
        if (Auth::user()->role === 'instructor') {
            $instructor = Instructor::where('user_id', Auth::id())->first();

            if (!$instructor || $course->instructor_id !== $instructor->id) {
                return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengedit kelas ini.');
            }

            // Instructor tidak bisa mengubah instructor_id
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'category_id' => 'nullable|exists:categories,id',
                'published' => 'nullable|boolean',
                'is_published' => 'nullable|boolean',
                'thumbnail' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
                'preview_video_url' => 'nullable|url',
                'resource_file' => 'nullable|file|mimes:zip,rar,pdf,doc,docx,ppt,pptx,xls,xlsx|max:51200',
            ]);
        } else {
            // Admin bisa edit semua dan mengubah instructor
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'category_id' => 'nullable|exists:categories,id',
                'instructor_id' => 'nullable|exists:instructors,id',
                'published' => 'nullable|boolean',
                'is_published' => 'nullable|boolean',
                'thumbnail' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
                'preview_video_url' => 'nullable|url',
                'resource_file' => 'nullable|file|mimes:zip,rar,pdf,doc,docx,ppt,pptx,xls,xlsx|max:51200',
            ]);
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($course->thumbnail && \Storage::disk('public')->exists($course->thumbnail)) {
                \Storage::disk('public')->delete($course->thumbnail);
            }

            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            $validated['thumbnail'] = $thumbnailPath;
        }

        // Handle resource file upload
        if ($request->hasFile('resource_file')) {
            // Delete old resource file if exists
            if ($course->resource_file && \Storage::disk('public')->exists($course->resource_file)) {
                \Storage::disk('public')->delete($course->resource_file);
            }

            $file = $request->file('resource_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('resources', $fileName, 'public');
            $validated['resource_file'] = $filePath;
            $validated['resource_file_name'] = $file->getClientOriginalName();
        }

        // Sync both published fields
        if (isset($validated['published'])) {
            $validated['is_published'] = $validated['published'];
        }

        $course->update($validated);

        return back()->with('success', 'Kelas berhasil diperbarui!');
    }

    public function destroy(Course $course)
    {
        // Admin bisa hapus semua courses
        if (Auth::user()->role !== 'admin') {
            $instructor = Instructor::where('user_id', Auth::id())->first();

            if (!$instructor || $course->instructor_id !== $instructor->id) {
                return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus kelas ini.');
            }
        }

        $course->delete();

        return back()->with('success', 'Kelas berhasil dihapus!');
    }
}
