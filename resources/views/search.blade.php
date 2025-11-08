<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - {{ $query }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Header */
        .header {
            background: white;
            padding: 1.5rem 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .header h1 {
            font-size: 1.5rem;
            color: #667eea;
            margin-bottom: 1rem;
        }

        .search-form {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .search-input {
            flex: 1;
            padding: 0.875rem 1.25rem;
            border: 2px solid #e2e8f0;
            border-radius: 50px;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .search-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .search-btn {
            padding: 0.875rem 2rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .search-btn:hover {
            transform: translateY(-2px);
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 1.5rem;
            transition: gap 0.3s;
        }

        .back-link:hover {
            gap: 0.75rem;
        }

        /* Results Info */
        .results-info {
            background: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .results-info h2 {
            font-size: 1.25rem;
            color: #333;
        }

        .query-highlight {
            color: #667eea;
            font-weight: bold;
        }

        /* Course Grid */
        .course-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .course-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
        }

        .course-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .course-content {
            padding: 1.5rem;
        }

        .course-category {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background: #e0e7ff;
            color: #667eea;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .course-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 0.5rem;
            line-height: 1.4;
        }

        .course-description {
            font-size: 0.875rem;
            color: #666;
            margin-bottom: 1rem;
            line-height: 1.6;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .course-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
        }

        .course-instructor {
            font-size: 0.875rem;
            color: #666;
        }

        .course-price {
            font-size: 1.25rem;
            font-weight: 700;
            color: #667eea;
        }

        .course-price.free {
            color: #10b981;
        }

        /* No Results */
        .no-results {
            background: white;
            padding: 3rem 2rem;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .no-results svg {
            width: 80px;
            height: 80px;
            color: #cbd5e1;
            margin-bottom: 1.5rem;
        }

        .no-results h3 {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .no-results p {
            color: #666;
            margin-bottom: 1.5rem;
        }

        .browse-btn {
            display: inline-block;
            padding: 0.875rem 2rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: transform 0.2s;
        }

        .browse-btn:hover {
            transform: translateY(-2px);
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 2rem;
        }

        .pagination a,
        .pagination span {
            padding: 0.5rem 1rem;
            background: white;
            color: #667eea;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .pagination a:hover {
            background: #667eea;
            color: white;
        }

        .pagination .active {
            background: #667eea;
            color: white;
        }

        @media (max-width: 768px) {
            .course-grid {
                grid-template-columns: 1fr;
            }

            .search-form {
                flex-direction: column;
            }

            .search-btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="/" class="back-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back to Home
        </a>

        <!-- Search Header -->
        <div class="header">
            <h1>{{ $settings->search_title ?? 'Search Courses' }}</h1>
            <form action="{{ route('search') }}" method="GET" class="search-form">
                <input type="text" name="q" value="{{ $query }}" placeholder="{{ $settings->search_placeholder ?? 'Search courses, topics, or instructors...' }}" class="search-input" required>
                <button type="submit" class="search-btn">Search</button>
            </form>
        </div>

        <!-- Results Info -->
        <div class="results-info">
            <h2>
                Found <strong>{{ $courses->total() }}</strong>
                {{ $courses->total() == 1 ? 'course' : 'courses' }}
                for "<span class="query-highlight">{{ $query }}</span>"
            </h2>
        </div>

        @if($courses->count() > 0)
            <!-- Course Grid -->
            <div class="course-grid">
                @foreach($courses as $course)
                    <div class="course-card">
                        @if($course->thumbnail)
                            <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}" class="course-image">
                        @else
                            <div class="course-image"></div>
                        @endif

                        <div class="course-content">
                            <span class="course-category">{{ $course->category->name ?? 'Uncategorized' }}</span>
                            <h3 class="course-title">{{ $course->title }}</h3>
                            <p class="course-description">{{ Str::limit($course->description, 100) }}</p>

                            <div class="course-footer">
                                <div class="course-instructor">
                                    By {{ $course->instructor->user->name ?? 'Unknown' }}
                                </div>
                                <div class="course-price {{ $course->price == 0 ? 'free' : '' }}">
                                    @if($course->price == 0)
                                        FREE
                                    @else
                                        Rp {{ number_format($course->price, 0, ',', '.') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="pagination">
                {{ $courses->appends(['q' => $query])->links() }}
            </div>
        @else
            <!-- No Results -->
            <div class="no-results">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <h3>No courses found</h3>
                <p>We couldn't find any courses matching "{{ $query }}". Try searching with different keywords.</p>
                <a href="/" class="browse-btn">Browse All Courses</a>
            </div>
        @endif
    </div>
</body>
</html>
