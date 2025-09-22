# PHP Parking Management System

A complete parking management system built with PHP and MySQL, converted from the original Flask/Python version.

## Features

- **User Registration & Authentication**
  - Multi-car registration per user
  - Role-based access (Admin/User)
  - Secure password hashing

- **User Features**
  - Browse available parking lots
  - Book parking spots
  - Manage registered cars
  - View booking history
  - Cancel reservations (before entry)

- **Admin Features**
  - Create/Edit/Delete parking lots
  - Manage all reservations
  - Mark entries and exits
  - Calculate parking costs
  - Filter and search functionality

## Setup Instructions

1. **Database Setup**
   - Create a MySQL database named `parking_db`
   - Update database credentials in `config/database.php`
   - Run: `php init_db.php` to create tables

2. **Web Server**
   - Place files in your web server directory
   - Ensure PHP 7.4+ and MySQL are installed
   - Access via `http://localhost/php_parking_project/`

3. **Default Admin Accounts**
   - Email: `harish@admin.com` / Password: `first`
   - Email: `akil@admin.com` / Password: `first`

## File Structure

```
php_parking_project/
├── config/
│   └── database.php          # Database configuration
├── models/
│   ├── User.php             # User model
│   ├── Car.php              # Car model
│   ├── ParkingLot.php       # Parking lot model
│   └── Reservation.php      # Reservation model
├── templates/
│   ├── base.php             # Base template
│   ├── login.php            # Login page
│   ├── register.php         # Registration page
│   ├── user_dashboard.php   # User dashboard
│   ├── user_profile.php     # Car management
│   ├── user_history.php     # Booking history
│   ├── admin_dashboard.php  # Admin dashboard
│   ├── admin_reservations.php # Reservation management
│   ├── create_lot.php       # Create parking lot
│   └── edit_lot.php         # Edit parking lot
├── includes/
│   └── session.php          # Session management
├── init_db.php              # Database initialization
└── [Various PHP controllers]
```

## Technology Stack

- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Frontend**: Bootstrap 5, HTML5, JavaScript
- **Icons**: Bootstrap Icons

## Key Differences from Flask Version

- Uses MySQL instead of SQLite
- PHP sessions instead of Flask-Login
- PDO for database operations
- Template inclusion instead of Jinja2
- Native PHP password hashing
