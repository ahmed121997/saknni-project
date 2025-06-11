<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
class UsersDashoardChart extends ChartWidget
{
    protected static ?string $heading = 'Users Chart';

    protected static ?string $description = 'Users Chart';

    protected static ?int $sort = 2;


    protected function getData(): array
    {
        $year = (int) ($this->filter ?? date('Y'));
        $data = Trend::model(User::class)
            ->between(
               start: now()->setYear($year)->startOfYear(),
                end: now()->setYear($year)->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'User registered',
                    'fill' => true,
                    'tension' => 0.4,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => Carbon::parse($value->date)->format('M')),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getFilters(): ?array
    {
        $currentYear = now()->year;
        for ($i = 0; $i <= 5; $i++) {
            $years[$currentYear - $i] = $currentYear - $i;
        }
        return $years;
    }


}
