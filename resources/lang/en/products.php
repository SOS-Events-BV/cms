<?php

return [
    'product' => 'Product',
    'products' => 'Products',

    'show_products_page' => 'Show all products page',

    'tabs' => [
        'basic' => 'Basic',
        'prices' => 'Prices & booking',
        'seo' => 'SEO',
        'faq' => 'FAQ',
        'package' => 'Package & integration',
    ],

    // Basic tab
    'slug' => 'Page slug',
    'name' => 'Product name',
    'summary' => 'Summary',
    'description' => 'Description',
    'images' => 'Images',
    'optional_fields' => 'Optional fields',
    'location' => 'Location',
    'min_persons' => 'Minimum number of persons',
    'max_persons' => 'Maximum number of persons',
    'page_settings' => 'Page settings',
    'is_active' => 'Product active',
    'view' => 'View product',

    'prices' => [
        'heading' => 'Price settings',
        'description' => 'At least 1 price in euros is required. Indicate per price whether it includes or excludes VAT. Optionally, you can add other currencies and a label.',
        'label' => 'Prices',
        'add_label' => 'Add price',
        'euro_required' => 'A price in Euro (EUR) is required.',
        'currency' => 'Currency',
        'amount' => 'Price',
        'includes_vat' => 'Including VAT',
        'price_label' => 'Label (optional)',
        'time_block' => 'Time block (optional)',

        'helpers' => [
            'price_label' => 'For example: Adult rate or Child rate',
        ],
    ],

    'book_option' => [
        'heading' => 'Booking option',
        'description' => 'Choose how visitors can book this product. For \'Book now\' a LeisureKing Booking Module is required.',
        'label' => 'Booking option',
        'forward_url' => 'Redirect to URL',
        'forward_title' => 'Redirect title',
        'forward_title_placeholder' => 'For example: You are being redirected to the Veluwe Specialist.',
        'forward_description' => 'Redirect description',
        'forward_description_placeholder' => 'Example: Have fun at the Veluwe Specialist!',

        'options' => [
            'book_now' => 'Book now',
            'quotation' => 'Quotation',
            'forward' => 'Redirect to...',
        ],
    ],

    'faqs' => [
        'heading' => 'Frequently asked questions',
        'description' => 'Add frequently asked questions that are shown on the product page.',
        'label' => 'FAQs',
        'add_label' => 'Add FAQ',
        'question' => 'Question',
        'answer' => 'Answer',
    ],

    'package' => [
        'heading' => 'Package settings',
        'description' => 'Details for the program and time schedule. Only applicable if this product is a package.',
        'is_package' => 'This product is a package',
        'time_schemes' => 'Time schedules',
    ],

    'leisureking' => [
        'heading' => 'LeisureKing (optional)',
        'description' => 'Enter the LeisureKing ID here. This allows us to pre-fill certain fields.',
        'id' => 'LeisureKing ID',
        'bookingmodule_hash' => 'LeisureKing Booking Module',
        'fetch_tooltip' => 'Fill fields from LeisureKing',
        'sync_enabled' => 'LK sync enabled',
        'sync_disabled' => 'LK sync disabled',
        'error_title' => 'LeisureKing Error',
        'success_title' => 'LeisureKing',
        'success_body' => 'Fields filled successfully!',

        'helpers' => [
            'bookingmodule_hash' => 'This is the hash after /bm/...',
        ],
    ],

    'table' => [
        'prices' => 'Price(s) (EUR)',
        'includes_vat' => 'Incl. VAT',
    ],

    'filters' => [
        'is_active' => 'Only active products',
    ],
];
