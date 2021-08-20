<?php

namespace App\Models\Automata;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CheckingOutcome extends Model
{
    use HasFactory;

    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class, 'id_news');
    }

    public function trustedAgency(): BelongsTo
    {
        $this->belongsTo(TrustedAgency::class, 'id_trusted_agency');
    }
}
