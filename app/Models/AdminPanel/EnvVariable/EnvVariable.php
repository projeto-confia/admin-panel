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
 * @property bool $updated
 */
class EnvVariable extends Model
{
    use HasFactory;

    protected $table = 'env_variable';

    const TYPES = [
        'string' => 'Texto',
//        'float' => 'Número flutuante',
//        'int' => 'Número',
//        'array[string]' => 'Lista de nomes',
//        'array[int]' => 'Lista de números',
//        'array[float]' => 'Lista de números flutuantes',
//        'bool' => 'Verdadeiro ou falso'
    ];
}
