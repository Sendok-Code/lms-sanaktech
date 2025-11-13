@props([
    'title' => null,
    'description' => null,
    'keywords' => [],
    'image' => null,
    'url' => null,
    'type' => 'website',
    'author' => null,
    'publishedTime' => null,
    'modifiedTime' => null,
])

@php
    $pageTitle = App\Helpers\SeoHelper::generateTitle($title);
    $pageDescription = App\Helpers\SeoHelper::generateDescription($description);
    $pageKeywords = App\Helpers\SeoHelper::generateKeywords($keywords);
    $canonicalUrl = App\Helpers\SeoHelper::generateCanonicalUrl($url);
    $ogImage = App\Helpers\SeoHelper::generateOgImage($image);
    $siteName = config('app.name', 'LMS Platform');
@endphp

<!-- Primary Meta Tags -->
<title>{{ $pageTitle }}</title>
<meta name="title" content="{{ $pageTitle }}">
<meta name="description" content="{{ $pageDescription }}">
<meta name="keywords" content="{{ $pageKeywords }}">
<meta name="author" content="{{ $author ?? $siteName }}">
<meta name="robots" content="index, follow">
<meta name="language" content="Indonesian">
<meta name="revisit-after" content="7 days">

<!-- Canonical URL -->
<link rel="canonical" href="{{ $canonicalUrl }}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="{{ $type }}">
<meta property="og:url" content="{{ $canonicalUrl }}">
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $pageDescription }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:locale" content="id_ID">

@if($publishedTime)
<meta property="article:published_time" content="{{ $publishedTime }}">
@endif

@if($modifiedTime)
<meta property="article:modified_time" content="{{ $modifiedTime }}">
@endif

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ $canonicalUrl }}">
<meta property="twitter:title" content="{{ $pageTitle }}">
<meta property="twitter:description" content="{{ $pageDescription }}">
<meta property="twitter:image" content="{{ $ogImage }}">

<!-- Additional SEO -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="theme-color" content="#F97316">
