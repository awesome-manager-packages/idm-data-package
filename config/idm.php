<?php

return [
    'client_id' => env('IDM_CLIENT'),
    'client_secret' => env('IDM_SECRET'),
    'user_token_header' => env('IDM_USER_TOKEN_HEADER', 'User-Token')
];