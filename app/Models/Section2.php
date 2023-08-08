<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section2 extends Model
{
    use HasFactory;
    protected $table = 'section2';
    protected $fillable=['title','name'];
}
