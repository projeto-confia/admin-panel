<?php

namespace App\Http\Controllers;

use App\Repositories\Automata\CuratorshipRepository;
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
}
