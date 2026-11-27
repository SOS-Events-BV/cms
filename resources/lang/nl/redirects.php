<?php

return [
    'redirect' => 'Redirect',
    'redirects' => 'Redirects',

    'language' => 'Taal',
    'all_languages' => 'Alle talen',
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
        'language' => 'Kies een taal als de redirect alleen moet gelden voor bezoekers van die taalversie. Laat leeg voor alle talen. Een redirect voor een specifieke taal gaat voor een redirect voor alle talen.',
        'from' => 'Zet geen / aan het begin, mag wel een / bevatten (Bijvoorbeeld: pagina/subpagina). Gebruik altijd de Nederlandse slug, ook als de redirect voor een andere taal is. De door Weglot vertaalde slug komt niet bij de server aan.',
        'to' => 'Gebruik een / voor interne pagina\'s, type https:// voor externe pagina\'s (Bijvoorbeeld https://google.com).',
    ],

    // Reminder shown after deleting a page or changing its slug
    'reminder' => [
        'body' => 'Vergeet niet een redirect in te stellen om bestaande links op te vangen.',
        'button' => 'Redirect aanmaken',
    ],
];
