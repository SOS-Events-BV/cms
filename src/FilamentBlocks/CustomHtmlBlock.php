<?php

namespace SOSEventsBV\Cms\FilamentBlocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\CodeEditor;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\HtmlString;

class CustomHtmlBlock
{
    public static function make(): Block
    {
        return Block::make('custom-html-block')
            ->label(__('cms::blocks.custom-html-block.label'))
            ->icon(Heroicon::CodeBracket)
            ->schema([
                CodeEditor::make('html')
                    ->hiddenLabel()
                    ->language(CodeEditor\Enums\Language::Html)
                    ->helperText(__('cms::blocks.custom-html-block.helper_text')),
            ]);
    }
}
