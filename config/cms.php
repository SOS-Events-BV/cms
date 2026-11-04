<?php

use SOSEventsBV\Cms\Resources\Categories\CategoryResource;
use SOSEventsBV\Cms\Resources\Events\EventResource;
use SOSEventsBV\Cms\Resources\FaqPageQuestions\FaqPageQuestionResource;
use SOSEventsBV\Cms\Resources\Pages\PageResource;
use SOSEventsBV\Cms\Resources\Products\ProductResource;
use SOSEventsBV\Cms\Resources\Reviews\ReviewResource;

// config for SOSEventsBV/Cms
return [
    // Name of the app
    'app_name' => config('app.name', 'Cms'),

    /**
     * Layout for the app
     */
    'layout' => 'layout',

    /**
     * Specify the views that should be used by the Cms plugin.
     * Override these to use your own views with custom styling.
     */
    'views' => [
        'page' => 'cms::page.show',
    ],

    /**
     * Specify the models that should be used by the Cms plugin.
     */
    'models' => [
        'user' => \App\Models\User::class
    ],

    /**
     * Add roles to use in the CMS panel
     */
    'roles' => [
        'admin' => [
            'label' => 'Administrator',
            'super_admin' => true
        ],
        'editor' => [
            'label' => 'Editor',
            'permissions' => [
                PageResource::class            => ['view', 'create', 'update'],
                CategoryResource::class        => ['view', 'create', 'update'],
                ProductResource::class         => ['view', 'create', 'update'],
                EventResource::class           => ['view', 'create', 'update'],
                FaqPageQuestionResource::class => ['view', 'create', 'update'],
                ReviewResource::class          => ['view', 'update'],
            ]
        ],
        // ... (Add more roles here)
    ],

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
            'environment' => env('CMS_LEISUREKING_API_ENVIRONMENT', 'test'),
            'shophid' => env('CMS_LEISUREKING_API_SHOPHID'),
        ],

        'review' => [
            'url' => env('CMS_REVIEW_API_URL', 'https://reageren.sosevents.nl/api'),
            'api_key' => env('CMS_REVIEW_API_KEY'),
            'shop_id' => env('CMS_REVIEW_API_SHOP_ID'),
        ]
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
