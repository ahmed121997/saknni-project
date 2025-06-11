<?php

namespace App\Filament\Widgets;

use App\Models\Property;
use App\Models\TypeFinish;
use Filament\Widgets\ChartWidget;

class PropertiesByTypeFinishChart extends ChartWidget
{
     protected static ?string $heading = 'Properties By Type Finish Chart';
    protected static ?string $description = 'Properties By Type Finish Chart';
    protected static ?int $sort = 6;
    protected static ?string $maxHeight = '300px';
    protected static string $color = 'warning';

    protected function getData(): array
    {
        $types= TypeFinish::pluck('name','id')->toArray();
        $data = [];
        foreach ($types as $key => $type) {
            $data[] = Property::where('type_finish_id', $key)->count();
        }
         return [
            'datasets' => [
                [
                    'label' => 'Properties',
                    'data' => $data,
                    'backgroundColor' =>  get_main_colors()
                ],
            ],
            'labels' => array_values($types),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
