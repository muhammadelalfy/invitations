# Technical Implementation Plan - Invitation System

## 1. Development Environment Setup

### 1.1 Prerequisites
- PHP 8.1+ with required extensions
- Composer 2.0+
- Node.js 16+ and npm
- MySQL 8.0+ or PostgreSQL 13+
- Git for version control

### 1.2 Project Structure
```
invitations/
├── app/
│   ├── Filament/
│   │   ├── Resources/
│   │   ├── Pages/
│   │   └── Widgets/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   ├── Models/
│   └── Services/
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── resources/
│   ├── views/
│   └── js/
└── routes/
```

## 2. Database Implementation

### 2.1 Migration Files to Create

#### Create Users Table Migration
```php
// database/migrations/xxxx_xx_xx_create_users_table.php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->foreignId('role_id')->constrained();
    $table->enum('status', ['active', 'inactive'])->default('active');
    $table->rememberToken();
    $table->timestamps();
});
```

#### Create Roles Table Migration
```php
// database/migrations/xxxx_xx_xx_create_roles_table.php
Schema::create('roles', function (Blueprint $table) {
    $table->id();
    $table->string('name')->unique();
    $table->string('display_name');
    $table->text('description')->nullable();
    $table->timestamps();
});
```

#### Create Permissions Table Migration
```php
// database/migrations/xxxx_xx_xx_create_permissions_table.php
Schema::create('permissions', function (Blueprint $table) {
    $table->id();
    $table->string('name')->unique();
    $table->string('display_name');
    $table->text('description')->nullable();
    $table->timestamps();
});
```

#### Create Role Permission Pivot Table
```php
// database/migrations/xxxx_xx_xx_create_role_permission_table.php
Schema::create('role_permission', function (Blueprint $table) {
    $table->foreignId('role_id')->constrained()->onDelete('cascade');
    $table->foreignId('permission_id')->constrained()->onDelete('cascade');
    $table->primary(['role_id', 'permission_id']);
});
```

#### Create Staff Table Migration
```php
// database/migrations/xxxx_xx_xx_create_staff_table.php
Schema::create('staff', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('phone_number');
    $table->string('department');
    $table->enum('status', ['active', 'inactive'])->default('active');
    $table->timestamps();
});
```

#### Create Templates Table Migration
```php
// database/migrations/xxxx_xx_xx_create_templates_table.php
Schema::create('templates', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->text('description')->nullable();
    $table->longText('html_content');
    $table->longText('css_styles')->nullable();
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
```

#### Create Invitations Table Migration
```php
// database/migrations/xxxx_xx_xx_create_invitations_table.php
Schema::create('invitations', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->text('description')->nullable();
    $table->string('location');
    $table->dateTime('event_date');
    $table->foreignId('template_id')->constrained();
    $table->foreignId('created_by')->constrained('users');
    $table->enum('status', ['draft', 'sent', 'active', 'expired'])->default('draft');
    $table->string('qr_code')->nullable();
    $table->text('whatsapp_message')->nullable();
    $table->timestamps();
});
```

#### Create Guests Table Migration
```php
// database/migrations/xxxx_xx_xx_create_guests_table.php
Schema::create('guests', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email');
    $table->string('phone_number');
    $table->foreignId('invitation_id')->constrained();
    $table->foreignId('assigned_staff_id')->nullable()->constrained('staff');
    $table->enum('status', ['invited', 'confirmed', 'arrived', 'cancelled'])->default('invited');
    $table->timestamp('arrival_time')->nullable();
    $table->timestamps();
});
```

#### Create Staff Assignment Table Migration
```php
// database/migrations/xxxx_xx_xx_create_staff_assignments_table.php
Schema::create('staff_assignments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('staff_id')->constrained()->onDelete('cascade');
    $table->foreignId('guest_id')->constrained()->onDelete('cascade');
    $table->foreignId('invitation_id')->constrained()->onDelete('cascade');
    $table->timestamp('assigned_at');
    $table->enum('status', ['assigned', 'completed'])->default('assigned');
    $table->timestamps();
});
```

## 3. Model Implementation

