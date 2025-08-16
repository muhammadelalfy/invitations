# Translation Guide for Filament Panels

This guide explains how to use the comprehensive translations created for both Arabic and English in your Filament admin panels.

## Available Translation Files

### Core Files
- `lang/en/filament.php` - Main Filament translations (English)
- `lang/ar/filament.php` - Main Filament translations (Arabic)
- `lang/en/app.php` - Application-specific translations
- `lang/ar/app.php` - Application-specific translations

### Laravel Core Files
- `lang/en/auth.php` & `lang/ar/auth.php` - Authentication messages
- `lang/en/validation.php` & `lang/ar/validation.php` - Validation messages
- `lang/en/passwords.php` & `lang/ar/passwords.php` - Password reset messages
- `lang/en/pagination.php` & `lang/ar/pagination.php` - Pagination labels

## How to Use Translations in Filament Resources

### 1. Resource Labels and Navigation

```php
// In your Resource class (e.g., UserResource.php)
class UserResource extends Resource
{
    protected static ?string $model = User::class;

    // Use translation for navigation label
    protected static ?string $navigationLabel = null;
    
    public static function getNavigationLabel(): string
    {
        return __('filament.resources.users.navigation_label');
    }

    // Use translation for model label
    public static function getModelLabel(): string
    {
        return __('filament.resources.users.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.resources.users.plural_label');
    }

    // Navigation group with translation
    protected static ?string $navigationGroup = null;
    
    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation.groups.management');
    }
}
```

### 2. Form Field Labels and Placeholders

```php
public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Section::make(__('filament.resources.users.sections.personal_information'))
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label(__('filament.resources.users.fields.name'))
                        ->placeholder(__('filament.resources.users.placeholders.name'))
                        ->required(),
                    
                    Forms\Components\TextInput::make('email')
                        ->label(__('filament.resources.users.fields.email'))
                        ->placeholder(__('filament.resources.users.placeholders.email'))
                        ->email()
                        ->required(),
                ]),
            
            Forms\Components\Section::make(__('filament.resources.users.sections.account_settings'))
                ->schema([
                    Forms\Components\Select::make('role_id')
                        ->label(__('filament.resources.users.fields.role'))
                        ->relationship('role', 'display_name')
                        ->required(),
                    
                    Forms\Components\TextInput::make('password')
                        ->label(__('filament.resources.users.fields.password'))
                        ->placeholder(__('filament.resources.users.placeholders.password'))
                        ->password()
                        ->required(fn (string $context): bool => $context === 'create'),
                ]),
        ]);
}
```

### 3. Table Column Labels

```php
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
                ->color('primary'),
            
            Tables\Columns\TextColumn::make('created_at')
                ->label(__('filament.resources.users.fields.created_at'))
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('role')
                ->label(__('filament.filters.role'))
                ->relationship('role', 'display_name'),
        ])
        ->actions([
            Tables\Actions\EditAction::make()
                ->label(__('filament.actions.edit')),
            Tables\Actions\DeleteAction::make()
                ->label(__('filament.actions.delete')),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make()
                    ->label(__('filament.actions.bulk_delete')),
            ]),
        ]);
}
```

### 4. Page Titles and Breadcrumbs

```php
// In your Page classes (e.g., ListUsers.php, CreateUser.php, EditUser.php)

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    public function getTitle(): string
    {
        return __('filament.resources.users.plural_label');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label(__('filament.actions.create')),
        ];
    }
}

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    public function getTitle(): string
    {
        return __('filament.actions.create') . ' ' . __('filament.resources.users.label');
    }
}

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    public function getTitle(): string
    {
        return __('filament.actions.edit') . ' ' . __('filament.resources.users.label');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label(__('filament.actions.delete')),
        ];
    }
}
```

### 5. Custom Validation Messages

```php
// In your Form components
Forms\Components\TextInput::make('email')
    ->label(__('filament.resources.users.fields.email'))
    ->email()
    ->required()
    ->rules(['email', 'unique:users,email'])
    ->validationMessages([
        'email' => __('validation.email'),
        'unique' => __('validation.unique'),
        'required' => __('validation.required'),
    ]),
```

### 6. Status Badges with Translations

```php
Tables\Columns\TextColumn::make('status')
    ->label(__('filament.resources.users.fields.status'))
    ->badge()
    ->color(fn (string $state): string => match ($state) {
        'active' => 'success',
        'inactive' => 'danger',
        'pending' => 'warning',
        default => 'gray',
    })
    ->formatStateUsing(fn (string $state): string => __('filament.status.' . $state)),
```

### 7. Dashboard Widget Translations

```php
// In your Widget classes
class StatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('filament.widgets.stats.total_users'), User::count())
                ->description(__('filament.widgets.stats.total_users'))
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
            
            Stat::make(__('filament.widgets.stats.total_invitations'), Invitation::count())
                ->description(__('filament.widgets.stats.total_invitations'))
                ->descriptionIcon('heroicon-m-envelope')
                ->color('info'),
        ];
    }
}
```

## Language Switching Implementation

The language switcher is already implemented and will automatically apply the correct translations based on the selected language. When users switch to Arabic:

1. All text will be translated to Arabic
2. RTL layout will be applied
3. Form inputs and tables will be right-aligned
4. Navigation will appear in Arabic

## Adding New Translations

To add new translations:

1. **English**: Add to `lang/en/filament.php` in the appropriate section
2. **Arabic**: Add the corresponding Arabic translation to `lang/ar/filament.php`

Example:
```php
// lang/en/filament.php
'resources' => [
    'new_resource' => [
        'label' => 'New Resource',
        'plural_label' => 'New Resources',
        'fields' => [
            'field_name' => 'Field Name',
        ],
    ],
],

// lang/ar/filament.php
'resources' => [
    'new_resource' => [
        'label' => 'مورد جديد',
        'plural_label' => 'موارد جديدة',
        'fields' => [
            'field_name' => 'اسم الحقل',
        ],
    ],
],
```

## Best Practices

1. **Always use translations**: Never hardcode text in your Filament resources
2. **Consistent keys**: Use the same key structure across both language files
3. **Meaningful keys**: Use descriptive keys that indicate the context
4. **Fallback**: Laravel will fallback to the key if translation is missing
5. **Test both languages**: Always test your interface in both English and Arabic

This comprehensive translation system ensures your Filament admin panels are fully bilingual and provide an excellent user experience in both languages.
