# XAMPP Setup Instructions

## Quick Start (5 minutes)

### 1. Start XAMPP Services
- Open XAMPP Control Panel
- Start **Apache** and **MySQL**

### 2. Create Database
- Go to: http://localhost/phpmyadmin
- Click "New" to create database
- Database name: `parking_db`
- Click "Create"
- Go to "Import" tab
- Choose file: `setup_database.sql`
- Click "Go"

### 3. Access Application
- URL: **http://localhost/parking**
- Default Admin Login:
  - Email: `harish@admin.com`
  - Password: `first`

### 4. Test User Registration
- Click "Register here" on login page
- Create a user account with car numbers
- Login and test booking system

## Troubleshooting

**Database Connection Error:**
- Check MySQL is running in XAMPP
- Verify database name is `parking_db`

**Page Not Found:**
- Ensure files are in `C:\xampp\htdocs\parking\`
- Check Apache is running

**Permission Issues:**
- Run XAMPP as Administrator

## Features to Test

✅ **User Side:**
- Register with multiple cars
- Browse parking lots
- Book spots
- View history
- Cancel bookings

✅ **Admin Side:**
- Create parking lots
- Manage reservations
- Mark entry/exit
- View all bookings