### 3.1 User Model
```php
// app/Models/User.php
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'status'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function staff()
    {
        return $this->hasOne(Staff::class);
    }

    public function hasPermission($permission)
    {
        return $this->role->permissions->contains('name', $permission);
    }

    public function isSuperAdmin()
    {
        return $this->role->name === 'super_admin';
    }

    public function isAdmin()
    {
        return $this->role->name === 'admin';
    }
}
```

### 3.2 Role Model
```php
// app/Models/Role.php
class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'display_name', 'description'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
```

### 3.3 Permission Model
```php
// app/Models/Permission.php
class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'display_name', 'description'];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
```

### 3.4 Staff Model
```php
// app/Models/Staff.php
class Staff extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'phone_number', 'department', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignedGuests()
    {
        return $this->hasMany(Guest::class, 'assigned_staff_id');
    }

    public function assignments()
    {
        return $this->hasMany(StaffAssignment::class);
    }
}
```

### 3.5 Template Model
```php
// app/Models/Template.php
class Template extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'html_content', 'css_styles', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }
}
```

### 3.6 Invitation Model
```php
// app/Models/Invitation.php
class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'location', 'event_date', 'template_id',
        'created_by', 'status', 'qr_code', 'whatsapp_message'
    ];

    protected $casts = [
        'event_date' => 'datetime',
    ];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function guests()
    {
        return $this->hasMany(Guest::class);
    }

    public function staffAssignments()
    {
        return $this->hasMany(StaffAssignment::class);
    }
}
```

### 3.7 Guest Model
```php
// app/Models/Guest.php
class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone_number', 'invitation_id',
        'assigned_staff_id', 'status', 'arrival_time'
    ];

    protected $casts = [
        'arrival_time' => 'datetime',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }

    public function assignedStaff()
    {
        return $this->belongsTo(Staff::class, 'assigned_staff_id');
    }

    public function assignments()
    {
        return $this->hasMany(StaffAssignment::class);
    }
}
```

## 4. Filament Resources Implementation

### 4.1 User Resource
```php
// app/Filament/Resources/UserResource.php
class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'User Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('role_id')
                    ->relationship('role', 'display_name')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role.display_name')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'active',
                        'danger' => 'inactive',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->relationship('role', 'display_name'),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ]),
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
}
```

### 4.2 Role Resource
```php
// app/Filament/Resources/RoleResource.php
class RoleResource extends Resource
{
    protected static ?string $model = Role::class;
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationGroup = 'User Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('display_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Select::make('permissions')
                    ->multiple()
                    ->relationship('permissions', 'display_name')
                    ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('display_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('users_count')
                    ->counts('users')
                    ->label('Users'),
                Tables\Columns\TextColumn::make('created_at')
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
}
```

### 4.3 Permission Resource
```php
// app/Filament/Resources/PermissionResource.php
class PermissionResource extends Resource
{
    protected static ?string $model = Permission::class;
    protected static ?string $navigationIcon = 'heroicon-o-key';
    protected static ?string $navigationGroup = 'User Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('display_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('display_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles_count')
                    ->counts('roles')
                    ->label('Roles'),
                Tables\Columns\TextColumn::make('created_at')
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
}
```

## 5. Authentication System Implementation

### 5.1 Authentication Controllers
```php
// app/Http/Controllers/Auth/LoginController.php
class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
```

### 5.2 Authentication Views
```blade
<!-- resources/views/auth/login.blade.php -->
@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Sign in to your account
            </h2>
        </div>
        <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <input name="email" type="email" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Email address">
                </div>
                <div>
                    <input name="password" type="password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Password">
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Sign in
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
```

## 6. Dashboard Implementation

### 6.1 Super Admin Dashboard
```php
// app/Filament/Pages/Dashboard.php
class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'filament.pages.dashboard';

    public function getTitle(): string
    {
        return 'Super Admin Dashboard';
    }

    protected function getHeaderWidgets(): array
    {
        return [
            Widgets\StatsOverview::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            Widgets\LatestUsers::class,
            Widgets\LatestInvitations::class,
        ];
    }
}
```

### 6.2 Admin Dashboard
```php
// app/Filament/Pages/AdminDashboard.php
class AdminDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'filament.pages.admin-dashboard';

    public function getTitle(): string
    {
        return 'Admin Dashboard';
    }

    protected function getHeaderWidgets(): array
    {
        return [
            Widgets\AdminStatsOverview::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            Widgets\StaffOverview::class,
            Widgets\GuestOverview::class,
        ];
    }
}
```

