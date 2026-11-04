<?php

namespace SOSEventsBV\Cms\Resources\Users;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use SOSEventsBV\Cms\Resources\Users\Pages\CreateUser;
use SOSEventsBV\Cms\Resources\Users\Pages\EditUser;
use SOSEventsBV\Cms\Resources\Users\Pages\ListUsers;
use SOSEventsBV\Cms\Resources\Users\Schemas\UserForm;
use SOSEventsBV\Cms\Resources\Users\Tables\UsersTable;
use SOSEventsBV\Cms\Traits\HasCmsPermissions;

class UserResource extends Resource
{
    use HasCmsPermissions;

    protected static ?string $model = null;

    public static function getModel(): string
    {
        return config('cms.models.user');
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|\UnitEnum|null $navigationGroup = "Instellingen";

    // Translate labels to Dutch
    protected static ?string $modelLabel = 'Gebruiker';
    protected static ?string $pluralModelLabel = 'Gebruikers';
    protected static ?string $navigationLabel = 'Gebruikers';

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
