<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * الخصائص التي يمكن تعيينها بشكل جماعي
     */
    protected $fillable = [
        'site_name',
        'site_logo',
        'site_favicon',
        'logo_width',
        'logo_height',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'youtube_url'
    ];
}
