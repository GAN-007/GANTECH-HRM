<?php

return [
    // off: disabled; shadow/advisory: return typed metadata only.
    'mode' => env('HRM_SYSTEM_ONE_MODE', 'off'),
    'base_url' => env('HRM_SYSTEM_ONE_BASE_URL', ''),
    'api_key' => env('HRM_SYSTEM_ONE_API_KEY', ''),
    'timeout_seconds' => (float) env('HRM_SYSTEM_ONE_TIMEOUT_SECONDS', 1.5),
];
