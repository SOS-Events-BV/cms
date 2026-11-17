<?php

return [
    'product' => 'Product',
    'products' => 'Producten',

    'show_products_page' => 'Toon alle producten pagina',

    'tabs' => [
        'basic' => 'Basis',
        'prices' => 'Prijzen & boeken',
        'seo' => 'SEO',
        'faq' => 'FAQ',
        'package' => 'Pakket & integratie',
    ],

    // Basic tab
    'slug' => 'Pagina slug',
    'name' => 'Productnaam',
    'summary' => 'Samenvatting',
    'description' => 'Omschrijving',
    'images' => 'Afbeeldingen',
    'optional_fields' => 'Optionele velden',
    'location' => 'Locatie',
    'min_persons' => 'Minimaal aantal personen',
    'max_persons' => 'Maximaal aantal personen',
    'page_settings' => 'Pagina instellingen',
    'is_active' => 'Product actief',
    'view' => 'Bekijk product',

    'prices' => [
        'heading' => 'Prijs instellingen',
        'description' => 'Minimaal 1 prijs in euro is verplicht. Geef aan per prijs of het inclusief of exclusief BTW is. Optioneel kan je andere valuta\'s toevoegen en een label toevoegen.',
        'label' => 'Prijzen',
        'add_label' => 'Prijs toevoegen',
        'euro_required' => 'Een prijs in Euro (EUR) is verplicht.',
        'currency' => 'Valuta',
        'amount' => 'Prijs',
        'includes_vat' => 'Inclusief BTW',
        'price_label' => 'Label (optioneel)',
        'time_block' => 'Tijdblok (optioneel)',

        'helpers' => [
            'price_label' => 'Bijvoorbeeld: Volwassenentarief of Kindertarief',
        ],
    ],

    'book_option' => [
        'heading' => 'Boek optie',
        'description' => 'Kies hoe bezoekers dit product kunnen boeken. Bij \'Boek direct\' is een LeisureKing Boeking Module verplicht.',
        'label' => 'Boek optie',
        'forward_url' => 'Doorverwijzen naar URL',
        'forward_title' => 'Titel doorverwijzing',
        'forward_title_placeholder' => 'Bijvoorbeeld: Je wordt doorverwezen naar de Veluwe Specialist.',
        'forward_description' => 'Beschrijving doorverwijzing',
        'forward_description_placeholder' => 'Voorbeeld: Veel plezier op de Veluwe Specialist!',

        'options' => [
            'book_now' => 'Boek direct',
            'quotation' => 'Offerte',
            'forward' => 'Doorverwijzen naar...',
        ],
    ],

    'faqs' => [
        'heading' => 'Veelgestelde vragen',
        'description' => 'Voeg veelgestelde vragen toe die op de productpagina worden getoond.',
        'label' => 'FAQ\'s',
        'add_label' => 'FAQ toevoegen',
        'question' => 'Vraag',
        'answer' => 'Antwoord',
    ],

    'package' => [
        'heading' => 'Arrangement instellingen',
        'description' => 'Details voor het programma en tijdschema. Alleen van toepassing als dit product een arrangement is.',
        'is_package' => 'Dit product is een arrangement',
        'time_schemes' => 'Tijdschema\'s',
    ],

    'leisureking' => [
        'heading' => 'LeisureKing (optioneel)',
        'description' => 'Vul hier het LeisureKing ID in. Hiermee kunnen we al bepaalde velden mee invullen.',
        'id' => 'LeisureKing ID',
        'bookingmodule_hash' => 'LeisureKing Boeking Module',
        'fetch_tooltip' => 'Vul velden in vanuit LeisureKing',
        'sync_enabled' => 'LK sync ingeschakeld',
        'sync_disabled' => 'LK sync uitgeschakeld',
        'error_title' => 'LeisureKing Error',
        'success_title' => 'LeisureKing',
        'success_body' => 'Velden succesvol ingevuld!',

        'helpers' => [
            'bookingmodule_hash' => 'Dit is de hash achter /bm/...',
        ],
    ],

    'table' => [
        'prices' => 'Prijs/Prijzen (EUR)',
        'includes_vat' => 'Incl. BTW',
    ],

    'filters' => [
        'is_active' => 'Enkel actieve producten',
    ],
];
