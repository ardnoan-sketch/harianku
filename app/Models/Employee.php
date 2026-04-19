<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'ar_employees';

    protected $fillable = [
        'name',
        'email',
        'position',
        'department',
        'join_date',
        'base_salary',
        'status',
    ];

    protected $casts = [
        'join_date' => 'date',
        'base_salary' => 'decimal:2',
    ];
}
