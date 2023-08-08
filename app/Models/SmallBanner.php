<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmallBanner extends Model
{
    protected $table = 'small_banner';

    protected $fillable=['title','slug','description','photo','status','smalltitle'];
}
