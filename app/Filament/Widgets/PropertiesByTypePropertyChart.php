<?php

namespace App\Filament\Widgets;

use App\Models\Property;
use App\Models\TypeProperty;
use Filament\Widgets\ChartWidget;

class PropertiesByTypePropertyChart extends ChartWidget
{
    protected static ?string $heading = 'Properties By Type Property Chart';
    protected static ?string $description = 'Properties By Type Property Chart';
    protected static ?int $sort = 4;
    protected static ?string $maxHeight = '300px';
    protected static string $color = 'success';

    protected function getData(): array
    {
        $types= TypeProperty::pluck('name','id')->toArray();
        $data = [];
        foreach ($types as $key => $type) {
            $data[] = Property::where('type_property_id', $key)->count();
        }
         return [
            'datasets' => [
                [
                    'label' => 'Properties',
                    'data' => $data,
                    'backgroundColor' => get_main_colors()
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
