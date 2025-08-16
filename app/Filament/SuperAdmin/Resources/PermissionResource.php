<?php

namespace App\Filament\SuperAdmin\Resources;

use App\Filament\SuperAdmin\Resources\PermissionResource\Pages;
use App\Models\Permission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PermissionResource extends Resource
{
    protected static ?string $model = Permission::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';

    protected static ?string $navigationGroup = null;
    
    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation.groups.system');
    }
    
    public static function getNavigationLabel(): string
    {
        return __('filament.resources.permissions.navigation_label');
    }
    
    public static function getModelLabel(): string
    {
        return __('filament.resources.permissions.label');
    }
    
    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.permissions.plural_label');
    }

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('filament.resources.permissions.sections.permission_details'))
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('filament.resources.permissions.fields.name'))
                            ->placeholder(__('filament.resources.permissions.placeholders.name'))
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('display_name')
                            ->label(__('filament.resources.permissions.fields.display_name'))
                            ->placeholder(__('filament.resources.permissions.placeholders.display_name'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->label(__('filament.resources.permissions.fields.description'))
                            ->placeholder(__('filament.resources.permissions.placeholders.description'))
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament.resources.permissions.fields.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('display_name')
                    ->label(__('filament.resources.permissions.fields.display_name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label(__('filament.resources.permissions.fields.description'))
                    ->limit(50),
                Tables\Columns\TextColumn::make('roles_count')
                    ->counts('roles')
                    ->label(__('filament.resources.permissions.fields.roles')),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('filament.resources.permissions.fields.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('filament.resources.permissions.fields.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListPermissions::route('/'),
            'create' => Pages\CreatePermission::route('/create'),
            'edit' => Pages\EditPermission::route('/{record}/edit'),
        ];
    }
}

