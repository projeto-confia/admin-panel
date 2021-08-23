<?php


namespace App\Repositories\Automata;


use App\Models\Automata\Curatorship;
use App\Models\Automata\DTO\CurateDTO;
use App\Models\Automata\DTO\CuratorshipDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
            ->through(fn(Curatorship $curatorship) => new CuratorshipDTO($curatorship));
    }

    public function curate(Curatorship $curatorship, CurateDTO $curateDTO)
    {
        $curatorship->is_news = $curateDTO->isNews();
        $curatorship->text_note = $curateDTO->getTextNote();
        $curatorship->is_curated = true;

        if ($curatorship->hasAgencyCheckedNews()) {
            $curatorship->is_similar = $curateDTO->isSimilar();
        }

        if ($curateDTO->isNews()) {
            $curatorship->is_fake = $curateDTO->isFake();
            $curatorship->save();
            return;
        }

        $curatorship->is_processed = true;
        $curatorship->is_curated = true;
        $curatorship->save();
    }

    /**
     * Retrieve next curatorship register based on the reference
     * @param int $idCuratorship
     * @return CuratorshipDTO
     * @throws ModelNotFoundException
     */
    public function getNextFrom(int $idCuratorship): CuratorshipDTO
    {
        /** @var Curatorship $curatorship*/
        $curatorship = Curatorship::where('id',  '>', $idCuratorship)->firstOrFail();
        return new CuratorshipDTO($curatorship);
    }
}
