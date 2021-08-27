<?php

namespace App\Models\Automata;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class AgencyNewsChecked
 * Represents news published by a trusted agency
 * @property string publication_url
 * @property string publication_title
 * @property TrustedAgency trustedAgency
 * @package App\Models\Automata
 */
class AgencyNewsChecked extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_news_checked';

    public function trustedAgency(): BelongsTo
    {
        return $this->belongsTo(TrustedAgency::class, 'id_trusted_agency');
    }

    public function similarNews(): BelongsToMany
    {
        return $this->belongsToMany(
            News::class,
            'similarity_checking_outcome',
            'id_similarity_checking_outcome',
            'id_news',
            'id_news_checked',
        );
    }
}
