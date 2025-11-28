<?php

return [
    'api_key' => env('OPENAI_API_KEY'),
    'model' => env('OPENAI_MODEL', 'gpt-4o-mini'),
    'max_history' => 10, // number of past messages to send
    'timeout' => 15,
];
