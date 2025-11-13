<?php

namespace App\Helpers;

class SeoHelper
{
    public static function generateTitle($pageTitle = null, $withSiteName = true)
    {
        $siteName = config('app.name', 'LMS Platform');
        
        if (!$pageTitle) {
            return $siteName . ' - Platform Pembelajaran Online Terbaik';
        }
        
        return $withSiteName ? $pageTitle . ' - ' . $siteName : $pageTitle;
    }

    public static function generateDescription($description = null)
    {
        return $description ?? 'Platform pembelajaran online terbaik dengan ribuan kursus berkualitas. Belajar programming, design, bisnis, dan lebih banyak lagi dengan instruktur berpengalaman.';
    }

    public static function generateKeywords($keywords = [])
    {
        $defaultKeywords = [
            'kursus online',
            'belajar online',
            'pembelajaran online',
            'lms',
            'platform belajar',
            'kursus programming',
            'kursus design',
            'sertifikat online'
        ];

        $allKeywords = array_merge($defaultKeywords, $keywords);
        return implode(', ', array_unique($allKeywords));
    }

    public static function generateCanonicalUrl($url = null)
    {
        return $url ?? url()->current();
    }

    public static function generateOgImage($image = null)
    {
        return $image ?? asset('images/og-default.jpg');
    }
}
