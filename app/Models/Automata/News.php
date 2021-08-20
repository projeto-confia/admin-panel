<?php

namespace App\Models\Automata;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class News extends Model
{
    use HasFactory;

    protected $casts = [
        'datetime_publication' => 'datetime',
    ];

    public function similarNewsPublishedByAgency(): BelongsToMany
    {
        return $this->belongsToMany(
            AgencyNewsChecked::class,
            'similarity_checking_outcome',
            'id_news',
            'id_similarity_checking_outcome',
            'id_news',
        );
    }
}
