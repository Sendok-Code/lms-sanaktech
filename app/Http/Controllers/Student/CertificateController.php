<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateController extends Controller
{
    public function show(Course $course)
    {
        $enrollment = Enrollment::where('user_id', auth()->id())
            ->where('course_id', $course->id)
            ->with(['course.modules.videos', 'progress'])
            ->firstOrFail();

        // Check if course is completed
        $totalVideos = $enrollment->course->modules->sum(function ($module) {
            return $module->videos->count();
        });

        $completedVideos = $enrollment->progress()->where('completed', true)->count();

        if ($completedVideos < $totalVideos) {
            return redirect()->back()->with('error', 'Anda harus menyelesaikan semua video terlebih dahulu untuk mendapatkan sertifikat.');
        }

        // Check if certificate already exists
        $certificate = Certificate::where('enrollment_id', $enrollment->id)->first();

        if (!$certificate) {
            // Generate certificate
            $certificate = Certificate::create([
                'enrollment_id' => $enrollment->id,
                'certificate_url' => 'certificates/' . uniqid() . '.pdf',
                'issued_at' => now(),
            ]);
        }

        return view('student.certificates.show', compact('certificate', 'enrollment', 'course'));
    }

    public function download(Course $course)
    {
        $enrollment = Enrollment::where('user_id', auth()->id())
            ->where('course_id', $course->id)
            ->with(['course.instructor.user', 'user'])
            ->firstOrFail();

        $certificate = Certificate::where('enrollment_id', $enrollment->id)->firstOrFail();

        // Get settings using Setting::get() method
        $ceoName = \App\Models\Setting::get('ceo_name', 'CEO & Founder');
        $platformName = \App\Models\Setting::get('platform_name', 'LMS Learning Platform');
        $siteLogo = \App\Models\Setting::get('site_logo');
        $ceoSignature = \App\Models\Setting::get('ceo_signature');

        // DEBUG: Log the values
        \Log::info('Certificate PDF Data', [
            'ceo_name' => $ceoName,
            'platform_name' => $platformName,
            'site_logo' => $siteLogo,
            'ceo_signature' => $ceoSignature,
        ]);

        // Get logo path
        $logoPath = null;
        if ($siteLogo) {
            $logoPath = public_path('storage/' . $siteLogo);
        }

        // Get signature path
        $signaturePath = null;
        if ($ceoSignature) {
            $signaturePath = public_path('storage/' . $ceoSignature);
        }

        $pdf = Pdf::loadView('student.certificates.pdf', [
            'certificate' => $certificate,
            'enrollment' => $enrollment,
            'course' => $course,
            'student' => $enrollment->user,
            'instructor' => $enrollment->course->instructor,
            'ceoName' => $ceoName,
            'platformName' => $platformName,
            'logoPath' => $logoPath,
            'signaturePath' => $signaturePath,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('certificate-' . $certificate->certificate_number . '.pdf');
    }

    public function preview(Course $course)
    {
        $enrollment = Enrollment::where('user_id', auth()->id())
            ->where('course_id', $course->id)
            ->with(['course.instructor.user', 'user'])
            ->firstOrFail();

        $certificate = Certificate::where('enrollment_id', $enrollment->id)->firstOrFail();

        // Get settings using Setting::get() method
        $ceoName = \App\Models\Setting::get('ceo_name', 'CEO & Founder');
        $platformName = \App\Models\Setting::get('platform_name', 'LMS Learning Platform');
        $siteLogo = \App\Models\Setting::get('site_logo');
        $ceoSignature = \App\Models\Setting::get('ceo_signature');

        // Get logo URL for preview
        $logoUrl = null;
        if ($siteLogo) {
            $logoUrl = asset('storage/' . $siteLogo);
        }

        // Get signature URL for preview
        $signatureUrl = null;
        if ($ceoSignature) {
            $signatureUrl = asset('storage/' . $ceoSignature);
        }

        return view('student.certificates.pdf', [
            'certificate' => $certificate,
            'enrollment' => $enrollment,
            'course' => $course,
            'student' => $enrollment->user,
            'instructor' => $enrollment->course->instructor,
            'ceoName' => $ceoName,
            'platformName' => $platformName,
            'logoUrl' => $logoUrl,
            'signatureUrl' => $signatureUrl,
        ]);
    }
}
