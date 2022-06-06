<?php

namespace App\Models\Automata;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ActionLog extends Model
{
    use HasFactory;

    public function news(): HasOne
    {
        return $this->hasOne(News::class, 'id_news', 'id_news');
    }

    public function actionType(): HasOne
    {
        return $this->hasOne(ActionType::class, 'id_action', 'id_action');
    }
}
