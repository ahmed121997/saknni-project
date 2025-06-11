<?php

namespace App\Filament\Widgets;

use App\Models\City;
use App\Models\Image;
use App\Models\Property;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class StatsOverview extends BaseWidget
{

    protected ?string $heading = 'Analytics';
    protected ?string $description = 'Your analytics dashboard';
    protected ?string $color = 'primary';
    protected ?string $icon = 'heroicon-o-chart-pie';
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        $userChart = get_chart_data_month(User::query(), 'created_at');
        $propertyChart = get_chart_data_month(Property::query(), 'created_at');
        return [
            Stat::make('Users', Number::format(User::query()->count()))
                ->description('users in system')
                ->descriptionIcon( $userChart['icon'])
                ->chart( $userChart['data'])
                 ->color($userChart['color']),
            Stat::make('All Ads.', Number::format(Property::query()->count()))
                ->description('properties in system')
                ->descriptionIcon( $propertyChart['icon'])
                ->chart( $propertyChart['data'])
                ->color($propertyChart['color']),
            Stat::make('Active Ads', Number::format(Property::active()->count()))
                ->description('properties active in system')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info'),
            Stat::make('Not Active Ads', Number::format(Property::notActive()->count()))
                ->description('properties not active in system')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('danger'),
            Stat::make('Files', Number::format(Image::query()->count()))
                ->description('files in system')
                ->color('warning')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),
            Stat::make('Cities', Number::format(City::query()->count()))
                ->description('cities in system')
                ->color('secondary')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),
        ];
    }
}
