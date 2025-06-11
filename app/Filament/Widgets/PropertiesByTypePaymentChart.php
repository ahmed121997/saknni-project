<?php

namespace App\Filament\Widgets;

use App\Models\Property;
use App\Models\TypePayment;
use Filament\Widgets\ChartWidget;

class PropertiesByTypePaymentChart extends ChartWidget
{
    protected static ?string $heading = 'Properties By Type Payment Chart';
    protected static ?string $description = 'Properties By Type Payment Chart';
    protected static ?int $sort = 7;
    protected static ?string $maxHeight = '300px';
    protected static string $color = 'danger';

    protected function getData(): array
    {
        $types= TypePayment::pluck('name','id')->toArray();
        $data = [];
        foreach ($types as $key => $type) {
            $data[] = Property::where('type_payment_id', $key)->count();
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
