<?php

return [
    'page' => 'Page',
    'pages' => 'Pages',
    'slug' => 'Slug',
    'content' => 'Page content',
    'additional_fields' => 'Additional fields',

    'delete_modal' => [
        'heading' => 'Delete page',
        'description' => 'Are you sure you want to permanently delete this page? The slug of this page will be released. If you want to catch existing links, first set up a redirect via the Redirects section.',

        'notification' => [
            'title' => 'Page deleted',
        ]
    ],

    'slug_modal' => [
        'save' => 'Save changes',
        'heading' => 'Change slug',
        'description' => 'The slug will be changed from ":old" to ":new". This will break existing links to this page. You can catch these by creating a redirect via the Redirects tab. Are you sure you want to continue?',
        'submit' => 'Yes, change slug',
        'cancel' => 'Cancel',

        'notification' => [
            'title' => 'Slug changed',
        ],
    ],

    'widget' => [
        'heading' => 'Recently edited pages',
    ],

    'filters' => [
        'only_active_pages' => 'Only active pages',
    ],

    'helpers' => [
        'slug' => 'Such as `page` or `subpage/page`',
        'url' => 'This will be the URL of this page: :url',
    ]
];
