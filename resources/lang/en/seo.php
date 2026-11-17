<?php

return [
    'title' => 'SEO settings',
    'description' => 'Determine how this is shown in search engines and on social media.',

    'page_title' => 'Page title',
    'page_description' => 'Meta description',
    'page_keywords' => 'Meta keywords (optional)',
    'page_keywords_placeholder' => 'Add a keyword...',
    'characters' => ':count characters',

    'og' => [
        'title' => 'Open Graph (og:)',
        'description' => 'Optional social media preview settings',
        'og_title' => 'OG Title',
        'og_description' => 'OG Description',
        'og_image' => 'OG Image',
    ],

    'helpers' => [
        'page_title' => 'A good page title is up to 50/60 characters',
        'page_description' => 'A good meta description is up to 150/160 characters',
        'page_keywords' => 'Google no longer uses keywords, but they are sometimes still relevant for other search engines.',
        'og_title' => 'Leave empty to use the page title',
        'og_description' => 'Leave empty to use the meta description',
        'og_image' => 'Recommended size: 1200x630px',
    ],
];
