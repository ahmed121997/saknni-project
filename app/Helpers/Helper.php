<?php

if(!function_exists('getYoutubeEmbedUrl')) {
    function getYoutubeEmbedUrl($url) {
        if (strpos($url, 'embed') !== false) {
            return $url;
        }
        if(getYoutubeId($url)) {
            return 'https://www.youtube.com/embed/' . getYoutubeId($url);
        }
        return null;
    }
}

if(!function_exists('getYoutubeId')) {
    function getYoutubeId($url) {
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
if(!function_exists('isActiveRoutes')) {
    function isActiveRoutes($routeNames = [], $class = 'active', $not = '')
    {
        $currentRouteName = request()->route()->getName();
        if(in_array($currentRouteName, $routeNames)) {
            return $class;
        }
        return $not;
    }
}
