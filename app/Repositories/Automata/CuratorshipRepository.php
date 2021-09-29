<?php


namespace App\Repositories\Automata;


use App\Models\Automata\Curatorship;
use App\Models\Automata\DTO\CurateDTO;
use App\Models\Automata\DTO\CuratorshipDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CuratorshipRepository
{
    public function newsForCuratorshipPaginated(): LengthAwarePaginator
    {
        return Curatorship::available()
            ->with(['news', 'agencyCheckedNews'])
            ->paginate()
            ->through(fn(Curatorship $curatorship) => new CuratorshipDTO($curatorship));
    }

    public function curate(Curatorship $curatorship, CurateDTO $curateDTO)
    {
        $curatorship->is_curated = true;
        $curatorship->text_note = $curateDTO->getTextNote();
        $curatorship->is_similar = $curateDTO->isSimilar();

        if ($curatorship->hasAgencyCheckedNews() && $curateDTO->isSimilar()) {
            $curatorship->is_fake_news = true;
            $curatorship->save();
            return;
        }

        $curatorship->is_news = $curateDTO->isNews();
        if ($curateDTO->isNotNews()) {
            $curatorship->is_processed = true;
            $curatorship->save();
            return;
        }

        $curatorship->is_fake_news = $curateDTO->isFake();
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
        $curatorship = Curatorship::available()
            ->where('id_curatorship', '!=', $idCuratorship)
            ->first();

        return new CuratorshipDTO($curatorship);
    }
}
