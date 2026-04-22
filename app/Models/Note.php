<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $table = 'ar_notes';

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
