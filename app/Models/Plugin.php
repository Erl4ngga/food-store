<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plugin extends Model
{
    protected $table = 'plugin';
    protected $fillable=['name','category','status','is_featured'];
}
