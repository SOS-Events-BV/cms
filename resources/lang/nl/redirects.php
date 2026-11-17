<?php

return [
    'redirect' => 'Redirect',
    'redirects' => 'Redirects',

    'from' => 'Van URL',
    'to' => 'Naar URL',
    'status_code' => 'Status code',

    'status_codes' => [
        '301' => '301 (Permanent)',
        '302' => '302 (Tijdelijk)',
    ],

    'placeholders' => [
        'from' => 'Bijvoorbeeld oude-pagina of oud/pagina',
        'to' => 'Bijvoorbeeld /nieuwe-pagina of https://google.com',
    ],

    'helpers' => [
        'from' => 'Zet geen / aan het begin, mag wel een / bevatten (Bijvoorbeeld: pagina/subpagina).',
        'to' => 'Gebruik een / voor interne pagina\'s, type https:// voor externe pagina\'s (Bijvoorbeeld https://google.com).',
    ],

    // Reminder shown after deleting a page or changing its slug
    'reminder' => [
        'body' => 'Vergeet niet een redirect in te stellen om bestaande links op te vangen.',
        'button' => 'Redirect aanmaken',
    ],
];
