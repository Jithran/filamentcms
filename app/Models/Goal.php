<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goal extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_completed',
        'due_date',
    ];
}
