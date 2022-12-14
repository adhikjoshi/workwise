<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artical extends Model
{
    use HasFactory;
    protected $table = 'articles';

    protected $fillable = [
        'author',
        'content',
        'name',
        'tags',
    ];

}
