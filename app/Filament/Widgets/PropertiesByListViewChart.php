<?php

namespace App\Filament\Widgets;

use App\Models\ListView;
use App\Models\Property;
use Filament\Widgets\ChartWidget;

class PropertiesByListViewChart extends ChartWidget
{
    protected static ?string $heading = 'Properties By List View Chart';
    protected static ?string $description = 'Properties By List View Chart';
    protected static ?int $sort = 5;
    protected static ?string $maxHeight = '300px';
    protected static string $color = 'secondary';

    protected function getData(): array
    {
        $types= ListView::pluck('name','id')->toArray();
        $data = [];
        foreach ($types as $key => $type) {
            $data[] = Property::where('list_view_id', $key)->count();
        }
         return [
            'datasets' => [
                [
                    'label' => 'Properties',
                    'data' => $data,
                    'backgroundColor' => get_main_colors(),
                ]
            ],
            'labels' => array_values($types),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
