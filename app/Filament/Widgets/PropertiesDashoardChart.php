<?php

namespace App\Filament\Widgets;

use App\Models\Property;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
class PropertiesDashoardChart extends ChartWidget
{
     protected static ?string $heading = 'Properties Chart';

    protected static ?string $description = 'Properties Chart';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $year = (int) ($this->filter ?? date('Y'));
        $data = Trend::model(Property::class)
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
                    'backgroundColor'=> 'rgba(74, 222, 128, 0.2)',
                    'borderColor'=> 'rgba(74, 222, 128, 1)',
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
