<?php

return [
    'button-group-block' => [
        'label' => 'Button(s) / link(s)',
        'type' => 'Button type',
        'content' => 'Button text',
        'url' => 'URL',
        'open_in_new_tab' => 'Open in new tab'
    ],

    'content-block' => [
        'label' => 'Content block',
    ],

    'custom-html-block' => [
        'label' => 'HTML block',
        'helper_text' => 'Note: Do not use Tailwind classes in this field, apply styling via inline styles instead.'
    ],

    'faq-block' => [
        'label' => 'FAQ block',
        'add_label' => 'Add FAQ',
        'question' => 'Question',
        'answer' => 'Answer'
    ],

    'form-builder-block' => [
        'label' => 'Form builder',
        'form_inputs' => 'Form inputs',
        'add_input' => 'Add input',
        'email' => 'Where should it be sent to?',

        'inputs' => [
            'text_input' => 'Text field',
            'email_input' => 'Email field',
            'phone_input' => 'Phone number',
            'number_input' => 'Number field',
            'textarea' => 'Text area',
            'select' => 'Dropdown',
            'radio' => 'Radio',
            'checkbox' => 'Checkbox',
            'date_input' => 'Date',
        ],

        'fields' => [
            'label' => 'Label',
            'placeholder' => 'Placeholder',
            'required' => 'Required',
            'min' => 'Minimum',
            'max' => 'Maximum',
            'options' => 'Options',
            'value' => 'Value',
            'add_option' => 'Add option',
        ],

        'success' => [
            'heading' => 'Success message',
            'title' => 'Title',
            'message' => 'Message',
        ],
    ],

    'heading-block' => [
        'label' => 'Heading / title',
        'content' => 'Heading',
        'level' => 'Level',

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
        'bookingmodule_code' => 'Booking module code',
        'settings' => 'Settings',
        'no_scroll' => 'No scroll',
        'date' => 'Date',
        'min_date' => 'Minimum date',
        'max_date' => 'Maximum date',
        'lang' => 'Language',

        'languages' => [
            'NL' => 'Dutch',
            'EN' => 'English',
            'DE' => 'German',
            'FR' => 'French',
            'ES' => 'Spanish',
            'PT' => 'Portuguese',
        ],

        'helpers' => [
            'no_scroll' => 'Enable to prevent scrolling directly to the iFrame (optional, default: on).',
            'date' => 'Date on which the booking should be made (optional).',
            'min_date' => 'Start date in the date picker (optional).',
            'max_date' => 'End date in the date picker (optional).',
            'lang' => 'Language of the booking module (optional).',
        ],
    ],

    'image-block' => [
        'label' => 'Image',
        'image' => 'Image',
        'alt' => 'Alt',
    ],

    'image-slider-block' => [
        'label' => 'Image slider',
        'images' => 'Images',
        'image' => 'Image',
        'alt' => 'Alt',
        'add_label' => 'Add to slider',
        'settings' => 'Settings',
        'loop' => 'Loop',
        'navigation' => 'Navigation arrows',
        'pagination' => 'Pagination',
        'autoplay' => 'Autoplay',
        'autoplay_speed' => 'Autoplay speed (ms)',
        'slides_per_breakpoint' => 'Slides per breakpoint',
        'slides_mobile' => 'Mobile (< 640px)',
        'slides_tablet' => 'Tablet (640px)',
        'slides_desktop' => 'Desktop (1024px)',
        'space_between' => 'Space between slides (px)',
    ],

    'read-more-block' => [
        'label' => 'Read more',
        'content_1' => 'Content 1',
        'content_2' => 'Content 2',

        'helpers' => [
            'content_1' => 'This content is always displayed.',
            'content_2' => 'This content is displayed when you click the \'Read more\' button.',
        ],
    ],

    'spacer-block' => [
        'label' => 'Spacer',
        'height' => 'Height',
    ],

    'two-column-block' => [
        'label' => 'Two columns',
        'layout_ratio' => 'Layout ratio',
        'background_color' => 'Background color',
        'text_color' => 'Text color',
        'center_content' => 'Center content',
        'left_column' => 'Left column',
        'right_column' => 'Right column',

        'ratios' => [
            '50_50' => '50 / 50 (Half / Half)',
            '33_66' => '33 / 66 (One third / Two thirds)',
            '66_33' => '66 / 33 (Two thirds / One third)',
            '25_75' => '25 / 75 (Quarter / Three quarters)',
            '75_25' => '75 / 25 (Three quarters / Quarter)',
        ],

        'helpers' => [
            'layout_ratio' => 'Determines the ratio between the left and right column on larger screens.',
            'background_color' => 'Choose a background color for the two columns. (optional)',
            'text_color' => 'Choose a text color for the two columns. (optional)',
            'center_content' => 'Allows you to center the content in the left and right column.',
        ],
    ],

    'video-block' => [
        'label' => 'Video (YouTube)',
        'video_id' => 'Video ID',
        'autoplay' => 'Autoplay',
        'controls' => 'Controls',
        'mute' => 'Mute',

        'helpers' => [
            'video_id' => 'This is located after /watch?v={id}',
            'autoplay' => 'Video starts automatically',
            'controls' => 'Video can be controlled with buttons',
            'mute' => 'No sound during playback',
        ],
    ],
];
