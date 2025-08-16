<?php

namespace App\Filament\SuperAdmin\Resources;

use App\Filament\SuperAdmin\Resources\InvitationResource\Pages;
use App\Models\Invitation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class InvitationResource extends Resource
{
    protected static ?string $model = Invitation::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Invitation Management';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Invitation Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Annual Conference 2024'),
                        
                        Forms\Components\Textarea::make('description')
                            ->maxLength(500)
                            ->placeholder('Describe the event or invitation'),
                        
                        Forms\Components\TextInput::make('location')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Grand Hotel, Downtown'),
                        
                        Forms\Components\DateTimePicker::make('event_date')
                            ->required()
                            ->minDate(now()),
                        
                        Forms\Components\Select::make('template_id')
                            ->relationship('template', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('description')
                                    ->maxLength(500),
                                Forms\Components\Toggle::make('is_active')
                                    ->default(true),
                            ]),
                        
                        Forms\Components\Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'active' => 'Active',
                                'sent' => 'Sent',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->default('draft')
                            ->required(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('QR Code & WhatsApp')
                    ->schema([
                        Forms\Components\TextInput::make('qr_code')
                            ->maxLength(255)
                            ->helperText('Leave empty to auto-generate'),
                        
                        Forms\Components\Textarea::make('whatsapp_message')
                            ->maxLength(1000)
                            ->placeholder('Custom WhatsApp message to send with invitation')
                            ->helperText('Use {invitation_name}, {location}, {event_date} as placeholders'),
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
                    ->sortable()
                    ->limit(50),
                
                Tables\Columns\TextColumn::make('location')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('event_date')
                    ->dateTime()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('template.name')
                    ->badge()
                    ->color('info'),
                
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'active' => 'blue',
                        'sent' => 'green',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                
                Tables\Columns\TextColumn::make('guests_count')
                    ->counts('guests')
                    ->label('Guests')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'active' => 'Active',
                        'sent' => 'Sent',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
                Tables\Filters\SelectFilter::make('template')
                    ->relationship('template', 'name')
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\Action::make('send_whatsapp')
                    ->icon('heroicon-o-paper-airplane')
                    ->label('Send WhatsApp')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn (Invitation $record) => $record->update(['status' => 'sent']))
                    ->visible(fn (Invitation $record) => $record->status === 'active'),
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
            'index' => Pages\ListInvitations::route('/'),
            'create' => Pages\CreateInvitation::route('/create'),
            'view' => Pages\ViewInvitation::route('/{record}'),
            'edit' => Pages\EditInvitation::route('/{record}/edit'),
        ];
    }
}
