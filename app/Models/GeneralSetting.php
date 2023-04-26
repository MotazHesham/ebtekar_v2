<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{

    public $table = 'general_settings';

    protected $fillable = [
        'logo',
        'site_name',
        'address',
        'description',
        'phone_number',
        'email',
        'facebook',
        'instagram',
        'twitter',
        'telegram',
        'linkedin',
        'whatsapp',
        'youtube',
        'google_plus',
        'welcome_message',
        'photos',
        'video_instructions',
        'delivery_system',
        'borrow_password',
        'designer_id',
        'preparer_id',
        'manifacturer_id',
        'send_to_delivery_id',
        'created_at',
        'updated_at',
    ];
}
