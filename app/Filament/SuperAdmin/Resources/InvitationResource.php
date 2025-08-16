<?php

namespace App\Filament\SuperAdmin\Resources;

use App\Filament\SuperAdmin\Resources\InvitationResource\Pages;
use App\Models\Invitation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;

class InvitationResource extends Resource
{
    protected static ?string $model = Invitation::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = null;
    
    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation.groups.invitation_management');
    }
    
    public static function getNavigationLabel(): string
    {
        return __('filament.resources.invitations.navigation_label');
    }
    
    public static function getModelLabel(): string
    {
        return __('filament.resources.invitations.label');
    }
    
    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.invitations.plural_label');
    }

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('filament.resources.invitations.sections.event_information'))
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('filament.resources.invitations.fields.title'))
                            ->placeholder(__('filament.resources.invitations.placeholders.title'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->label(__('filament.resources.invitations.fields.description'))
                            ->placeholder(__('filament.resources.invitations.placeholders.description'))
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('location')
                            ->label(__('filament.resources.invitations.fields.location'))
                            ->placeholder(__('filament.resources.invitations.placeholders.location'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\DateTimePicker::make('event_date')
                            ->label(__('filament.resources.invitations.fields.event_date'))
                            ->required(),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make(__('filament.resources.invitations.sections.template_settings'))
                    ->schema([
                        Forms\Components\Select::make('template_id')
                            ->label(__('filament.resources.invitations.fields.template'))
                            ->relationship('template', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->label(__('filament.resources.templates.fields.name'))
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('description')
                                    ->label(__('filament.resources.templates.fields.description'))
                                    ->maxLength(65535),
                                Forms\Components\Toggle::make('is_active')
                                    ->label(__('filament.resources.templates.fields.is_active'))
                                    ->default(true),
                            ]),
                        Forms\Components\Select::make('status')
                            ->label(__('filament.resources.invitations.fields.status'))
                            ->options([
                                'draft' => __('filament.status.draft'),
                                'active' => __('filament.status.active'),
                                'sent' => __('filament.status.sent'),
                                'completed' => __('filament.status.completed'),
                                'cancelled' => __('filament.status.cancelled'),
                            ])
                            ->required()
                            ->default('draft'),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make(__('filament.resources.invitations.sections.communication'))
                    ->schema([
                        Forms\Components\TextInput::make('qr_code')
                            ->label(__('filament.resources.invitations.fields.qr_code'))
                            ->placeholder(__('filament.resources.invitations.placeholders.qr_code'))
                            ->maxLength(255),
                        Forms\Components\Textarea::make('whatsapp_message')
                            ->label(__('filament.resources.invitations.fields.whatsapp_message'))
                            ->placeholder(__('filament.resources.invitations.placeholders.whatsapp_message'))
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament.resources.invitations.fields.title'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('location')
                    ->label(__('filament.resources.invitations.fields.location'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('event_date')
                    ->label(__('filament.resources.invitations.fields.event_date'))
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('template.name')
                    ->label(__('filament.resources.invitations.fields.template'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('filament.resources.invitations.fields.status'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'active' => 'blue',
                        'sent' => 'yellow',
                        'completed' => 'green',
                        'cancelled' => 'red',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('guests_count')
                    ->counts('guests')
                    ->label(__('filament.resources.invitations.fields.guests')),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('filament.resources.invitations.fields.created_at'))
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
                Action::make('send_whatsapp')
                    ->label('Send WhatsApp')
                    ->icon('heroicon-o-phone')
                    ->color('success')
                    ->action(function (Invitation $record) {
                        // WhatsApp sending logic here
                        // You can implement the actual WhatsApp API integration
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
            'index' => Pages\ListInvitations::route('/'),
            'create' => Pages\CreateInvitation::route('/create'),
            'view' => Pages\ViewInvitation::route('/{record}'),
            'edit' => Pages\EditInvitation::route('/{record}/edit'),
        ];
    }
}
