<?php

namespace App\Filament\SuperAdmin\Resources;

use App\Filament\SuperAdmin\Resources\TemplateResource\Pages;
use App\Models\Template;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TemplateResource extends Resource
{
    protected static ?string $model = Template::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = null;
    
    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation.groups.invitation_management');
    }
    
    public static function getNavigationLabel(): string
    {
        return __('filament.resources.templates.navigation_label');
    }
    
    public static function getModelLabel(): string
    {
        return __('filament.resources.templates.label');
    }
    
    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.templates.plural_label');
    }

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('filament.resources.templates.sections.template_information'))
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('filament.resources.templates.fields.name'))
                            ->placeholder(__('filament.resources.templates.placeholders.name'))
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\Textarea::make('description')
                            ->label(__('filament.resources.templates.fields.description'))
                            ->placeholder(__('filament.resources.templates.placeholders.description'))
                            ->maxLength(500),
                        
                        Forms\Components\Toggle::make('is_active')
                            ->label(__('filament.resources.templates.fields.is_active'))
                            ->default(true),
                    ])
                    ->columns(2),

                Forms\Components\Section::make(__('filament.resources.templates.sections.content'))
                    ->schema([
                        Forms\Components\RichEditor::make('html_content')
                            ->label(__('filament.resources.templates.fields.html_content'))
                            ->required()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'link',
                                'bulletList',
                                'orderedList',
                                'h2',
                                'h3',
                                'h4',
                                'blockquote',
                                'codeBlock',
                            ])
                            ->placeholder(__('filament.resources.templates.placeholders.html_content'))
                            ->helperText(__('filament.resources.templates.helpers.html_content')),
                        
                        Forms\Components\Textarea::make('css_content')
                            ->label(__('filament.resources.templates.fields.css_content'))
                            ->rows(8)
                            ->placeholder(__('filament.resources.templates.placeholders.css_content'))
                            ->helperText(__('filament.resources.templates.helpers.css_content')),
                        
                        Forms\Components\Textarea::make('js_content')
                            ->label(__('filament.resources.templates.fields.js_content'))
                            ->rows(6)
                            ->placeholder(__('filament.resources.templates.placeholders.js_content'))
                            ->helperText(__('filament.resources.templates.helpers.js_content')),
                    ])
                    ->collapsible(),

                Forms\Components\Section::make(__('filament.resources.templates.sections.design_settings'))
                    ->schema([
                        Forms\Components\FileUpload::make('thumbnail')
                            ->label(__('filament.resources.templates.fields.thumbnail'))
                            ->image()
                            ->imageEditor()
                            ->imageCropAspectRatio('16:9')
                            ->helperText(__('filament.resources.templates.helpers.thumbnail')),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label(__('filament.resources.templates.fields.thumbnail'))
                    ->circular()
                    ->size(40),
                
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament.resources.templates.fields.name'))
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('description')
                    ->label(__('filament.resources.templates.fields.description'))
                    ->limit(50)
                    ->searchable(),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('filament.resources.templates.fields.is_active'))
                    ->boolean()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('invitations_count')
                    ->counts('invitations')
                    ->label(__('filament.resources.templates.fields.used_in'))
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('filament.resources.templates.fields.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status'),
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
            'index' => Pages\ListTemplates::route('/'),
            'create' => Pages\CreateTemplate::route('/create'),
            'view' => Pages\ViewTemplate::route('/{record}'),
            'edit' => Pages\EditTemplate::route('/{record}/edit'),
        ];
    }
}

