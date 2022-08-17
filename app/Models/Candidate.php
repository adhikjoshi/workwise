<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;
    protected $table = 'candidate';
    protected $fillable = [
        'title',
        'name',
        'type_of_employment',
        'location',
        'last_active',
        'skills',
    ];

}
