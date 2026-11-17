<?php

namespace SOSEventsBV\Cms\Pages;

use SOSEventsBV\Cms\Enums\NavigationGroup;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Override;
use SOSEventsBV\Cms\Settings\CompanySettings;

class ManageCompany extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice;

    protected static string $settings = CompanySettings::class;

    protected static string|\UnitEnum|null $navigationGroup = NavigationGroup::Settings;

    protected static ?int $navigationSort = 3;

    #[Override]
    public function getTitle(): string
    {
        return __('cms::company.title');
    }

    #[Override]
    public static function getNavigationLabel(): string
    {
        return __('cms::company.title');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('street')
                    ->label(__('cms::company.street'))
                    ->required(),

                TextInput::make('house_number')
                    ->label(__('cms::company.house_number'))
                    ->required(),

                TextInput::make('zipcode')
                    ->label(__('cms::company.zipcode'))
                    ->required(),

                TextInput::make('city')
                    ->label(__('cms::company.city'))
                    ->required(),

                TextInput::make('province')
                    ->label(__('cms::company.province'))
                    ->required(),

                TextInput::make('country')
                    ->label(__('cms::company.country'))
                    ->required(),

                TextInput::make('email')
                    ->label(__('cms::company.email'))
                    ->email()
                    ->required(),

                TextInput::make('phone')
                    ->label(__('cms::company.phone'))
                    ->required(),
            ]);
    }

    #[Override]
    public static function canAccess(): bool
    {
        return Auth::user()->hasRole('admin');
    }
}
