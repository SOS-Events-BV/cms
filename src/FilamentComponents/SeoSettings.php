<?php

namespace SOSEventsBV\Cms\FilamentComponents;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class SeoSettings
{
    /**
     * Reusable form component for SEO Settings. Make sure the model has a `seo` relationship.
     *
     * @param string $ogDirectory The directory where the OG image must be saved.
     * @return Group
     */
    public static function make(string $ogDirectory): Group
    {
        return Group::make([
            TextInput::make('page_title')
                ->label(__('cms::seo.page_title'))
                ->required()
                ->debounce()
                ->hint(fn($state) => __('cms::seo.characters', ['count' => strlen($state)]))
                ->hintColor(fn($state) => match (true) {
                    strlen($state) > 60 => 'danger',
                    strlen($state) > 50 => 'warning',
                    default => 'success'
                })
                ->helperText(__('cms::seo.helpers.page_title')),

            Textarea::make('page_description')
                ->label(__('cms::seo.page_description'))
                ->required()
                ->debounce()
                ->hint(fn($state) => __('cms::seo.characters', ['count' => strlen($state)]))
                ->hintColor(fn($state) => match (true) {
                    strlen($state) > 160 => 'danger',
                    strlen($state) > 150 => 'warning',
                    default => 'success'
                })
                ->autosize()
                ->maxLength(255)
                ->belowContent(__('cms::seo.helpers.page_description')),

            TagsInput::make('page_keywords')
                ->label(__('cms::seo.page_keywords'))
                ->separator(', ')
                ->helperText(__('cms::seo.helpers.page_keywords'))
                ->placeholder(__('cms::seo.page_keywords_placeholder')),

            // Open Graph settings
            Section::make(__('cms::seo.og.title'))
                ->description(__('cms::seo.og.description'))
                ->collapsed()
                ->schema([
                    // OG Title
                    TextInput::make('og_title')
                        ->label(__('cms::seo.og.og_title'))
                        ->debounce()
                        ->hint(fn($state) => __('cms::seo.characters', ['count' => strlen($state)]))
                        ->hintColor(fn($state) => match (true) {
                            strlen($state) > 60 => 'danger',
                            strlen($state) > 50 => 'warning',
                            default => 'success'
                        })
                        ->extraInputAttributes(fn($state) => [
                            'class' => match (true) {
                                strlen($state) > 60 => 'border-red-500',
                                strlen($state) > 50 => 'border-orange-500',
                                default => 'border-green-500',
                            }
                        ])
                        ->belowContent(__('cms::seo.helpers.og_title')),

                    // OG Description
                    TextInput::make('og_description')
                        ->label(__('cms::seo.og.og_description'))
                        ->debounce()
                        ->hint(fn($state) => __('cms::seo.characters', ['count' => strlen($state)]))
                        ->hintColor(fn($state) => match (true) {
                            strlen($state) > 160 => 'danger',
                            strlen($state) > 150 => 'warning',
                            default => 'success'
                        })
                        ->extraInputAttributes(fn($state) => [
                            'class' => match (true) {
                                strlen($state) > 160 => 'border-red-500',
                                strlen($state) > 150 => 'border-orange-500',
                                default => 'border-green-500',
                            }
                        ])
                        ->belowContent(__('cms::seo.helpers.og_description')),

                    // OG Image
                    FileUpload::make('og_image')
                        ->label(__('cms::seo.og.og_image'))
                        ->image()
                        ->imageEditor()
                        ->disk('public')
                        ->directory($ogDirectory)
                        ->getUploadedFileNameForStorageUsing(
                            // UUID-based, unique file name with original title + hash and extension
                            fn(TemporaryUploadedFile $file): string => Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                                . '_' . Str::uuid()
                                . '.' . $file->getClientOriginalExtension()
                        )
                        ->helperText(__('cms::seo.helpers.og_image')),
                ]),
        ])->relationship('seo');
    }
}
