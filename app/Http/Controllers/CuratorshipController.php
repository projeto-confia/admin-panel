<?php

namespace App\Http\Controllers;

use App\Http\Requests\Curatorship\CurateRequest;
use App\Models\Automata\Curatorship;
use App\Models\Automata\DTO\CuratorshipDTO;
use App\Models\Automata\DTO\CurateDTO;
use App\Repositories\Automata\CuratorshipRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CuratorshipController extends Controller
{
    public function __construct(private CuratorshipRepository $curatorshipRepository)
    {
    }

    public function index(): View
    {
        $curatorships = $this->curatorshipRepository->newsForCuratorshipPaginated();
        return view('pages.curatorship.index', compact('curatorships'));
    }

    public function edit(Curatorship $curatorship): View
    {
        return view('pages.curatorship.edit', ['curatorshipDTO'=> new CuratorshipDTO($curatorship)]);
    }

    public function update(CurateRequest $request, Curatorship $curatorship): RedirectResponse
    {
        try {
            $curateDTO = new CurateDTO(
                isNews: $request->is_news,
                isFake: $request->is_fake_news,
                isSimilar: $request->is_similar,
                textNote: $request->text_note
            );

            $this->curatorshipRepository->curate($curatorship, $curateDTO);

            $curatorshipDTO = $this->curatorshipRepository->getNextFrom($curatorship->id_curatorship);

            return redirect(route('curadoria.edit', [$curatorshipDTO->getId()]));
        } catch (ModelNotFoundException) {
            return redirect(route('curadoria.index'));
        }
    }
}
