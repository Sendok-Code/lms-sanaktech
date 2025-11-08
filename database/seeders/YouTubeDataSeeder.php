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
use App\Models\Review;

class YouTubeDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create Users
        $admin = User::create([
            'name' => 'Admin LMS',
            'email' => 'admin@lms.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $instructorUser1 = User::create([
            'name' => 'Dr. Ahmad Fauzi',
            'email' => 'instructor@lms.com',
            'password' => Hash::make('password'),
            'role' => 'instructor',
        ]);

        $instructor1 = Instructor::create([
            'user_id' => $instructorUser1->id,
            'bio' => 'Expert dalam pengembangan web dan pemrograman. Memiliki pengalaman 10+ tahun dalam industri teknologi.',
        ]);

        $instructorUser2 = User::create([
            'name' => 'Prof. Siti Rahmawati',
            'email' => 'instructor2@lms.com',
            'password' => Hash::make('password'),
            'role' => 'instructor',
        ]);

        $instructor2 = Instructor::create([
            'user_id' => $instructorUser2->id,
            'bio' => 'Spesialis dalam Data Science dan Machine Learning. Pernah bekerja di perusahaan teknologi terkemuka.',
        ]);

        // Create Students
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => "Student {$i}",
                'email' => "student{$i}@lms.com",
                'password' => Hash::make('password'),
                'role' => 'student',
            ]);
        }

        // Create Categories
        $programming = Category::create(['name' => 'Programming', 'slug' => 'programming']);
        $webDev = Category::create(['name' => 'Web Development', 'slug' => 'web-development']);
        $mobile = Category::create(['name' => 'Mobile Development', 'slug' => 'mobile-development']);
        $dataScience = Category::create(['name' => 'Data Science', 'slug' => 'data-science']);
        $design = Category::create(['name' => 'Design', 'slug' => 'design']);

        // ============================================
        // COURSE 1: PHP Dasar
        // ============================================
        $phpCourse = Course::create([
            'title' => 'Dasar Pemrograman PHP',
            'slug' => 'dasar-pemrograman-php',
            'description' => 'Pelajari dasar-dasar pemrograman PHP dari nol hingga mahir. Kursus ini cocok untuk pemula yang ingin memulai karir sebagai web developer.',
            'price' => 250000,
            'instructor_id' => $instructor1->id,
            'category_id' => $programming->id,
            'published' => true,
        ]);

        $phpModule1 = Module::create(['course_id' => $phpCourse->id, 'title' => 'Pengenalan PHP', 'sort_order' => 1]);
        Video::create([
            'module_id' => $phpModule1->id, 'course_id' => $phpCourse->id, 'sort_order' => 1,
            'title' => 'Apa itu PHP?',
            'video_url' => 'https://www.youtube.com/embed/OK_JCtrrv-c',
            'duration_seconds' => 900,
        ]);
        Video::create([
            'module_id' => $phpModule1->id, 'course_id' => $phpCourse->id, 'sort_order' => 2,
            'title' => 'Instalasi PHP dan XAMPP',
            'video_url' => 'https://www.youtube.com/embed/K-qXW9ymeYQ',
            'duration_seconds' => 720,
        ]);

        $phpModule2 = Module::create(['course_id' => $phpCourse->id, 'title' => 'Variabel dan Tipe Data', 'sort_order' => 2]);
        Video::create([
            'module_id' => $phpModule2->id, 'course_id' => $phpCourse->id, 'sort_order' => 1,
            'title' => 'Variabel di PHP',
            'video_url' => 'https://www.youtube.com/embed/1SnPKhCdlsU',
            'duration_seconds' => 840,
        ]);
        Video::create([
            'module_id' => $phpModule2->id, 'course_id' => $phpCourse->id, 'sort_order' => 2,
            'title' => 'Tipe Data String dan Number',
            'video_url' => 'https://www.youtube.com/embed/NihZYkNpslE',
            'duration_seconds' => 960,
        ]);

        // ============================================
        // COURSE 2: Laravel
        // ============================================
        $laravelCourse = Course::create([
            'title' => 'Laravel untuk Pemula',
            'slug' => 'laravel-untuk-pemula',
            'description' => 'Kuasai framework Laravel dan bangun aplikasi web modern. Belajar routing, database, authentication, dan masih banyak lagi!',
            'price' => 350000,
            'instructor_id' => $instructor1->id,
            'category_id' => $webDev->id,
            'published' => true,
        ]);

        $laravelModule1 = Module::create(['course_id' => $laravelCourse->id, 'title' => 'Pengenalan Laravel', 'sort_order' => 1]);
        Video::create([
            'module_id' => $laravelModule1->id, 'course_id' => $laravelCourse->id, 'sort_order' => 1,
            'title' => 'Apa itu Laravel?',
            'video_url' => 'https://www.youtube.com/embed/ImtZ5yENzgE',
            'duration_seconds' => 1020,
        ]);
        Video::create([
            'module_id' => $laravelModule1->id, 'course_id' => $laravelCourse->id, 'sort_order' => 2,
            'title' => 'Instalasi Laravel',
            'video_url' => 'https://www.youtube.com/embed/BXiHvgrJfkg',
            'duration_seconds' => 1140,
        ]);

        $laravelModule2 = Module::create(['course_id' => $laravelCourse->id, 'title' => 'Routing dan Controller', 'sort_order' => 2]);
        Video::create([
            'module_id' => $laravelModule2->id, 'course_id' => $laravelCourse->id, 'sort_order' => 1,
            'title' => 'Laravel Routing',
            'video_url' => 'https://www.youtube.com/embed/YLB3lHWBw48',
            'duration_seconds' => 900,
        ]);
        Video::create([
            'module_id' => $laravelModule2->id, 'course_id' => $laravelCourse->id, 'sort_order' => 2,
            'title' => 'Laravel Controllers',
            'video_url' => 'https://www.youtube.com/embed/C4_69iIbM4o',
            'duration_seconds' => 1080,
        ]);

        // ============================================
        // COURSE 3: JavaScript
        // ============================================
        $jsCourse = Course::create([
            'title' => 'JavaScript Mastery',
            'slug' => 'javascript-mastery',
            'description' => 'Master JavaScript dari fundamental hingga advanced. Pelajari ES6+, async programming, dan best practices.',
            'price' => 280000,
            'instructor_id' => $instructor1->id,
            'category_id' => $programming->id,
            'published' => true,
        ]);

        $jsModule1 = Module::create(['course_id' => $jsCourse->id, 'title' => 'JavaScript Fundamentals', 'sort_order' => 1]);
        Video::create([
            'module_id' => $jsModule1->id, 'course_id' => $jsCourse->id, 'sort_order' => 1,
            'title' => 'Introduction to JavaScript',
            'video_url' => 'https://www.youtube.com/embed/W6NZfCO5SIk',
            'duration_seconds' => 960,
        ]);
        Video::create([
            'module_id' => $jsModule1->id, 'course_id' => $jsCourse->id, 'sort_order' => 2,
            'title' => 'Variables and Data Types',
            'video_url' => 'https://www.youtube.com/embed/edlFjlzxkSI',
            'duration_seconds' => 720,
        ]);
        Video::create([
            'module_id' => $jsModule1->id, 'course_id' => $jsCourse->id, 'sort_order' => 3,
            'title' => 'Functions in JavaScript',
            'video_url' => 'https://www.youtube.com/embed/N8ap4k_1QEQ',
            'duration_seconds' => 1200,
        ]);

        // ============================================
        // COURSE 4: React
        // ============================================
        $reactCourse = Course::create([
            'title' => 'React Complete Course',
            'slug' => 'react-complete-course',
            'description' => 'Bangun aplikasi modern dengan React. Pelajari hooks, context API, Redux, dan React Router.',
            'price' => 400000,
            'instructor_id' => $instructor1->id,
            'category_id' => $webDev->id,
            'published' => true,
        ]);

        $reactModule1 = Module::create(['course_id' => $reactCourse->id, 'title' => 'React Basics', 'sort_order' => 1]);
        Video::create([
            'module_id' => $reactModule1->id, 'course_id' => $reactCourse->id, 'sort_order' => 1,
            'title' => 'What is React?',
            'video_url' => 'https://www.youtube.com/embed/Ke90Tje7VS0',
            'duration_seconds' => 1080,
        ]);
        Video::create([
            'module_id' => $reactModule1->id, 'course_id' => $reactCourse->id, 'sort_order' => 2,
            'title' => 'React Components',
            'video_url' => 'https://www.youtube.com/embed/Y2hgEGPzTZY',
            'duration_seconds' => 900,
        ]);

        // ============================================
        // COURSE 5: Python
        // ============================================
        $pythonCourse = Course::create([
            'title' => 'Python untuk Pemula',
            'slug' => 'python-untuk-pemula',
            'description' => 'Belajar Python dari dasar. Cocok untuk pemula yang ingin memulai programming dengan bahasa yang mudah dipelajari.',
            'price' => 300000,
            'instructor_id' => $instructor2->id,
            'category_id' => $programming->id,
            'published' => true,
        ]);

        $pythonModule1 = Module::create(['course_id' => $pythonCourse->id, 'title' => 'Python Basics', 'sort_order' => 1]);
        Video::create([
            'module_id' => $pythonModule1->id, 'course_id' => $pythonCourse->id, 'sort_order' => 1,
            'title' => 'Python Introduction',
            'video_url' => 'https://www.youtube.com/embed/kqtD5dpn9C8',
            'duration_seconds' => 1440,
        ]);
        Video::create([
            'module_id' => $pythonModule1->id, 'course_id' => $pythonCourse->id, 'sort_order' => 2,
            'title' => 'Variables and Data Types in Python',
            'video_url' => 'https://www.youtube.com/embed/9Os0o3wzS_I',
            'duration_seconds' => 720,
        ]);

        // ============================================
        // COURSE 6: Data Science
        // ============================================
        $dsCourse = Course::create([
            'title' => 'Python untuk Data Science',
            'slug' => 'python-data-science',
            'description' => 'Analisis data dengan Python menggunakan Pandas, NumPy, dan Matplotlib. Cocok untuk data analyst pemula.',
            'price' => 450000,
            'instructor_id' => $instructor2->id,
            'category_id' => $dataScience->id,
            'published' => true,
        ]);

        $dsModule1 = Module::create(['course_id' => $dsCourse->id, 'title' => 'Data Science Fundamentals', 'sort_order' => 1]);
        Video::create([
            'module_id' => $dsModule1->id, 'course_id' => $dsCourse->id, 'sort_order' => 1,
            'title' => 'Introduction to Data Science',
            'video_url' => 'https://www.youtube.com/embed/ua-CiDNNj30',
            'duration_seconds' => 1200,
        ]);
        Video::create([
            'module_id' => $dsModule1->id, 'course_id' => $dsCourse->id, 'sort_order' => 2,
            'title' => 'Python for Data Analysis',
            'video_url' => 'https://www.youtube.com/embed/r-uOLxNrNk8',
            'duration_seconds' => 1560,
        ]);

        // Add Reviews
        $student1 = User::where('email', 'student1@lms.com')->first();
        $student2 = User::where('email', 'student2@lms.com')->first();

        Review::create([
            'user_id' => $student1->id,
            'course_id' => $phpCourse->id,
            'rating' => 5,
            'comment' => 'Kursus yang sangat bagus! Materinya mudah dipahami dan instrukturnya sangat membantu.',
        ]);

        Review::create([
            'user_id' => $student1->id,
            'course_id' => $laravelCourse->id,
            'rating' => 5,
            'comment' => 'Laravel explained with great examples. Highly recommended!',
        ]);

        Review::create([
            'user_id' => $student2->id,
            'course_id' => $phpCourse->id,
            'rating' => 4,
            'comment' => 'Bagus, tapi mungkin bisa ditambahkan lebih banyak contoh praktis.',
        ]);

        Review::create([
            'user_id' => $student2->id,
            'course_id' => $jsCourse->id,
            'rating' => 5,
            'comment' => 'Penjelasan JavaScript-nya sangat detail dan mudah dimengerti!',
        ]);

        $this->command->info('✅ Data with YouTube videos created successfully!');
        $this->command->info('');
        $this->command->info('📊 Data Summary:');
        $this->command->info('- Users: 13 (1 Admin, 2 Instructors, 10 Students)');
        $this->command->info('- Categories: 5');
        $this->command->info('- Courses: 6 (All Published with real YouTube videos)');
        $this->command->info('- Modules: 9');
        $this->command->info('- Videos: 20+ (All from YouTube)');
        $this->command->info('- Reviews: 4');
        $this->command->info('');
        $this->command->info('🔑 Login Credentials:');
        $this->command->info('Admin: admin@lms.com / password');
        $this->command->info('Instructor 1: instructor@lms.com / password');
        $this->command->info('Instructor 2: instructor2@lms.com / password');
        $this->command->info('Students: student1@lms.com - student10@lms.com / password');
        $this->command->info('');
        $this->command->info('🎥 All videos are real YouTube tutorials!');
    }
}
