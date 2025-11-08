<?php

namespace App\Http\Controllers;

use App\Models\Progress;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    public function index()
    {
        $progresses = Progress::with(['enrollment.user', 'enrollment.course', 'video'])
            ->whereHas('enrollment')
            ->latest()
            ->paginate(50);

        return view('admin.progress.index', compact('progresses'));
    }
}
