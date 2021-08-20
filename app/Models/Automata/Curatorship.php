<?php

namespace App\Models\Automata;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Curatorship extends Model
{
    use HasFactory;

    protected $connection = 'detectenv';
    protected $table = 'curatorship';
    protected $primaryKey = 'id_curatorship';
    public $timestamps = false;

    protected $casts = [
        'is_news' => 'boolean',
        'is_similar' => 'boolean',
        'is_fake_news' => 'boolean',
        'is_curated' => 'boolean',
        'is_processed' => 'boolean',
    ];

    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class, 'id_news', 'id_news');
    }
}
