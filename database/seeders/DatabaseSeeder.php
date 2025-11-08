<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Instructor;
use App\Models\Course;
use App\Models\Module;
use App\Models\Video;
use App\Models\Coupon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@lms.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Create Student Users
        $student1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@student.com',
            'password' => bcrypt('password'),
            'role' => 'student',
        ]);

        $student2 = User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@student.com',
            'password' => bcrypt('password'),
            'role' => 'student',
        ]);

        // Create Categories
        $categories = [
            ['name' => 'Web Development', 'slug' => 'web-development'],
            ['name' => 'Mobile Development', 'slug' => 'mobile-development'],
            ['name' => 'Data Science', 'slug' => 'data-science'],
            ['name' => 'UI/UX Design', 'slug' => 'ui-ux-design'],
            ['name' => 'Digital Marketing', 'slug' => 'digital-marketing'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Create Instructors
        $instructorUser1 = User::create([
            'name' => 'John Doe',
            'email' => 'john@instructor.com',
            'password' => bcrypt('password'),
            'role' => 'instructor',
        ]);
        Instructor::create([
            'user_id' => $instructorUser1->id,
            'bio' => 'Senior Web Developer dengan 10 tahun pengalaman',
        ]);

        $instructorUser2 = User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@instructor.com',
            'password' => bcrypt('password'),
            'role' => 'instructor',
        ]);
        Instructor::create([
            'user_id' => $instructorUser2->id,
            'bio' => 'UI/UX Designer dan Frontend Expert',
        ]);

        $instructorUser3 = User::create([
            'name' => 'Ahmad Yani',
            'email' => 'ahmad@instructor.com',
            'password' => bcrypt('password'),
            'role' => 'instructor',
        ]);
        Instructor::create([
            'user_id' => $instructorUser3->id,
            'bio' => 'Data Scientist dan Machine Learning Engineer',
        ]);

        // Create Courses
        $courses = [
            [
                'title' => 'Mastering Laravel 11',
                'slug' => 'mastering-laravel-11',
                'description' => 'Pelajari Laravel 11 dari dasar hingga advanced. Membangun aplikasi web modern dengan Laravel framework terbaru.',
                'price' => 299000,
                'category_id' => 1,
                'instructor_id' => 1,
                'is_published' => true,
                'published' => true,
            ],
            [
                'title' => 'React JS Complete Guide',
                'slug' => 'react-js-complete-guide',
                'description' => 'Belajar React JS dari nol sampai mahir. Membangun single page application yang powerful dan modern.',
                'price' => 349000,
                'category_id' => 1,
                'instructor_id' => 2,
                'is_published' => true,
                'published' => true,
            ],
            [
                'title' => 'Flutter Mobile Development',
                'slug' => 'flutter-mobile-development',
                'description' => 'Membuat aplikasi mobile cross-platform dengan Flutter. Satu kode untuk Android dan iOS.',
                'price' => 399000,
                'category_id' => 2,
                'instructor_id' => 1,
                'is_published' => true,
                'published' => true,
            ],
            [
                'title' => 'Python for Data Science',
                'slug' => 'python-for-data-science',
                'description' => 'Belajar Python untuk Data Science. Analisis data, visualisasi, dan machine learning.',
                'price' => 450000,
                'category_id' => 3,
                'instructor_id' => 3,
                'is_published' => true,
                'published' => true,
            ],
            [
                'title' => 'UI/UX Design Fundamentals',
                'slug' => 'ui-ux-design-fundamentals',
                'description' => 'Dasar-dasar desain UI/UX. Belajar prinsip desain, prototyping, dan user research.',
                'price' => 275000,
                'category_id' => 4,
                'instructor_id' => 2,
                'is_published' => true,
                'published' => true,
            ],
            [
                'title' => 'Digital Marketing Strategy',
                'slug' => 'digital-marketing-strategy',
                'description' => 'Strategi digital marketing modern. SEO, SEM, Social Media Marketing, dan Content Marketing.',
                'price' => 225000,
                'category_id' => 5,
                'instructor_id' => 2,
                'is_published' => true,
                'published' => true,
            ],
        ];

        foreach ($courses as $courseData) {
            $course = Course::create($courseData);

            // Create Modules for each course
            for ($i = 1; $i <= 4; $i++) {
                $module = Module::create([
                    'title' => "Module {$i}: " . $this->getModuleTitle($course->title, $i),
                    'course_id' => $course->id,
                    'sort_order' => $i,
                ]);

                // Create Videos for each module
                for ($j = 1; $j <= 5; $j++) {
                    Video::create([
                        'title' => "Video {$j}: " . $this->getVideoTitle($i, $j),
                        'video_url' => "https://www.youtube.com/watch?v=dQw4w9WgXcQ",
                        'duration_seconds' => rand(300, 1800),
                        'course_id' => $course->id,
                        'module_id' => $module->id,
                        'sort_order' => $j,
                    ]);
                }
            }
        }

        // Create Sample Coupons
        $coupons = [
            [
                'code' => 'WELCOME50',
                'name' => 'Diskon Welcome 50%',
                'description' => 'Diskon 50% untuk pengguna baru',
                'type' => 'percentage',
                'value' => 50,
                'max_uses' => 100,
                'min_purchase' => 0,
                'expires_at' => now()->addMonths(3),
                'is_active' => true,
            ],
            [
                'code' => 'DISC20',
                'name' => 'Diskon 20%',
                'description' => 'Diskon 20% untuk semua kursus',
                'type' => 'percentage',
                'value' => 20,
                'max_uses' => 200,
                'min_purchase' => 100000,
                'expires_at' => now()->addMonths(6),
                'is_active' => true,
            ],
            [
                'code' => 'HEMAT100K',
                'name' => 'Hemat Rp 100.000',
                'description' => 'Potongan langsung Rp 100.000',
                'type' => 'fixed',
                'value' => 100000,
                'max_uses' => 50,
                'min_purchase' => 300000,
                'expires_at' => now()->addMonth(),
                'is_active' => true,
            ],
            [
                'code' => 'LEBARAN30',
                'name' => 'Promo Lebaran 30%',
                'description' => 'Diskon spesial lebaran 30%',
                'type' => 'percentage',
                'value' => 30,
                'max_uses' => 150,
                'min_purchase' => 200000,
                'expires_at' => now()->addWeeks(2),
                'is_active' => true,
            ],
        ];

        foreach ($coupons as $coupon) {
            Coupon::create($coupon);
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin: admin@lms.com / password');
        $this->command->info('Student: budi@student.com / password');
        $this->command->info('Instructor: john@instructor.com / password');
    }

    private function getModuleTitle($courseTitle, $moduleNumber)
    {
        $titles = [
            'Mastering Laravel 11' => [
                'Introduction & Setup',
                'Routing & Controllers',
                'Database & Eloquent ORM',
                'Advanced Features',
            ],
            'React JS Complete Guide' => [
                'React Basics',
                'Components & Props',
                'State Management',
                'Advanced Patterns',
            ],
            'Flutter Mobile Development' => [
                'Flutter Basics',
                'Widgets & Layouts',
                'State Management',
                'API Integration',
            ],
            'Python for Data Science' => [
                'Python Fundamentals',
                'Data Analysis',
                'Data Visualization',
                'Machine Learning',
            ],
            'UI/UX Design Fundamentals' => [
                'Design Principles',
                'User Research',
                'Prototyping',
                'Testing & Iteration',
            ],
            'Digital Marketing Strategy' => [
                'Marketing Fundamentals',
                'SEO & SEM',
                'Social Media Marketing',
                'Analytics & Reporting',
            ],
        ];

        return $titles[$courseTitle][$moduleNumber - 1] ?? "Module {$moduleNumber}";
    }

    private function getVideoTitle($moduleNumber, $videoNumber)
    {
        $titles = [
            "Introduction to the Topic",
            "Core Concepts Explained",
            "Practical Examples",
            "Best Practices",
            "Common Pitfalls",
        ];

        return $titles[$videoNumber - 1] ?? "Lesson {$videoNumber}";
    }
}
