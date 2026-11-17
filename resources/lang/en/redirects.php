<?php

return [
    'redirect' => 'Redirect',
    'redirects' => 'Redirects',

    'from' => 'From URL',
    'to' => 'To URL',
    'status_code' => 'Status code',

    'status_codes' => [
        '301' => '301 (Permanent)',
        '302' => '302 (Temporary)',
    ],

    'placeholders' => [
        'from' => 'For example old-page or old/page',
        'to' => 'For example /new-page or https://google.com',
    ],

    'helpers' => [
        'from' => 'Do not put a / at the beginning, it may contain a / (For example: page/subpage).',
        'to' => 'Use a / for internal pages, type https:// for external pages (For example https://google.com).',
    ],

    // Reminder shown after deleting a page or changing its slug
    'reminder' => [
        'body' => 'Don\'t forget to set up a redirect to catch existing links.',
        'button' => 'Create redirect',
    ],
];
