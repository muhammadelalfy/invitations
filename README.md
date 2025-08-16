# Invitation Management System

A comprehensive Laravel-based invitation management system with role-based access control, featuring separate dashboards for super administrators and regular administrators.

## Features

### 🎯 Core Functionality
- **Role-Based Access Control**: Separate dashboards for super admin and admin users
- **Invitation Management**: Create, edit, and manage event invitations
- **Template Builder**: Customizable invitation templates with HTML/CSS/JS support
- **Staff Management**: Manage event staff and assignments
- **Guest Management**: Track guests and their arrival status
- **WhatsApp Integration**: Send invitations via WhatsApp (ready for API integration)
- **QR Code System**: Generate and track QR codes for guest arrival

### 👥 User Roles

#### Super Administrator
- Full system access and control
- User, role, and permission management
- Invitation and template creation
- System configuration and monitoring

#### Administrator
- Staff and guest management
- Event coordination and tracking
- Limited invitation access (view-only)
- Guest assignment and arrival tracking

## Technology Stack

- **Backend**: Laravel 12 (PHP 8.3+)
- **Admin Panel**: Filament 3
- **Frontend**: Livewire 3, Alpine.js, Tailwind CSS
- **Database**: MySQL/PostgreSQL
- **Authentication**: Laravel Sanctum

## Installation

### Prerequisites
- PHP 8.3 or higher
- Composer
- MySQL/PostgreSQL
- Node.js & NPM

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd invitations
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database configuration**
   - Update `.env` file with your database credentials
   - Run migrations and seeders:
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Build frontend assets**
   ```bash
   npm run build
   ```

7. **Start the development server**
   ```bash
   php artisan serve
   ```

## Default Access

### Super Administrator
- **URL**: `/super-admin`
- **Email**: `superadmin@example.com`
- **Password**: `password`

### Administrator
- **URL**: `/admin`
- **Email**: Register a new account (will be assigned admin role by default)

## System Architecture

### Database Structure
- **Users**: System users with role assignments
- **Roles**: User roles with permission sets
- **Permissions**: Granular system permissions
- **Invitations**: Event invitations with templates
- **Templates**: Reusable invitation templates
- **Staff**: Event staff members
- **Guests**: Event attendees
- **Staff Assignments**: Staff-guest relationships

### File Structure
```
app/
├── Filament/
│   ├── Admin/           # Admin panel resources
│   └── SuperAdmin/      # Super admin panel resources
├── Http/Controllers/
│   └── Auth/            # Authentication controllers
├── Models/              # Eloquent models
└── Providers/
    └── Filament/        # Panel providers

resources/
└── views/
    └── auth/            # Authentication views

database/
├── migrations/          # Database migrations
└── seeders/            # Database seeders
```

## Usage Guide

### Creating Invitations (Super Admin)

1. **Access Super Admin Panel**
   - Navigate to `/super-admin`
   - Login with super admin credentials

2. **Create Template**
   - Go to Templates → Create Template
   - Use the rich editor for HTML content
   - Add custom CSS and JavaScript
   - Set thumbnail image

3. **Create Invitation**
   - Go to Invitations → Create Invitation
   - Select template
   - Add event details (name, location, date)
   - Customize WhatsApp message
   - Set status to "Active"

4. **Send Invitations**
   - Use the "Send WhatsApp" action
   - Monitor guest responses

### Managing Staff and Guests (Admin)

1. **Access Admin Panel**
   - Navigate to `/admin`
   - Login with admin credentials

2. **Add Staff Members**
   - Go to Staff → Create Staff
   - Fill in staff details
   - Assign to specific events

3. **Manage Guests**
   - Go to Guests → Create Guest
   - Assign to invitations
   - Assign staff members
   - Track arrival status

4. **Event Coordination**
   - Monitor guest responses
   - Track staff assignments
   - Mark guest arrivals

## API Endpoints

### Authentication
- `POST /api/auth/login` - User login
- `POST /api/auth/register` - User registration
- `POST /api/auth/logout` - User logout
- `POST /api/auth/forgot-password` - Password reset request
- `POST /api/auth/reset-password` - Password reset

### Invitations
- `GET /api/invitations` - List invitations
- `POST /api/invitations` - Create invitation
- `GET /api/invitations/{id}` - Get invitation details
- `PUT /api/invitations/{id}` - Update invitation
- `DELETE /api/invitations/{id}` - Delete invitation
- `POST /api/invitations/{id}/send` - Send invitation

### Guests
- `GET /api/guests` - List guests
- `POST /api/guests` - Create guest
- `GET /api/guests/{id}` - Get guest details
- `PUT /api/guests/{id}` - Update guest
- `DELETE /api/guests/{id}` - Delete guest
- `POST /api/guests/{id}/arrive` - Mark guest arrival

## Customization

### Adding New Roles
1. Create role in Super Admin panel
2. Assign appropriate permissions
3. Assign roles to users

### Custom Permissions
1. Add permission to database
2. Update role assignments
3. Implement permission checks in code

### Template Customization
1. Use the rich editor for HTML
2. Add custom CSS for styling
3. Include JavaScript for interactivity
4. Preview templates before saving

## Security Features

- **Role-Based Access Control**: Granular permission system
- **CSRF Protection**: Cross-site request forgery prevention
- **Input Validation**: Comprehensive form validation
- **Password Security**: Bcrypt hashing
- **Session Management**: Secure session handling

## Development

### Running Tests
```bash
php artisan test
```

### Code Formatting
```bash
vendor/bin/pint
```

### Database Seeding
```bash
php artisan db:seed
```

## Deployment

### Production Requirements
- SSL certificate
- Database optimization
- Cache configuration
- Queue worker setup
- File storage configuration

### Environment Variables
- Database credentials
- Mail configuration
- File storage settings
- WhatsApp API credentials (when integrated)

## Support

### Documentation
- Business Analysis: `BLUEPRINT_BUSINESS_ANALYSIS.md`
- Technical Analysis: `BLUEPRINT_TECHNICAL_ANALYSIS.md`

### Common Issues
1. **Permission Denied**: Check user role and permissions
2. **Template Not Loading**: Verify template is active
3. **Migration Errors**: Check database connection and credentials

## Contributing

1. Fork the repository
2. Create feature branch
3. Make changes
4. Run tests
5. Submit pull request

## License

This project is licensed under the MIT License.

## Acknowledgments

- Laravel team for the excellent framework
- Filament team for the admin panel solution
- All contributors and maintainers
