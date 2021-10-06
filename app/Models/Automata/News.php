<?php

namespace App\Models\Automata;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property string text_news
 * @property Carbon datetime_publication
 * @method static predicted()
 * @method static checked()
 * @method static notChecked()
 */
class News extends Model
{
    use HasFactory;

    protected $casts = [
        'datetime_publication' => 'datetime',
    ];

    public function scopePredicted(Builder $builder): Builder
    {
        return $builder
            ->whereNotNull('classification_outcome')
            ->whereNotNull('prob_classification');
    }

    public function scopeChecked(Builder $builder): Builder
    {
        return $builder
            ->whereNotNull('classification_outcome')
            ->whereNotNull('prob_classification')
            ->whereNotNull('ground_truth_label');
    }

    public function scopeNotChecked(Builder $builder): Builder
    {
        return $builder
            ->whereNotNull('classification_outcome')
            ->whereNotNull('prob_classification')
            ->whereNull('ground_truth_label');
    }

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

    public function curatorship(): HasOne
    {
        return $this->hasOne(Curatorship::class, 'id_news', 'id_news');
    }
}
