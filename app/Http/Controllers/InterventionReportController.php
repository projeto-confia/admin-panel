<?php

namespace App\Http\Controllers;

use App\Models\Automata\ActionLog;
use App\Models\Automata\ActionType;

class InterventionReportController extends Controller
{
    public function index()
    {
        $actionLogs = ActionLog::with(['news', 'actionType'])->paginate();
        $actionTypes = ActionType::query()
            ->select(['id_action', 'name_action'])
            ->get()
            ->map(
                fn(ActionType $actionType) => (['label' => $actionType->name_action, 'value' => $actionType->id_action])
            );

        return view('pages.intervention.index', compact('actionLogs', 'actionTypes'));
    }
}
