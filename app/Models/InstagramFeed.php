<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstagramFeed extends Model
{
    use HasFactory;
    protected $table = 'instagram_feed';
    protected $fillable=['name','instagram','photo','status'];
}
