<?php

namespace App\Models\Automata;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int id_curatorship
 * @property ?int id_news_checked
 * @property News news
 * @property ?AgencyNewsChecked agencyCheckedNews
 * @property bool|mixed|null is_similar
 * @property bool is_news
 * @property bool is_fake_news
 * @property bool is_curated
 * @property bool is_processed
 * @property string|null text_note
 * @method static Builder available()
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

    public function hasAgencyCheckedNews(): bool
    {
        return ! is_null($this->id_news_checked);
    }

    /**
     * @param  Builder $query
     * @return Builder
     */
    public function scopeAvailable(Builder $query): Builder
    {
        return $query
            ->join('news', 'news.id_news', '=', 'curatorship.id_news')
            ->where('is_curated', false)
            ->where('is_processed', false)
            ->orderBy('news.datetime_publication');
    }

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
