<?php

return [
    'button-group-block' => [
        'label' => 'Knop(pen) / link(s)',
        'type' => 'Knop type',
        'content' => 'Knop tekst',
        'url' => 'URL',
        'open_in_new_tab' => 'Openen in nieuwe tab'
    ],

    'content-block' => [
        'label' => 'Content blok',
    ],

    'custom-html-block' => [
        'label' => 'HTML blok',
        'helper_text' => 'Let op!: Gebruik in dit veld geen Tailwind classes, maar pas opmaak toe via inline styles.'
    ],

    'faq-block' => [
        'label' => 'FAQ blok',
        'add_label' => 'FAQ toevoegen',
        'question' => 'Vraag',
        'answer' => 'Antwoord'
    ],

    'form-builder-block' => [
        'label' => 'Formulier maker',
        'form_inputs' => 'Formulier inputs',
        'add_input' => 'Input toevoegen',
        'email' => 'Waar moet het naartoe gestuurd worden?',

        'inputs' => [
            'text_input' => 'Tekstveld',
            'email_input' => 'E-mailveld',
            'phone_input' => 'Telefoonnummer',
            'number_input' => 'Nummerveld',
            'textarea' => 'Tekstvak',
            'select' => 'Dropdown',
            'radio' => 'Radio',
            'checkbox' => 'Checkbox',
            'date_input' => 'Datum',
        ],

        'fields' => [
            'label' => 'Label',
            'placeholder' => 'Placeholder',
            'required' => 'Verplicht',
            'min' => 'Minimum',
            'max' => 'Maximum',
            'options' => 'Opties',
            'value' => 'Waarde',
            'add_option' => 'Optie toevoegen',
        ],

        'success' => [
            'heading' => 'Succes bericht',
            'title' => 'Titel',
            'message' => 'Bericht',
        ],
    ],

    'heading-block' => [
        'label' => 'Heading / titel',
        'content' => 'Heading',
        'level' => 'Niveau',

        'levels' => [
            'h1' => 'Heading 1',
            'h2' => 'Heading 2',
            'h3' => 'Heading 3',
            'h4' => 'Heading 4',
            'h5' => 'Heading 5',
            'h6' => 'Heading 6',
        ],
    ],

    'leisureking-block' => [
        'label' => 'LeisureKing iFrame',
        'bookingmodule_code' => 'Boekingsmodule code',
        'settings' => 'Instellingen',
        'no_scroll' => 'Niet scrollen',
        'date' => 'Datum',
        'min_date' => 'Minimale datum',
        'max_date' => 'Maximale datum',
        'lang' => 'Taal',

        'languages' => [
            'NL' => 'Nederlands',
            'EN' => 'Engels',
            'DE' => 'Duits',
            'FR' => 'Frans',
            'ES' => 'Spaans',
            'PT' => 'Portugees',
        ],

        'helpers' => [
            'no_scroll' => 'Schakel in om niet direct te scrollen naar het iFrame (optioneel, standaard: aan).',
            'date' => 'Datum waarop geboekt moet worden (optioneel).',
            'min_date' => 'Startdatum in de datum selectie (optioneel).',
            'max_date' => 'Einddatum in de datum selectie (optioneel).',
            'lang' => 'Taal van de boekingsmodule (optioneel).',
        ],
    ],

    'image-block' => [
        'label' => 'Afbeelding',
        'image' => 'Afbeelding',
        'alt' => 'Alt',
    ],

    'image-slider-block' => [
        'label' => 'Afbeelding slider',
        'images' => 'Afbeeldingen',
        'image' => 'Afbeelding',
        'alt' => 'Alt',
        'add_label' => 'Toevoegen aan slider',
        'settings' => 'Instellingen',
        'loop' => 'Loop',
        'navigation' => 'Navigatie pijlen',
        'pagination' => 'Pagination',
        'autoplay' => 'Autoplay',
        'autoplay_speed' => 'Autoplay snelheid (ms)',
        'slides_per_breakpoint' => 'Slides per breakpoint',
        'slides_mobile' => 'Mobiel (< 640px)',
        'slides_tablet' => 'Tablet (640px)',
        'slides_desktop' => 'Desktop (1024px)',
        'space_between' => 'Afstand tussen slides (px)',
    ],

    'read-more-block' => [
        'label' => 'Lees meer',
        'content_1' => 'Inhoud 1',
        'content_2' => 'Inhoud 2',

        'helpers' => [
            'content_1' => 'Deze inhoud wordt altijd weergegeven.',
            'content_2' => 'Deze inhoud wordt weergegeven als je op de \'Meer lezen\' knop klikt.',
        ],
    ],

    'spacer-block' => [
        'label' => 'Witruimte',
        'height' => 'Hoogte',
    ],

    'two-column-block' => [
        'label' => 'Twee kolommen',
        'layout_ratio' => 'Layout ratio',
        'background_color' => 'Achtergrondkleur',
        'text_color' => 'Tekstkleur',
        'center_content' => 'Centreren inhoud',
        'left_column' => 'Linker kolom',
        'right_column' => 'Rechter kolom',

        'ratios' => [
            '50_50' => '50 / 50 (Helft / Helft)',
            '33_66' => '33 / 66 (Eén derde / Twee derde)',
            '66_33' => '66 / 33 (Twee derde / Eén derde)',
            '25_75' => '25 / 75 (Kwart / Driekwart)',
            '75_25' => '75 / 25 (Driekwart / Kwart)',
        ],

        'helpers' => [
            'layout_ratio' => 'Bepaalt de verhouding tussen de linker- en rechterkolom op grotere schermen.',
            'background_color' => 'Kies een achtergrondkleur voor de twee kolommen. (optioneel)',
            'text_color' => 'Kies een tekstkleur voor de twee kolommen. (optioneel)',
            'center_content' => 'Hiermee kan je de inhoud centreren in de linker- en rechterkolom.',
        ],
    ],

    'video-block' => [
        'label' => 'Video (YouTube)',
        'video_id' => 'Video ID',
        'autoplay' => 'Automatisch afspelen',
        'controls' => 'Bediening',
        'mute' => 'Geluid uit',

        'helpers' => [
            'video_id' => 'Dit staat achter /watch?v={id}',
            'autoplay' => 'Video start automatisch',
            'controls' => 'Video kan worden bestuurd met knoppen',
            'mute' => 'Tijdens afspelen geen geluid',
        ],
    ],
];
