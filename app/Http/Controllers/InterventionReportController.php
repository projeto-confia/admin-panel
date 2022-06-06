<?php

namespace App\Http\Controllers;

use App\Models\Automata\ActionLog;

class InterventionReportController extends Controller
{
    public function index()
    {
        $interventions = ActionLog::with(['news', 'actionType'])->paginate();
        dd($interventions);
    }
}
