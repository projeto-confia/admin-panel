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
        $curatorship->is_news = $curateDTO->isNews();
        $curatorship->text_note = $curateDTO->getTextNote();
        $curatorship->is_curated = true;
        $curatorship->is_processed = $curateDTO->isNotNews();

        if ($curatorship->hasAgencyCheckedNews()) {
            $curatorship->is_similar = $curateDTO->isSimilar();
        }

        if ($curateDTO->isNews()) {
            $curatorship->is_fake_news = $curateDTO->isFake();
        }

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
