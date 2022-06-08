<?php

namespace App\Http\Controllers;

use App\Models\Automata\ActionLog;
use App\Models\Automata\ActionType;
use App\Trait\IntervalNavigable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class InterventionReportController extends Controller
{
    use IntervalNavigable;

    public function index(Request $request)
    {
//        dd($request->all());
        $this->handleIntervalNavigation($request);

        $defaultDates = [
            'start' => $request->start_date ?: Carbon::now()->subDays(6)->toDateString(),
            'end' => $request->end_date ?: Carbon::now()->toDateString(),
        ];

        $actionLogs = ActionLog::query()
            ->with(['news', 'actionType'])
            ->when(
                $request->news_text_or_code,
                fn (Builder $query) => $query->whereHas(
                    'news',
                    fn(Builder $newsQuery) => $newsQuery
                        ->where('id_news', $request->news_text_or_code)
                        ->orWhere('text_news', 'like', $request->news_text_or_code)
                )
            )
            ->when($request->action_type, fn(Builder $query) => $query->where('id_action', $request->action_type))
            ->when(
                $request->start_date,
                fn($query) => $query->whereDate('datetime_log', '>=', $request->start_date),
                fn($query) => $query->whereDate('datetime_log', '>=', data_get($defaultDates, 'start'))
            )
            ->when(
                $request->end_date,
                fn($query) => $query->whereDate('datetime_log', '<=', $request->end_date),
                fn ($query) => $query->whereDate('datetime_log', '<=', data_get($defaultDates, 'end'))
            )
            ->orderBy('datetime_log', 'desc')
            ->orderBy('id_news')
            ->paginate()
            ->withQueryString();;

        $actionTypes = ActionType::query()
            ->select(['id_action', 'name_action'])
            ->get()
            ->map(
                fn(ActionType $actionType) => (['label' => $actionType->name_action, 'value' => $actionType->id_action])
            );

        $request->flash();
        return view(
            'pages.intervention.index',
            compact('actionLogs', 'actionTypes', 'defaultDates')
        );
    }
}
