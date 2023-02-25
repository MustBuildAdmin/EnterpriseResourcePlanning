<?php

return [

    /*
    |-------------------------------------
    | Messenger display name
    |-------------------------------------
    */
    'name' => env('CHATIFY_NAME', 'Messenger'),


    /*
   |--------------------------------------------------------------------------
   | Package path
   |--------------------------------------------------------------------------
   |
   | This value is the path of the package or in other meaning, it is the prefix
   | of all the registered routes in this package.
   |
   | e.g. : app.test/chatify
   */

    'path' => env('CHATIFY_PATH', 'chats'),

    /*
    |-------------------------------------
    | Routes configurations
    |-------------------------------------
    */
    'routes' => [
        'prefix' => env('CHATIFY_ROUTES_PREFIX', 'chats'),
        'middleware' => env(
            'CHATIFY_ROUTES_MIDDLEWARE', [
                                           'web',
                                           'auth',
                                           'XSS',
                                       ]
        ),
        'namespace' => env('CHATIFY_ROUTES_NAMESPACE', 'App\Http\Controllers\vendor\Chatify'),
    ],


    /*
    |-------------------------------------
    | Pusher API credentials
    |-------------------------------------
    */
    'pusher' => [
        'key' => env('PUSHER_APP_KEY'),
        'secret' => env('PUSHER_APP_SECRET'),
        'app_id' => env('PUSHER_APP_ID'),
        'options' => (array)[
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => env('PUSHER_APP_USETLS'),
        ],
    ],

    /*
    |-------------------------------------
    | User Avatar
    |-------------------------------------
    */
    'user_avatar' => [
        'folder' => 'uploads/avatar',
        'default' => 'avatar.png',
    ],

    /*
    |-------------------------------------
    | Attachments
    |-------------------------------------
    */
    'attachments' => [
        'folder' => 'attachments',
        'download_route_name' => 'attachments.download',
        'allowed_images' => (array)[
            'png',
            'jpg',
            'jpeg',
            'gif',
        ],
        'allowed_files' => (array)[
            'zip',
            'rar',
            'txt',
        ],
    ],
];
