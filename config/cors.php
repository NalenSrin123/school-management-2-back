<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    // ❌ DO NOT use '*' when using credentials
    'allowed_origins' => ['*'], // React URL

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    // ✅ MUST be true if using login / cookies
    'supports_credentials' => true,

];
