<?php

namespace SOSEventsBV\Cms\FilamentBlocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Support\Icons\Heroicon;

class FaqBlock
{
    public static function make(): Block
    {
        return Block::make('faq-block')
            ->label(__('cms::blocks.faq-block.label'))
            ->icon(Heroicon::QuestionMarkCircle)
            ->schema([
                Repeater::make('faqs')
                    ->hiddenLabel()
                    ->addActionLabel(__('cms::blocks.faq-block.add_label'))
                    ->collapsible()
                    ->schema([
                        TextInput::make('question')
                            ->label(__('cms::blocks.faq-block.question'))
                            ->required(),

                        RichEditor::make('answer')
                            ->label(__('cms::blocks.faq-block.answer'))
                            ->required(),
                    ])
            ]);
    }
}
