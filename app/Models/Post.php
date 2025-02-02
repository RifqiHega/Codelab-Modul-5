<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Post extends Model
{
    use HasFactory;
    /**
     * fillable
     * 
     * @var array
     */

     protected $fillable=[
        'task',
        'category',
        'date',
        'time',
     ];

}
