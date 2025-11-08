<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Instructor;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    public function index()
    {
        // Ambil semua user yang role-nya 'instructor'
        $users = User::where('role', 'instructor')->get();
        $instructors = Instructor::with('user')->paginate(10);
        return view('admin.instructors.index', compact('instructors', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'bio' => 'nullable|string',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        // Simpan foto profil jika diupload
        if ($request->hasFile('profile_picture')) {
            $validated['profile_picture'] = $request->file('profile_picture')->store('instructors', 'public');
        }

        Instructor::create($validated);


        return back()->with('success', 'Instructor berhasil ditambahkan!');
    }

    public function destroy(Instructor $instructor)
    {
        $instructor->delete();

        return back()->with('success', 'Instructor berhasil dihapus!');
    }
}
