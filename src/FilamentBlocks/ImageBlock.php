<?php

namespace SOSEventsBV\Cms\FilamentBlocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ImageBlock
{
    /**
     * Creates and returns a Block instance configured as an image block.
     *
     * @param string $directory The directory path where the image files will be stored. Default is 'page'.
     * @return Block The configured Block instance.
     */
    public static function make(string $directory = 'page'): Block
    {
        return Block::make('image-block')
            ->label(__('cms::blocks.image-block.label'))
            ->icon(Heroicon::Photo)
            ->schema([
                FileUpload::make('url')
                    ->label(__('cms::blocks.image-block.image'))
                    ->disk('public')
                    ->directory($directory)
                    ->image()
                    ->imageEditor()
                    ->getUploadedFileNameForStorageUsing(
                        // UUID-based, unique file name with original title + hash and extension
                        fn(TemporaryUploadedFile $file): string => Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                            . '_' . Str::uuid()
                            . '.' . $file->getClientOriginalExtension()
                    )
                    ->required(),

                TextInput::make('alt')
                    ->label(__('cms::blocks.image-block.alt'))
                    ->required(),
            ])->columns(2);
    }
}