## 7. WhatsApp Integration Service

### 7.1 WhatsApp Service
```php
// app/Services/WhatsAppService.php
class WhatsAppService
{
    protected $apiUrl;
    protected $accessToken;

    public function __construct()
    {
        $this->apiUrl = config('services.whatsapp.api_url');
        $this->accessToken = config('services.whatsapp.access_token');
    }

    public function sendInvitation(Invitation $invitation, Guest $guest)
    {
        $message = $this->buildInvitationMessage($invitation, $guest);
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->accessToken,
            'Content-Type' => 'application/json',
        ])->post($this->apiUrl . '/messages', [
            'messaging_product' => 'whatsapp',
            'to' => $guest->phone_number,
            'type' => 'template',
            'template' => [
                'name' => 'invitation_template',
                'language' => [
                    'code' => 'en'
                ],
                'components' => [
                    [
                        'type' => 'body',
                        'parameters' => [
                            [
                                'type' => 'text',
                                'text' => $invitation->name
                            ],
                            [
                                'type' => 'text',
                                'text' => $invitation->location
                            ],
                            [
                                'type' => 'text',
                                'text' => $invitation->event_date->format('F j, Y g:i A')
                            ]
                        ]
                    ],
                    [
                        'type' => 'button',
                        'sub_type' => 'quick_reply',
                        'index' => 0,
                        'parameters' => [
                            [
                                'type' => 'text',
                                'text' => 'arrive'
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        return $response->successful();
    }

    protected function buildInvitationMessage(Invitation $invitation, Guest $guest)
    {
        return "You're invited to: {$invitation->name}\n" .
               "Location: {$invitation->location}\n" .
               "Date: {$invitation->event_date->format('F j, Y g:i A')}\n" .
               "Please confirm your arrival by clicking the button below.";
    }
}
```

## 8. QR Code Generation

### 8.1 QR Code Service
```php
// app/Services/QRCodeService.php
class QRCodeService
{
    public function generateQRCode(Invitation $invitation): string
    {
        $qrData = [
            'invitation_id' => $invitation->id,
            'guest_name' => $invitation->name,
            'event_date' => $invitation->event_date->toISOString(),
        ];

        $qrCode = QrCode::format('png')
            ->size(300)
            ->margin(10)
            ->generate(json_encode($qrData));

        $filename = 'qr_codes/' . $invitation->id . '_' . time() . '.png';
        Storage::disk('public')->put($filename, $qrCode);

        return $filename;
    }
}
```

## 9. Implementation Steps

### Phase 1: Foundation (Week 1-2)
1. Set up Laravel project with Filament 4
2. Create database migrations
3. Implement models with relationships
4. Set up basic authentication

### Phase 2: Core Features (Week 3-4)
1. Implement Filament resources for CRUD operations
2. Create role and permission system
3. Build basic admin dashboard
4. Implement user management

### Phase 3: Advanced Features (Week 5-6)
1. Create invitation and template system
2. Implement staff and guest management
3. Build WhatsApp integration
4. Add QR code generation

### Phase 4: Testing & Deployment (Week 7-8)
1. Comprehensive testing
2. Performance optimization
3. Security audit
4. Production deployment

## 10. Testing Strategy

### 10.1 Unit Tests
- Model relationships and methods
- Service class functionality
- Helper functions

### 10.2 Feature Tests
- Authentication flows
- CRUD operations
- Role-based access control
- WhatsApp integration

### 10.3 Browser Tests
- User interface functionality
- Dashboard interactions
- Form submissions

## 11. Deployment Considerations

### 11.1 Environment Configuration
- Database configuration
- WhatsApp API credentials
- File storage settings
- Cache configuration

### 11.2 Security Measures
- HTTPS enforcement
- Environment variable protection
- Database connection security
- File upload restrictions

### 11.3 Performance Optimization
- Database indexing
- Query optimization
- Caching strategies
- Asset optimization

This technical implementation plan provides a detailed roadmap for building your invitation system. Each component is designed to work together seamlessly while maintaining security and performance standards.
