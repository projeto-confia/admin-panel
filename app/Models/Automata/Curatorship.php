<?php

namespace App\Models\Automata;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int id_curatorship
 * @property ?int id_news_checked
 * @property News news
 * @property ?AgencyNewsChecked agencyCheckedNews
 */
class Curatorship extends Model
{
    use HasFactory;

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

    /**
     * Similar to related news, agency checked news.
     * @return BelongsTo
     */
    public function agencyCheckedNews(): BelongsTo
    {
        return $this->belongsTo(AgencyNewsChecked::class, 'id_news_checked', 'id_news_checked');
    }
}
