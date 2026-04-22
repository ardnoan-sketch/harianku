<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotebookItem extends Model
{
    use HasFactory;

    protected $table = 'ar_notebook_items';

    protected $fillable = [
        'notebook_id',
        'title',
        'content',
    ];

    public function notebook()
    {
        return $this->belongsTo(Notebook::class);
    }
}
