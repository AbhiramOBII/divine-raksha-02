<?php

use App\Models\SiteSetting;

if (!function_exists('setting')) {
    function setting(string $key, $default = null): ?string
    {
        return SiteSetting::get($key, $default);
    }
}
