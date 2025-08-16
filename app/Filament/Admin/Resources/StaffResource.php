<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\StaffResource\Pages;
use App\Models\Staff;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StaffResource extends Resource
{
    protected static ?string $model = Staff::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = null;
    
    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation.groups.management');
    }
    
    public static function getNavigationLabel(): string
    {
        return __('filament.resources.staff.navigation_label');
    }
    
    public static function getModelLabel(): string
    {
        return __('filament.resources.staff.label');
    }
    
    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.staff.plural_label');
    }

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('filament.resources.staff.sections.personal_information'))
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('filament.resources.staff.fields.name'))
                            ->placeholder(__('filament.resources.staff.placeholders.name'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label(__('filament.resources.staff.fields.email'))
                            ->placeholder(__('filament.resources.staff.placeholders.email'))
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone_number')
                            ->label(__('filament.resources.staff.fields.phone'))
                            ->placeholder(__('filament.resources.staff.placeholders.phone'))
                            ->tel()
                            ->required()
                            ->maxLength(255),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make(__('filament.resources.staff.sections.employment_details'))
                    ->schema([
                        Forms\Components\TextInput::make('position')
                            ->label(__('filament.resources.staff.fields.position'))
                            ->placeholder(__('filament.resources.staff.placeholders.position'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('user_id')
                            ->label(__('filament.resources.staff.fields.user_id'))
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
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
                                    ->unique(),
                                Forms\Components\TextInput::make('password')
                                    ->label(__('filament.resources.users.fields.password'))
                                    ->placeholder(__('filament.resources.users.placeholders.password'))
                                    ->password()
                                    ->required()
                                    ->minLength(8),
                                Forms\Components\TextInput::make('password_confirmation')
                                    ->label(__('filament.resources.users.fields.password_confirmation'))
                                    ->placeholder(__('filament.resources.users.placeholders.password'))
                                    ->password()
                                    ->required()
                                    ->minLength(8)
                                    ->same('password'),
                            ]),
                        Forms\Components\Select::make('status')
                            ->label(__('filament.resources.staff.fields.status'))
                            ->options([
                                'active' => __('filament.status.active'),
                                'inactive' => __('filament.status.inactive'),
                                'on_leave' => __('filament.status.on_leave'),
                            ])
                            ->required()
                            ->default('active'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament.resources.staff.fields.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('filament.resources.staff.fields.email'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->label(__('filament.resources.staff.fields.phone'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('position')
                    ->label(__('filament.resources.staff.fields.position'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('filament.resources.staff.fields.status'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                        'on_leave' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('assigned_guests_count')
                    ->counts('assignedGuests')
                    ->label(__('filament.resources.staff.fields.assigned_guests')),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('filament.resources.staff.fields.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListStaff::route('/'),
            'create' => Pages\CreateStaff::route('/create'),
            'view' => Pages\ViewStaff::route('/{record}'),
            'edit' => Pages\EditStaff::route('/{record}/edit'),
        ];
    }
}

