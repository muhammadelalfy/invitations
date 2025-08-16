<?php

namespace App\Filament\SuperAdmin\Resources;

use App\Filament\SuperAdmin\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = null;
    
    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation.groups.system');
    }
    
    public static function getNavigationLabel(): string
    {
        return __('filament.resources.users.navigation_label');
    }
    
    public static function getModelLabel(): string
    {
        return __('filament.resources.users.label');
    }
    
    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.users.plural_label');
    }

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('filament.resources.users.sections.account_information'))
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('filament.resources.users.fields.name'))
                            ->placeholder(__('filament.resources.users.placeholders.name'))
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('email')
                            ->label(__('filament.resources.users.fields.email'))
                            ->placeholder(__('filament.resources.users.placeholders.email'))
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        
                        Forms\Components\Select::make('role_id')
                            ->label(__('filament.resources.users.fields.role'))
                            ->relationship('role', 'display_name')
                            ->required()
                            ->searchable()
                            ->preload(),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make(__('filament.resources.users.sections.security'))
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->label(fn (string $context): string => $context === 'edit' 
                                ? __('filament.resources.users.fields.new_password') 
                                : __('filament.resources.users.fields.password'))
                            ->placeholder(__('filament.resources.users.placeholders.password'))
                            ->password()
                            ->required(fn (string $context): bool => $context === 'create')
                            ->minLength(8)
                            ->dehydrated(fn ($state) => filled($state)),
                        
                        Forms\Components\TextInput::make('password_confirmation')
                            ->label(__('filament.resources.users.fields.password_confirmation'))
                            ->placeholder(__('filament.resources.users.placeholders.password_confirmation'))
                            ->password()
                            ->required(fn (string $context): bool => $context === 'create')
                            ->minLength(8)
                            ->dehydrated(false)
                            ->same('password'),
                    ])
                    ->columns(2)
                    ->visible(fn (string $context): bool => $context !== 'view'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament.resources.users.fields.name'))
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('email')
                    ->label(__('filament.resources.users.fields.email'))
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('role.display_name')
                    ->label(__('filament.resources.users.fields.role'))
                    ->badge()
                    ->color('primary')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->label(__('filament.resources.users.fields.email_verified_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('filament.resources.users.fields.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->relationship('role', 'display_name')
                    ->searchable(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}

