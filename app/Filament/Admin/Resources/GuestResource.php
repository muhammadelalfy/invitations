<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\GuestResource\Pages;
use App\Models\Guest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GuestResource extends Resource
{
    protected static ?string $model = Guest::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'Guest Management';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Guest Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('phone_number')
                            ->tel()
                            ->required()
                            ->maxLength(20),
                        
                        Forms\Components\Select::make('invitation_id')
                            ->relationship('invitation', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('location')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\DateTimePicker::make('event_date')
                                    ->required()
                                    ->minDate(now()),
                            ]),
                        
                        Forms\Components\Select::make('assigned_staff_id')
                            ->relationship('assignedStaff', 'name')
                            ->searchable()
                            ->preload()
                            ->helperText('Staff member responsible for this guest'),
                        
                        Forms\Components\Select::make('status')
                            ->options([
                                'invited' => 'Invited',
                                'confirmed' => 'Confirmed',
                                'arrived' => 'Arrived',
                                'no_show' => 'No Show',
                                'cancelled' => 'Cancelled',
                            ])
                            ->default('invited')
                            ->required(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Arrival Details')
                    ->schema([
                        Forms\Components\DateTimePicker::make('arrival_time')
                            ->label('Arrival Time')
                            ->helperText('When the guest arrived at the event'),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('phone_number')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('invitation.name')
                    ->label('Event')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                
                Tables\Columns\TextColumn::make('assignedStaff.name')
                    ->label('Assigned Staff')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('status')
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
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'invited' => 'Invited',
                        'confirmed' => 'Confirmed',
                        'arrived' => 'Arrived',
                        'no_show' => 'No Show',
                        'cancelled' => 'Cancelled',
                    ]),
                Tables\Filters\SelectFilter::make('invitation')
                    ->relationship('invitation', 'name')
                    ->searchable(),
                Tables\Filters\SelectFilter::make('assigned_staff')
                    ->relationship('assignedStaff', 'name')
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\Action::make('mark_arrived')
                    ->icon('heroicon-o-check-circle')
                    ->label('Mark Arrived')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn (Guest $record) => $record->update([
                        'status' => 'arrived',
                        'arrival_time' => now(),
                    ]))
                    ->visible(fn (Guest $record) => $record->status !== 'arrived'),
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
            'index' => Pages\ListGuests::route('/'),
            'create' => Pages\CreateGuest::route('/create'),
            'view' => Pages\ViewGuest::route('/{record}'),
            'edit' => Pages\EditGuest::route('/{record}/edit'),
        ];
    }
}

