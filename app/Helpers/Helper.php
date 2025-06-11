<?php
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

if(!function_exists('get_youtube_embed_url')) {
    function get_youtube_embed_url($url) {
        if (strpos($url, 'embed') !== false) {
            return $url;
        }
        if(get_youtube_id($url)) {
            return 'https://www.youtube.com/embed/' . get_youtube_id($url);
        }
        return null;
    }
}

if(!function_exists('get_youtube_id')) {
    function get_youtube_id($url) {
        $parsedUrl = parse_url($url);
        if (strpos($parsedUrl['host'], 'youtu.be') !== false) {
            return ltrim($parsedUrl['path'], '/');
        }

        if (strpos($parsedUrl['host'], 'youtube.com') !== false && isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $queryParams);
            return $queryParams['v'] ?? null;
        }
        return null;
    }
}

// check routes is active
if(!function_exists('is_active_routes')) {
    function is_active_routes($routeNames = [], $class = 'active', $not = '')
    {
        $currentRouteName = request()->route()->getName();
        if(in_array($currentRouteName, $routeNames)) {
            return $class;
        }
        return $not;
    }
}

//get_random_colors
if(!function_exists('get_random_colors')) {
    function get_random_colors(): string {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }
}


// get_main_colors
if(!function_exists('get_main_colors')) {
    function get_main_colors($limit = false, $is_random = true): array {
        $mainColors = collect([
            '#FF6384', // Red/Pink
            '#36A2EB', // Blue
            '#FFCE56', // Yellow
            '#4BC0C0', // Teal
            '#9966FF', // Purple
            '#FF9F40', // Orange
            '#8BC34A', // Light Green
            '#F44336', // Red
            '#00BCD4', // Cyan
            '#9C27B0', // Deep Purple
            '#3F51B5', // Indigo
            '#CDDC39', // Lime
            '#607D8B', // Blue Grey
            '#795548', // Brown
            '#E91E63', // Hot Pink
            '#03A9F4', // Light Blue
            '#FFC107', // Amber
            '#C2185B', // Dark Pink
            '#009688', // Turquoise
            '#FF5722', // Deep Orange
            '#AED581', // Light Olive
            '#BA68C8', // Soft Purple
            '#64B5F6', // Soft Blue
            '#81C784', // Soft Green
            '#FF8A65', // Coral
            '#A1887F', // Coffee
            '#B0BEC5', // Cool Grey
            '#D4E157', // Soft Lime
            '#9575CD', // Soft Violet
            '#4DD0E1', // Aqua
            '#90CAF9', // Baby Blue
            '#A5D6A7', // Mint Green
            '#FFF176', // Light Yellow
            '#CE93D8', // Lavender
        ]);
        $mainColors = $is_random ?  $mainColors->shuffle()->all() : $mainColors;
        return $limit ? array_slice($mainColors, 0, $limit) : $mainColors;
    }
}

// get Data Chart of Month
if(!function_exists('get_chart_data_month')) {
    function get_chart_data_month(Builder $query, $column = 'created_at'): array {
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();

        $dataPerDay = $query->selectRaw("DATE($column) as date, COUNT(*) as count")
            ->whereBetween($column, [$start, $end])
            ->groupBy(DB::raw("DATE($column)"))
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();
        // Fill missing dates with 0
        $allDates = [];
        for ($date = $start->copy(); $date <= $end; $date->addDay()) {
            $allDates[] = $dataPerDay[$date->toDateString()] ?? 0;
        }

        if( $allDates[count($allDates) -1] > $allDates[0]){
            $icon = "heroicon-m-arrow-trending-up";
            $color = "success";
        }elseif($allDates[count($allDates) -1] == $allDates[0]){
            $icon = "heroicon-m-arrow-right";
            $color = "gray";
        }
        else{
            $icon = "heroicon-m-arrow-trending-down";
            $color = "danger";
        }

        return [
            'data' => $allDates,
            'icon'=> $icon,
            'color' => $color,
        ];
    }
}
