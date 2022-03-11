<?php

namespace App\Models\AdminPanel\EnvVariable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $value
 * @property string $default_value
 * @property string $type
 * @property string $name
 * @property string $description
 */
class EnvVariable extends Model
{
    use HasFactory;

    protected $table = 'env_variable';
}
