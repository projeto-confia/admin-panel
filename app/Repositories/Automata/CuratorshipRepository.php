<?php


namespace App\Repositories\Automata;


use App\Models\Automata\Curatorship;
use App\Models\Automata\DTO\CuratorshipDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CuratorshipRepository
{
    /** @noinspection PhpUndefinedMethodInspection */
    public function newsForCuratorshipPaginated(): LengthAwarePaginator
    {
        return Curatorship::query()
            ->with(['news', 'agencyCheckedNews'])
            ->join('news', 'news.id_news', '=', 'curatorship.id_news')
            ->where('is_curated', false)
            ->where('is_processed', false)
            ->orderBy('news.datetime_publication')
            ->paginate()
            ->through(fn (Curatorship $curatorship) => new CuratorshipDTO($curatorship));
    }
}
