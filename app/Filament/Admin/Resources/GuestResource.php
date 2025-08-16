<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\GuestResource\Pages;
use App\Models\Guest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;

class GuestResource extends Resource
{
    protected static ?string $model = Guest::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = null;
    
    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation.groups.events');
    }
    
    public static function getNavigationLabel(): string
    {
        return __('filament.resources.guests.navigation_label');
    }
    
    public static function getModelLabel(): string
    {
        return __('filament.resources.guests.label');
    }
    
    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.guests.plural_label');
    }

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('filament.resources.guests.sections.personal_information'))
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('filament.resources.guests.fields.name'))
                            ->placeholder(__('filament.resources.guests.placeholders.name'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label(__('filament.resources.guests.fields.email'))
                            ->placeholder(__('filament.resources.guests.placeholders.email'))
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone_number')
                            ->label(__('filament.resources.guests.fields.phone'))
                            ->placeholder(__('filament.resources.guests.placeholders.phone'))
                            ->tel()
                            ->required()
                            ->maxLength(255),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make(__('filament.resources.guests.sections.invitation_details'))
                    ->schema([
                        Forms\Components\Select::make('invitation_id')
                            ->label(__('filament.resources.guests.fields.invitation_id'))
                            ->relationship('invitation', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->label(__('filament.resources.invitations.fields.title'))
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('location')
                                    ->label(__('filament.resources.invitations.fields.location'))
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\DateTimePicker::make('event_date')
                                    ->label(__('filament.resources.invitations.fields.event_date'))
                                    ->required(),
                            ]),
                        Forms\Components\Select::make('assigned_staff_id')
                            ->label(__('filament.resources.guests.fields.assigned_staff'))
                            ->relationship('assignedStaff', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('status')
                            ->label(__('filament.resources.guests.fields.status'))
                            ->options([
                                'invited' => __('filament.status.invited'),
                                'confirmed' => __('filament.status.confirmed'),
                                'arrived' => __('filament.status.arrived'),
                                'no_show' => __('filament.status.no_show'),
                                'cancelled' => __('filament.status.cancelled'),
                            ])
                            ->required()
                            ->default('invited'),
                        Forms\Components\DateTimePicker::make('arrival_time')
                            ->label(__('filament.resources.guests.fields.arrival_time'))
                            ->visible(fn (string $context): bool => $context === 'edit'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament.resources.guests.fields.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('filament.resources.guests.fields.email'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->label(__('filament.resources.guests.fields.phone'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('invitation.name')
                    ->label(__('filament.resources.guests.fields.invitation_id'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('assignedStaff.name')
                    ->label(__('filament.resources.guests.fields.assigned_staff'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('filament.resources.guests.fields.status'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'invited' => 'gray',
                        'confirmed' => 'blue',
                        'arrived' => 'success',
                        'no_show' => 'danger',
                        'cancelled' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('arrival_time')
                    ->label(__('filament.resources.guests.fields.arrival_time'))
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('filament.resources.guests.fields.created_at'))
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
                Action::make('mark_arrived')
                    ->label('Mark Arrived')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Guest $record) => $record->status !== 'arrived')
                    ->action(function (Guest $record) {
                        $record->update([
                            'status' => 'arrived',
                            'arrival_time' => now(),
                        ]);
                    }),
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
            'index' => Pages\ListGuests::route('/'),
            'create' => Pages\CreateGuest::route('/create'),
            'view' => Pages\ViewGuest::route('/{record}'),
            'edit' => Pages\EditGuest::route('/{record}/edit'),
        ];
    }
}

