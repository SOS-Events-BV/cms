<?php

return [
    'redirect' => 'Redirect',
    'redirects' => 'Redirects',

    'language' => 'Language',
    'all_languages' => 'All languages',
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
        'language' => 'Choose a language if the redirect should only apply to visitors of that language version. Leave empty for all languages. A redirect for a specific language takes precedence over one for all languages.',
        'from' => 'Do not put a / at the beginning, it may contain a / (For example: page/subpage). Always use the Dutch slug, even if the redirect is for another language. The slug translated by Weglot never reaches the server.',
        'to' => 'Use a / for internal pages, type https:// for external pages (For example https://google.com).',
    ],

    // Reminder shown after deleting a page or changing its slug
    'reminder' => [
        'body' => 'Don\'t forget to set up a redirect to catch existing links.',
        'button' => 'Create redirect',
    ],
];
