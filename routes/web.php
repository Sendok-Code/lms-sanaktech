<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\WelcomeSettingController;

Route::get('/', function () {
    $settings = \App\Models\WelcomeSetting::first();
    return view('welcome', compact('settings'));
});

// Search route
Route::get('/search', [WelcomeSettingController::class, 'search'])->name('search');


// Redirect register to login (using Google OAuth only)
Route::get('/register', function () {
    return redirect()->route('login');
});

Route::view('/login', 'auth.login')->name('login');
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('login.post');

// Logout route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Google OAuth routes (primary authentication method)
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])
    ->middleware('throttle:10,1')
    ->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])
    ->middleware('throttle:10,1')
    ->name('auth.google.callback');

// Admin & Instructor routes (Backend)
Route::middleware(['auth', 'role:admin,instructor'])->group(function () {
    Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');

    // Course routes
    Route::get('/courses', [CourseController::class, 'index'])->name('admin.courses.index');
    Route::post('/courses', [CourseController::class, 'store'])->name('admin.courses.store');
    Route::put('/courses/{course}', [CourseController::class, 'update'])->name('admin.courses.update');
    Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('admin.courses.destroy');

    // Module routes
    Route::get('modules', [ModuleController::class, 'index'])->name('admin.modules.index');
    Route::post('modules', [ModuleController::class, 'store'])->name('admin.modules.store');
    Route::put('modules/{module}', [ModuleController::class, 'update'])->name('admin.modules.update');
    Route::delete('modules/{module}', [ModuleController::class, 'destroy'])->name('admin.modules.destroy');

    // Video routes
    Route::get('videos', [VideoController::class, 'index'])->name('admin.videos.index');
    Route::post('videos', [VideoController::class, 'store'])->name('admin.videos.store');
    Route::put('videos/{video}', [VideoController::class, 'update'])->name('admin.videos.update');
    Route::delete('videos/{video}', [VideoController::class, 'destroy'])->name('admin.videos.destroy');
});

// Admin & Instructor Dashboard
Route::middleware(['auth', 'role:admin,instructor'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        if (Auth::user()->role === 'admin') {
            return view('admin.index');
        }

        // Instructor dashboard
        $instructor = \App\Models\Instructor::where('user_id', Auth::id())->first();

        if (!$instructor) {
            return redirect()->back()->with('error', 'Akses ditolak! Anda bukan instructor.');
        }

        // Get instructor statistics
        $courses = \App\Models\Course::where('instructor_id', $instructor->id)
            ->withCount(['enrollments', 'modules', 'videos'])
            ->with('category')
            ->get();

        $stats = [
            'total_courses' => $courses->count(),
            'published_courses' => $courses->where('published', true)->count(),
            'total_students' => $courses->sum('enrollments_count'),
            'total_videos' => $courses->sum('videos_count'),
            'avg_progress' => round($courses->avg('average_progress') ?? 0),
        ];

        $recent_enrollments = \App\Models\Enrollment::whereHas('course', function($query) use ($instructor) {
                $query->where('instructor_id', $instructor->id);
            })
            ->with(['user', 'course'])
            ->latest()
            ->take(5)
            ->get();

        return view('instructor.dashboard', compact('stats', 'courses', 'recent_enrollments'));
    })->name('index');
});

// Admin only routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class)->except(['show', 'create', 'edit']);

    // Instructor routes (admin only)
    Route::get('/instructors', [InstructorController::class, 'index'])->name('instructors.index');
    Route::post('/instructors', [InstructorController::class, 'store'])->name('instructors.store');
    Route::delete('/instructors/{instructor}', [InstructorController::class, 'destroy'])->name('instructors.destroy');

    // Settings routes
    Route::get('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
    Route::get('/settings/test-simple', [App\Http\Controllers\Admin\SettingsController::class, 'testSimple'])->name('settings.test-simple');
    Route::put('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
    Route::delete('/settings/logo', [App\Http\Controllers\Admin\SettingsController::class, 'deleteLogo'])->name('settings.delete-logo');

    // Welcome Settings routes
    Route::get('/welcome-settings', [WelcomeSettingController::class, 'index'])->name('welcome-settings.index');
    Route::put('/welcome-settings', [WelcomeSettingController::class, 'update'])->name('welcome-settings.update');

    // Coupon routes
    Route::get('/coupons', [App\Http\Controllers\CouponController::class, 'index'])->name('coupons.index');
    Route::post('/coupons', [App\Http\Controllers\CouponController::class, 'store'])->name('coupons.store');
    Route::put('/coupons/{coupon}', [App\Http\Controllers\CouponController::class, 'update'])->name('coupons.update');
    Route::delete('/coupons/{coupon}', [App\Http\Controllers\CouponController::class, 'destroy'])->name('coupons.destroy');

    // Review routes
    Route::get('/reviews', [App\Http\Controllers\ReviewController::class, 'index'])->name('reviews.index');
    Route::delete('/reviews/{review}', [App\Http\Controllers\ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Enrollment routes (admin)
    Route::get('/enrollments', [EnrollmentController::class, 'adminIndex'])->name('enrollments.index');

    // Progress routes
    Route::get('/progress', [App\Http\Controllers\ProgressController::class, 'index'])->name('progress.index');

    // Transaction routes
    Route::get('/transactions', [App\Http\Controllers\PaymentTransactionController::class, 'index'])->name('transactions.index');
});

// Student routes
Route::middleware(['auth'])->prefix('student')->name('student.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');

    // Course browsing
    Route::get('/courses', [StudentController::class, 'courses'])->name('courses.index');
    Route::get('/courses/{course}', [StudentController::class, 'showCourse'])->name('courses.show');
    Route::get('/courses/{course}/learn', [StudentController::class, 'learnCourse'])->name('courses.learn');

    // Enrollments
    Route::get('/enrollments', [EnrollmentController::class, 'index'])->name('enrollments.index');
    Route::post('/enrollments/{course}', [EnrollmentController::class, 'store'])->name('enrollments.store');

    // Progress tracking
    Route::post('/progress/{video}', [StudentController::class, 'updateProgress'])->name('progress.update');
});

// Payment routes
Route::middleware(['auth'])->group(function () {
    // Checkout page
    Route::get('/courses/{course}/checkout', [PaymentController::class, 'checkout'])->name('payments.checkout');

    // Validate coupon
    Route::post('/courses/{course}/payment/validate-coupon', [PaymentController::class, 'validateCoupon'])->name('payments.validateCoupon');

    // Process payment (get Snap token)
    Route::post('/courses/{course}/payment/process', [PaymentController::class, 'process'])->name('payments.process');

    // Payment finish/success page
    Route::get('/payment/finish', [PaymentController::class, 'finish'])->name('payments.finish');

    // Payment unfinish/pending page
    Route::get('/payment/unfinish', [PaymentController::class, 'unfinish'])->name('payments.unfinish');

    // Payment error page
    Route::get('/payment/error', [PaymentController::class, 'error'])->name('payments.error');
});

// Midtrans callback (no auth required, but rate limited for security)
Route::post('/payment/callback', [PaymentController::class, 'callback'])
    ->middleware('throttle:60,1')
    ->name('payments.callback');