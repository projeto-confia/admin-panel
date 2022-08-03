<?php

namespace App\Services;

use App\Models\Automata\News;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class NewsService
{
    public function fakeNewsByTurn(Collection $newsChecked): array
    {
        $turns = collect([
            'dawn' => [
                'starts' => '00:00',
                'ends' => '05:59'
            ],
            'morning' => [
                'starts' => '06:00',
                'ends' => '11:59'
            ],
            'afternoon' => [
                'starts' => '12:00',
                'ends' => '17:59'
            ],
            'night' => [
                'starts' => '18:00',
                'ends' => '23:59'
            ],
        ]);

        $newsByDate = $this->groupByDate($newsChecked);

        $newsWithTurnCount = array_map(function (array $news) use ($turns) {
            return $this->getCountGroupedByTurn($news, $turns);
        }, $newsByDate);

        $dates = array_keys($newsWithTurnCount);

        $countByTurn = array_reduce(
            $newsWithTurnCount,
            function (array $carry, array $turns): array {
                array_walk($carry, function (array &$carryTurn, string $key) use ($turns) {
                    $carryTurn[] = $turns[$key];
                });
                return $carry;
            },
            ['dawn' => [], 'morning' => [], 'afternoon' => [], 'night' => []]
        );

        return compact('dates', 'countByTurn');
    }

    /**
     * @param Collection $newsChecked
     * @return array
     */
    private function groupByDate(Collection $newsChecked): array
    {
        return $newsChecked->reduce(function ($carry, News $news) {
            $date = $news->datetime_publication->format('d/m/Y');
            $carry[$date][] = $news;
            return $carry;
        }, []);
    }

    /**
     * @param mixed $news
     * @param Collection $turns
     * @return int[]
     */
    private function getCountGroupedByTurn(array $news, Collection $turns): array
    {
        return array_reduce(
            $news,
            function (array $carry, News $news) use ($turns) {
                foreach ($turns as $turnName => $ranges) {
                    $newsTime = Carbon::createFromTimeString($news->datetime_publication->format('H:i'));
                    $starts = Carbon::createFromTimeString(data_get($ranges, 'starts'));
                    $ends = Carbon::createFromTimeString(data_get($ranges, 'ends'));

                    if ($newsTime->between($starts, $ends)) {
                        $carry[$turnName]++;
                        return $carry;
                    }
                }
                $carry['none'][] = $news;
                return $carry;
            },
            ['dawn' => 0, 'morning' => 0, 'afternoon' => 0, 'night' => 0]
        );
    }
}
