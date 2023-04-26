<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoSetting extends Model
{
    public $table = 'seo_settings';

    protected $fillable = [
        'keyword',
        'author',
        'revisit',
        'sitemap_link',
        'description',
        'created_at',
        'updated_at',
    ];
}
