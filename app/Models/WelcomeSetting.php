<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WelcomeSetting extends Model
{
    protected $fillable = [
        'hero_title',
        'hero_subtitle',
        'hero_description',
        'hero_image',
        'search_title',
        'search_placeholder',
        'stats_students',
        'stats_courses',
        'stats_rating',
        'feature_1_title',
        'feature_1_description',
        'feature_1_icon',
        'feature_2_title',
        'feature_2_description',
        'feature_2_icon',
        'feature_3_title',
        'feature_3_description',
        'feature_3_icon',
        'cta_title',
        'cta_description',
        'cta_button_text',
        'email',
        'phone',
        'address',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'linkedin_url',
    ];
}
