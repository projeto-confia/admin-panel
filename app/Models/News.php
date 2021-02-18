<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $connection = 'detectenv';
    protected $table = 'news';
    protected $primaryKey = 'id_news';
    public $timestamps = false;
}
