<?php

namespace SOSEventsBV\Cms\FilamentBlocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class FormBuilderBlock
{
    public static function make(): Block
    {
        return Block::make('form-builder-block')
            ->label(__('cms::blocks.form-builder-block.label'))
            ->icon(Heroicon::Bars4)
            ->schema([
                Builder::make('form_inputs')
                    ->label(__('cms::blocks.form-builder-block.form_inputs'))
                    ->schema([
                        // Normal text input
                        Block::make('text_input')
                            ->label(__('cms::blocks.form-builder-block.inputs.text_input'))
                            ->icon(Heroicon::Minus)
                            ->schema([
                                TextInput::make('label')->label(__('cms::blocks.form-builder-block.fields.label'))->required(),
                                TextInput::make('placeholder')->label(__('cms::blocks.form-builder-block.fields.placeholder')),
                                Toggle::make('required')->label(__('cms::blocks.form-builder-block.fields.required'))->default(true)->inline(false),
                            ])->columns(2),

                        // Text input for email
                        Block::make('email_input')
                            ->label(__('cms::blocks.form-builder-block.inputs.email_input'))
                            ->icon(Heroicon::Envelope)
                            ->schema([
                                TextInput::make('label')->label(__('cms::blocks.form-builder-block.fields.label'))->required(),
                                TextInput::make('placeholder')->label(__('cms::blocks.form-builder-block.fields.placeholder')),
                                Toggle::make('required')->label(__('cms::blocks.form-builder-block.fields.required'))->default(true)->inline(false),
                            ])->columns(2),

                        // Text input for phone number
                        Block::make('phone_input')
                            ->label(__('cms::blocks.form-builder-block.inputs.phone_input'))
                            ->icon(Heroicon::Phone)
                            ->schema([
                                TextInput::make('label')->label(__('cms::blocks.form-builder-block.fields.label'))->required(),
                                TextInput::make('placeholder')->label(__('cms::blocks.form-builder-block.fields.placeholder')),
                                Toggle::make('required')->label(__('cms::blocks.form-builder-block.fields.required'))->default(true)->inline(false),
                            ])->columns(2),

                        // Text input for number
                        Block::make('number_input')
                            ->label(__('cms::blocks.form-builder-block.inputs.number_input'))
                            ->icon(Heroicon::Hashtag)
                            ->schema([
                                TextInput::make('label')->label(__('cms::blocks.form-builder-block.fields.label'))->required(),
                                TextInput::make('placeholder')->label(__('cms::blocks.form-builder-block.fields.placeholder')),
                                TextInput::make('min')->label(__('cms::blocks.form-builder-block.fields.min'))->numeric(),
                                TextInput::make('max')->label(__('cms::blocks.form-builder-block.fields.max'))->numeric(),
                                Toggle::make('required')->label(__('cms::blocks.form-builder-block.fields.required'))->default(true)->inline(false),
                            ])->columns(2),

                        // Field for textarea
                        Block::make('textarea')
                            ->label(__('cms::blocks.form-builder-block.inputs.textarea'))
                            ->icon(Heroicon::Bars3BottomLeft)
                            ->schema([
                                TextInput::make('label')->label(__('cms::blocks.form-builder-block.fields.label'))->required(),
                                TextInput::make('placeholder')->label(__('cms::blocks.form-builder-block.fields.placeholder')),
                                Toggle::make('required')->label(__('cms::blocks.form-builder-block.fields.required'))->default(true)->inline(false),
                            ])->columns(2),

                        // Field for dropdown / select
                        Block::make('select')
                            ->label(__('cms::blocks.form-builder-block.inputs.select'))
                            ->icon(Heroicon::ChevronUpDown)
                            ->schema([
                                TextInput::make('label')->label(__('cms::blocks.form-builder-block.fields.label'))->required(),
                                Repeater::make('options')
                                    ->label(__('cms::blocks.form-builder-block.fields.options'))
                                    ->schema([
                                        TextInput::make('label')->label(__('cms::blocks.form-builder-block.fields.label'))->required(),
                                        TextInput::make('value')->label(__('cms::blocks.form-builder-block.fields.value'))->required(),
                                    ])
                                    ->columns(2)
                                    ->addActionLabel(__('cms::blocks.form-builder-block.fields.add_option')),
                                Toggle::make('required')->label(__('cms::blocks.form-builder-block.fields.required'))->default(true)->inline(false),
                            ]),

                        // Field for radio
                        Block::make('radio')
                            ->label(__('cms::blocks.form-builder-block.inputs.radio'))
                            ->icon(Heroicon::Stop)
                            ->schema([
                                TextInput::make('label')->label(__('cms::blocks.form-builder-block.fields.label'))->required(),
                                Repeater::make('options')
                                    ->label(__('cms::blocks.form-builder-block.fields.options'))
                                    ->schema([
                                        TextInput::make('label')->label(__('cms::blocks.form-builder-block.fields.label'))->required(),
                                        TextInput::make('value')->label(__('cms::blocks.form-builder-block.fields.value'))->required(),
                                    ])
                                    ->columns(2)
                                    ->addActionLabel(__('cms::blocks.form-builder-block.fields.add_option')),
                                Toggle::make('required')->label(__('cms::blocks.form-builder-block.fields.required'))->default(true)->inline(false),
                            ]),

                        // Field for checkbox
                        Block::make('checkbox')
                            ->label(__('cms::blocks.form-builder-block.inputs.checkbox'))
                            ->icon(Heroicon::CheckCircle)
                            ->schema([
                                TextInput::make('label')->label(__('cms::blocks.form-builder-block.fields.label'))->required(),
                                Toggle::make('required')->label(__('cms::blocks.form-builder-block.fields.required'))->default(false)->inline(false),
                            ])->columns(2),

                        // Field for dates
                        Block::make('date_input')
                            ->label(__('cms::blocks.form-builder-block.inputs.date_input'))
                            ->icon(Heroicon::Calendar)
                            ->schema([
                                TextInput::make('label')->label(__('cms::blocks.form-builder-block.fields.label'))->required(),
                                Toggle::make('required')->label(__('cms::blocks.form-builder-block.fields.required'))->default(true)->inline(false),
                            ])->columns(2),

                    ])
                    ->blockPickerColumns(2)
                    ->addActionLabel(__('cms::blocks.form-builder-block.add_input')),

                // To which email address should the form be sent?
                TextInput::make('email')
                    ->label(__('cms::blocks.form-builder-block.email'))
                    ->prefixIcon(Heroicon::Envelope)
                    ->email()
                    ->required(),

                // Set succes message
                Section::make(__('cms::blocks.form-builder-block.success.heading'))
                    ->schema([
                        TextInput::make('title')->label(__('cms::blocks.form-builder-block.success.title'))->required(),
                        RichEditor::make('message')->label(__('cms::blocks.form-builder-block.success.message'))->required(),
                    ])
            ]);
    }
}
