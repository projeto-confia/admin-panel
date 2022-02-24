<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnvVariable extends Model
{
    use HasFactory;

    protected $table = 'env_variable';
}
