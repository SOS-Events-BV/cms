<?php

// config for SOSEventsBV/Cms
return [
    /**
     * Layout for the app
     */
    'layout' => 'cms::layout',

    /**
     * Specify the routing settings for the Page model. These will be used for the Page model.
     */
    'routing' => [
        'prefix' => '',
        'middleware' => ['web'],

        /**
         * Whether the package should register its own catch-all routes (`/{slug}`, `/{slug}/submit`,
         * `/{slug}/success`). Set this to `false` if you want to define your own catch-all route in the
         * host app and call `PageController` yourself as a fallback. See the README for more info.
         */
        'register_catch_all' => true,
    ],

    /**
     * Specify the routes that should be used by the Cms plugin. Use the `name` of the route to link to it.
     * If the route is null, the show button is not shown.
     */
    'routes' => [
        // Need `slug` parameter
        'page' => 'page', // Don't change this unless you know what you're doing. This is the default page route.
        'category' => null, // The overview page for a category with associated products
        'product' => null, // The detail page for a single product

        // No `slug` parameter
        'reviews' => null, // The page with all reviews
        'faq' => null, // The page with all FAQ questions
        'events' => null, // The overview page for all events
        'products' => null, // The overview page for all products
    ],

    /**
     * All the services that are used by the Cms plugin.
     */
    'services' => [
        'leisureking' => [
            'url' => env('CMS_LEISUREKING_API_URL', 'https://api.leisureking.eu/public'),
            'version' => env('CMS_LEISUREKING_API_VERSION', 'v4'),
            'username' => env('CMS_LEISUREKING_API_USERNAME'),
            'password' => env('CMS_LEISUREKING_API_PASSWORD'),
            'environment' => env('CMS_LEISUREKING_API_ENVIRONMENT', 'production'),
            'shophid' => env('CMS_LEISUREKING_API_SHOPHID'),
        ],

        'review' => [
            'url' => env('CMS_REVIEW_API_URL', 'https://reageren.sosevents.nl/api'),
            'api_key' => env('CMS_REVIEW_API_KEY'),
            'shop_id' => env('CMS_REVIEW_API_SHOP_ID'),
        ],

        'mailcampaigns' => [
            'url' => env('CMS_MAILCAMPAIGNS_API_URL', 'https://api.mailcampaigns.nl/api/v2.0'),
            'api_key' => env('CMS_MAILCAMPAIGNS_API_KEY'),
            'api_token' => env('CMS_MAILCAMPAIGNS_API_TOKEN'),
        ],

        'sosevents' => [
            'url' => env('CMS_SOS_EVENTS_API_URL', 'https://api.sosevents.nl/v1'),
            'api_key' => env('CMS_SOS_EVENTS_API_KEY'),
            'api_secret' => env('CMS_SOS_EVENTS_API_SECRET'),
        ],

        'microsoft' => [
            'client_id' => env('CMS_MICROSOFT_CLIENT_ID'),
            'client_secret' => env('CMS_MICROSOFT_CLIENT_SECRET'),
            'tenant' => env('CMS_MICROSOFT_TENANT_ID'),
            'include_avatar' => true,
            'include_avatar_size' => '120x120',
        ],

        'recaptcha' => [
            'project_id' => env('CMS_RECAPTCHA_PROJECT_ID'),
            'site_key' => env('CMS_RECAPTCHA_SITE_KEY'),
            'api_key' => env('CMS_RECAPTCHA_API_KEY'),
            'threshold' => (float) env('CMS_RECAPTCHA_THRESHOLD', 0.5),
        ],
    ],

    /**
     * Add the classes for your buttons here, set it as the key. The value after is the name of the
     * button that will be shown in the CMS.
     */
    'buttons' => [
        'btn btn-blue' => 'Blauw',
        'btn btn-pink' => 'Roze',
        'btn'          => 'Grijs',
    ],
];
