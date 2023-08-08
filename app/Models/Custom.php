<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Custom extends Model
{
    protected $table = 'custom';
    protected $fillable=['name','footer1','footer2','footer3','footer4'];
}
