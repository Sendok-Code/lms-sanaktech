<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
{
    public function index()
    {
        // Jika instructor, hanya tampilkan courses dan modules miliknya
        if (Auth::user()->role === 'instructor') {
            $instructor = Instructor::where('user_id', Auth::id())->first();

            if (!$instructor) {
                return redirect()->back()->with('error', 'Akses ditolak! Anda bukan instructor.');
            }

            $courses = Course::where('instructor_id', $instructor->id)->get();
            $modules = Module::with('course')
                ->whereHas('course', function($query) use ($instructor) {
                    $query->where('instructor_id', $instructor->id);
                })
                ->get();
        } else {
            // Admin bisa lihat semua
            $courses = Course::all();
            $modules = Module::with('course')->get();
        }

        return view('admin.modules.index', compact('courses', 'modules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Jika instructor, pastikan course miliknya
        if (Auth::user()->role === 'instructor') {
            $instructor = Instructor::where('user_id', Auth::id())->first();
            $course = Course::find($validated['course_id']);

            if (!$course || $course->instructor_id !== $instructor->id) {
                return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menambah modul ke course ini.');
            }
        }

        Module::create($validated);

        return back()->with('success', 'Modul berhasil ditambahkan!');
    }

    public function update(Request $request, Module $module)
    {
        // Jika instructor, pastikan module dari course miliknya
        if (Auth::user()->role === 'instructor') {
            $instructor = Instructor::where('user_id', Auth::id())->first();

            if (!$module->course || $module->course->instructor_id !== $instructor->id) {
                return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengedit modul ini.');
            }
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $module->update($validated);

        return back()->with('success', 'Modul berhasil diperbarui!');
    }

    public function destroy(Module $module)
    {
        // Jika instructor, pastikan module dari course miliknya
        if (Auth::user()->role === 'instructor') {
            $instructor = Instructor::where('user_id', Auth::id())->first();

            if (!$module->course || $module->course->instructor_id !== $instructor->id) {
                return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus modul ini.');
            }
        }

        $module->delete();
        return back()->with('success', 'Modul berhasil dihapus!');
    }

}
