<?php

namespace App\Filament\SuperAdmin\Resources;

use App\Filament\SuperAdmin\Resources\RoleResource\Pages;
use App\Models\Role;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Navigation\NavigationGroup;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup = null;
    
    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation.groups.system');
    }
    
    public static function getNavigationLabel(): string
    {
        return __('filament.resources.roles.navigation_label');
    }
    
    public static function getModelLabel(): string
    {
        return __('filament.resources.roles.label');
    }
    
    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.roles.plural_label');
    }

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('filament.resources.roles.sections.basic_information'))
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('filament.resources.roles.fields.name'))
                            ->placeholder(__('filament.resources.roles.placeholders.name'))
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('display_name')
                            ->label(__('filament.resources.roles.fields.display_name'))
                            ->placeholder(__('filament.resources.roles.placeholders.display_name'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->label(__('filament.resources.roles.fields.description'))
                            ->placeholder(__('filament.resources.roles.placeholders.description'))
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make(__('filament.resources.roles.sections.permissions'))
                    ->schema([
                        Forms\Components\CheckboxList::make('permissions')
                            ->label(__('filament.resources.roles.fields.permissions'))
                            ->relationship('permissions', 'display_name')
                            ->columns(2),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament.resources.roles.fields.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('display_name')
                    ->label(__('filament.resources.roles.fields.display_name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label(__('filament.resources.roles.fields.description'))
                    ->limit(50),
                Tables\Columns\TextColumn::make('permissions_count')
                    ->counts('permissions')
                    ->label(__('filament.resources.roles.fields.permissions')),
                Tables\Columns\TextColumn::make('users_count')
                    ->counts('users')
                    ->label(__('filament.resources.roles.fields.users')),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('filament.resources.roles.fields.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('filament.resources.roles.fields.updated_at'))
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
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}

