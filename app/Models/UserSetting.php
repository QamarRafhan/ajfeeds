<?php

namespace App\Models;
use App\Enums\ThemeMode;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    protected $fillable = ['user_id', 'theme_mode', 'sidebar_type'];

    protected $casts = [
        'theme_mode' => ThemeMode::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
