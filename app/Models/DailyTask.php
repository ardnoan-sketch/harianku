<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyTask extends Model
{
    use HasFactory;

    protected $table = 'ar_daily_tasks';

    protected $fillable = [
        'daily_log_id',
        'type',
        'title',
        'is_completed',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
    ];

    public function dailyLog()
    {
        return $this->belongsTo(DailyLog::class, 'daily_log_id');
    }
}
