<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Instructor;
use App\Models\Course;
use App\Models\Module;
use App\Models\Video;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@lms.com'],
            [
                'name' => 'Admin LMS',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Create Instructor User
        $instructorUser = User::firstOrCreate(
            ['email' => 'instructor@lms.com'],
            [
                'name' => 'Dr. Ahmad Fauzi',
                'password' => Hash::make('password'),
                'role' => 'instructor',
            ]
        );

        // Create Instructor Profile
        $instructor = Instructor::firstOrCreate(
            ['user_id' => $instructorUser->id],
            [
                'bio' => 'Expert dalam pengembangan web dan pemrograman. Memiliki pengalaman 10+ tahun dalam industri teknologi.',
            ]
        );

        // Create Student Users
        $student1 = User::firstOrCreate(
            ['email' => 'student@lms.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role' => 'student',
            ]
        );

        $student2 = User::firstOrCreate(
            ['email' => 'student2@lms.com'],
            [
                'name' => 'Siti Nurhaliza',
                'password' => Hash::make('password'),
                'role' => 'student',
            ]
        );

        // Create Categories
        $programmingCategory = Category::firstOrCreate(
            ['slug' => 'programming'],
            ['name' => 'Programming']
        );

        $webDevCategory = Category::firstOrCreate(
            ['slug' => 'web-development'],
            ['name' => 'Web Development']
        );

        Category::firstOrCreate(['slug' => 'mobile-development'], ['name' => 'Mobile Development']);
        Category::firstOrCreate(['slug' => 'data-science'], ['name' => 'Data Science']);
        Category::firstOrCreate(['slug' => 'design'], ['name' => 'Design']);

        // Create Courses
        $course1 = Course::firstOrCreate(
            ['slug' => 'dasar-pemrograman-php'],
            [
                'title' => 'Dasar Pemrograman PHP',
                'description' => 'Pelajari dasar-dasar pemrograman PHP dari nol hingga mahir. Kursus ini cocok untuk pemula yang ingin memulai karir sebagai web developer.',
                'price' => 250000,
                'instructor_id' => $instructor->id,
                'category_id' => $programmingCategory->id,
                'published' => true,
            ]
        );

        $course2 = Course::firstOrCreate(
            ['slug' => 'laravel-untuk-pemula'],
            [
                'title' => 'Laravel untuk Pemula',
                'description' => 'Kuasai framework Laravel dan bangun aplikasi web modern. Belajar routing, database, authentication, dan masih banyak lagi!',
                'price' => 350000,
                'instructor_id' => $instructor->id,
                'category_id' => $webDevCategory->id,
                'published' => true,
            ]
        );

        $course3 = Course::firstOrCreate(
            ['slug' => 'vuejs-complete-guide'],
            [
                'title' => 'Vue.js Complete Guide',
                'description' => 'Pelajari Vue.js dari dasar hingga advanced. Bangun single page application yang modern dan interaktif.',
                'price' => 300000,
                'instructor_id' => $instructor->id,
                'category_id' => $webDevCategory->id,
                'published' => true,
            ]
        );

        // Create Modules and Videos for Course 1
        $module1 = Module::firstOrCreate(
            ['course_id' => $course1->id, 'sort_order' => 1],
            ['title' => 'Pengenalan PHP']
        );

        Video::firstOrCreate(
            ['module_id' => $module1->id, 'sort_order' => 1],
            [
                'course_id' => $course1->id,
                'title' => 'Apa itu PHP?',
                'video_url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
                'duration_seconds' => 300,
            ]
        );

        Video::firstOrCreate(
            ['module_id' => $module1->id, 'sort_order' => 2],
            [
                'course_id' => $course1->id,
                'title' => 'Instalasi PHP dan Server',
                'video_url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
                'duration_seconds' => 450,
            ]
        );

        $module2 = Module::firstOrCreate(
            ['course_id' => $course1->id, 'sort_order' => 2],
            ['title' => 'Variabel dan Tipe Data']
        );

        Video::firstOrCreate(
            ['module_id' => $module2->id, 'sort_order' => 1],
            [
                'course_id' => $course1->id,
                'title' => 'Variabel di PHP',
                'video_url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
                'duration_seconds' => 380,
            ]
        );

        // Create Modules for Course 2
        $module3 = Module::firstOrCreate(
            ['course_id' => $course2->id, 'sort_order' => 1],
            ['title' => 'Pengenalan Laravel']
        );

        Video::firstOrCreate(
            ['module_id' => $module3->id, 'sort_order' => 1],
            [
                'course_id' => $course2->id,
                'title' => 'Apa itu Laravel?',
                'video_url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
                'duration_seconds' => 320,
            ]
        );

        Video::firstOrCreate(
            ['module_id' => $module3->id, 'sort_order' => 2],
            [
                'course_id' => $course2->id,
                'title' => 'Instalasi Laravel',
                'video_url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
                'duration_seconds' => 540,
            ]
        );

        // Create More Courses
        $course4 = Course::firstOrCreate(
            ['slug' => 'javascript-mastery'],
            [
                'title' => 'JavaScript Mastery',
                'description' => 'Master JavaScript dari fundamental hingga advanced. Pelajari ES6+, async programming, dan best practices.',
                'price' => 280000,
                'instructor_id' => $instructor->id,
                'category_id' => $programmingCategory->id,
                'published' => true,
            ]
        );

        $course5 = Course::firstOrCreate(
            ['slug' => 'react-complete-course'],
            [
                'title' => 'React Complete Course',
                'description' => 'Bangun aplikasi modern dengan React. Pelajari hooks, context API, Redux, dan React Router.',
                'price' => 400000,
                'instructor_id' => $instructor->id,
                'category_id' => $webDevCategory->id,
                'published' => true,
            ]
        );

        $course6 = Course::firstOrCreate(
            ['slug' => 'python-data-science'],
            [
                'title' => 'Python untuk Data Science',
                'description' => 'Analisis data dengan Python menggunakan Pandas, NumPy, dan Matplotlib. Cocok untuk data analyst pemula.',
                'price' => 450000,
                'instructor_id' => $instructor->id,
                'category_id' => Category::where('slug', 'data-science')->first()->id,
                'published' => true,
            ]
        );

        // Add more modules for existing courses
        $module4 = Module::firstOrCreate(
            ['course_id' => $course3->id, 'sort_order' => 2],
            ['title' => 'Components & Props']
        );

        Video::firstOrCreate(
            ['module_id' => $module4->id, 'sort_order' => 1],
            [
                'course_id' => $course3->id,
                'title' => 'Creating Components',
                'video_url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
                'duration_seconds' => 480,
            ]
        );

        Video::firstOrCreate(
            ['module_id' => $module4->id, 'sort_order' => 2],
            [
                'course_id' => $course3->id,
                'title' => 'Props & Data Flow',
                'video_url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
                'duration_seconds' => 510,
            ]
        );

        // Add more students
        for ($i = 3; $i <= 10; $i++) {
            User::firstOrCreate(
                ['email' => "student{$i}@lms.com"],
                [
                    'name' => "Student {$i}",
                    'password' => Hash::make('password'),
                    'role' => 'student',
                ]
            );
        }

        // Create more instructors
        $instructor2User = User::firstOrCreate(
            ['email' => 'instructor2@lms.com'],
            [
                'name' => 'Prof. Siti Rahmawati',
                'password' => Hash::make('password'),
                'role' => 'instructor',
            ]
        );

        $instructor2 = Instructor::firstOrCreate(
            ['user_id' => $instructor2User->id],
            [
                'bio' => 'Spesialis dalam Data Science dan Machine Learning. Pernah bekerja di perusahaan teknologi terkemuka.',
            ]
        );

        // Add courses from instructor 2
        $course7 = Course::firstOrCreate(
            ['slug' => 'machine-learning-basics'],
            [
                'title' => 'Machine Learning Basics',
                'description' => 'Pengenalan Machine Learning dengan Python. Pelajari algoritma dasar dan implementasinya.',
                'price' => 500000,
                'instructor_id' => $instructor2->id,
                'category_id' => Category::where('slug', 'data-science')->first()->id,
                'published' => true,
            ]
        );

        $course8 = Course::firstOrCreate(
            ['slug' => 'ui-ux-design-fundamentals'],
            [
                'title' => 'UI/UX Design Fundamentals',
                'description' => 'Pelajari prinsip desain UI/UX yang efektif. Dari wireframing hingga prototyping.',
                'price' => 320000,
                'instructor_id' => $instructor2->id,
                'category_id' => Category::where('slug', 'design')->first()->id,
                'published' => true,
            ]
        );

        // Add modules for new courses
        $jsModule1 = Module::firstOrCreate(
            ['course_id' => $course4->id, 'sort_order' => 1],
            ['title' => 'JavaScript Fundamentals']
        );

        Video::firstOrCreate(
            ['module_id' => $jsModule1->id, 'sort_order' => 1],
            [
                'course_id' => $course4->id,
                'title' => 'Variables & Data Types',
                'video_url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
                'duration_seconds' => 420,
            ]
        );

        Video::firstOrCreate(
            ['module_id' => $jsModule1->id, 'sort_order' => 2],
            [
                'course_id' => $course4->id,
                'title' => 'Functions & Scope',
                'video_url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
                'duration_seconds' => 540,
            ]
        );

        Video::firstOrCreate(
            ['module_id' => $jsModule1->id, 'sort_order' => 3],
            [
                'course_id' => $course4->id,
                'title' => 'Arrays & Objects',
                'video_url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
                'duration_seconds' => 480,
            ]
        );

        // Add some reviews
        $reviewUser = User::where('email', 'student@lms.com')->first();
        \App\Models\Review::firstOrCreate(
            ['user_id' => $reviewUser->id, 'course_id' => $course1->id],
            [
                'rating' => 5,
                'comment' => 'Kursus yang sangat bagus! Materinya mudah dipahami dan instrukturnya sangat membantu.',
            ]
        );

        \App\Models\Review::firstOrCreate(
            ['user_id' => $reviewUser->id, 'course_id' => $course2->id],
            [
                'rating' => 5,
                'comment' => 'Laravel explained with great examples. Highly recommended!',
            ]
        );

        $student2Review = User::where('email', 'student2@lms.com')->first();
        \App\Models\Review::firstOrCreate(
            ['user_id' => $student2Review->id, 'course_id' => $course1->id],
            [
                'rating' => 4,
                'comment' => 'Bagus, tapi mungkin bisa ditambahkan lebih banyak contoh praktis.',
            ]
        );

        $this->command->info('✅ Demo data created successfully!');
        $this->command->info('');
        $this->command->info('📊 Data Summary:');
        $this->command->info('- Users: 13 (1 Admin, 2 Instructors, 10 Students)');
        $this->command->info('- Categories: 5');
        $this->command->info('- Courses: 8 (All Published)');
        $this->command->info('- Modules: 7+');
        $this->command->info('- Videos: 15+');
        $this->command->info('- Reviews: 3');
        $this->command->info('');
        $this->command->info('🔑 Login Credentials:');
        $this->command->info('Admin: admin@lms.com / password');
        $this->command->info('Instructor 1: instructor@lms.com / password');
        $this->command->info('Instructor 2: instructor2@lms.com / password');
        $this->command->info('Students: student@lms.com - student10@lms.com / password');
    }
}
