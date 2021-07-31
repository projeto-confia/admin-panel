<?php

namespace App\Trait;

use Carbon\Carbon;
use Illuminate\Http\Request;

trait IntervalNavigable
{
    private function handleIntervalNavigation(Request $request)
    {
        if (!$request->next_interval && !$request->previous_interval) {
            return;
        }

        $request->validate(
            [
                'start_date' => 'required|date',
                'end_date' => 'required|date',
            ],
            [
                'start_date.required' => 'A data inicial é requerida para navegar por intervalos',
                'end_date.required' => 'A data final é requerida para navegar por intervalos',
            ]
        );

        /** @var Carbon */
        $startDate = Carbon::parse($request->start_date);
        /** @var Carbon */
        $endDate = Carbon::parse($request->end_date);

        $differenceInDays = $startDate->diffInDays($endDate) + 1;

        if ($request->next_interval) {
            $startDate->addDays($differenceInDays);
            $endDate->addDays($differenceInDays);
        }

        if ($request->previous_interval) {
            $startDate->subDays($differenceInDays);
            $endDate->subDays($differenceInDays);
        }

        $request->merge([
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
        ]);
    }
}
