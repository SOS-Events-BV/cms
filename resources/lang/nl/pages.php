<?php

return [
    'page' => 'Pagina',
    'pages' => 'Pagina\'s',
    'slug' => 'Slug',
    'content' => 'Pagina inhoud',
    'additional_fields' => 'Extra velden',

    'delete_modal' => [
        'heading' => 'Pagina verwijderen',
        'description' => 'Weet je zeker dat je deze pagina permanent wilt verwijderen? De slug van deze pagina wordt vrijgegeven. Als je bestaande links wilt opvangen, stel dan eerst een redirect in via het kopje Redirects.',

        'notification' => [
            'title' => 'Pagina verwijderd',
        ]
    ],

    'slug_modal' => [
        'save' => 'Wijzigingen opslaan',
        'heading' => 'Slug wijzigen',
        'description' => 'De slug wordt gewijzigd van ":old" naar ":new". Hierdoor zullen bestaande links naar deze pagina breken. Je kan dit opvangen door een redirect aan te maken via het tabje Redirects. Weet je zeker dat je door wil gaan?',
        'submit' => 'Ja, wijzig slug',
        'cancel' => 'Annuleren',

        'notification' => [
            'title' => 'Slug gewijzigd',
        ],
    ],

    'widget' => [
        'heading' => 'Laatst gewijzigde pagina\'s',
    ],

    'filters' => [
        'only_active_pages' => 'Alleen actieve pagina\'s',
    ],

    'helpers' => [
        'slug' => 'Zoals `pagina` of `subpagina/pagina`',
        'url' => 'Dit wordt de URL van deze pagina: :url',
    ]
];
