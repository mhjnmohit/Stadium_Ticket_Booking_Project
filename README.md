# Stadium Ticket Booking System 🏟️🎟️

This is a web-based Stadium Ticket Booking System developed to manage match schedules, ticket booking, and admin control efficiently.

## Project Overview
The Stadium Ticket Booking System allows users to view upcoming matches, book tickets online, and enables the admin to manage match schedules and bookings through a secure admin panel.

## Features

### User Features
- View upcoming matches
- Online ticket booking
- Seat availability check
- Booking confirmation

### Admin Features
- Secure admin login
- Add, update, and delete match schedules
- Manage ticket bookings
- View booking details
- Separate admin dashboard

## Tech Stack
- Frontend: HTML, CSS, JavaScript
- Backend: PHP
- Database: MySQL
- Server: XAMPP / Apache

## How to Run the Project

1. Download or clone the repository
2. Install XAMPP and start Apache & MySQL
3. Move the project folder to:
4. Import the database:
- Open phpMyAdmin
- Create a database (example: `stadium_booking`)
- Import the provided `.sql` file
5. Update database connection in `config.php`
6. Open browser and visit:


## 📄 Database Details – Stadium Ticket Booking System
- Database Name: stadiumdb
- Database Type: MySQL
- Database File: stadiumdb.sql

## Database Setup Steps
1. Open XAMPP Control Panel
2. Start Apache and MySQL
3. Open browser and go to phpMyAdmin
4. Create a new database named: stadiumdb
5. Select the database and click on Import
6. Import the file: stadiumdb.sql
7. Database tables will be created automatically

## Folder Structure

Stadium_Ticket_Booking/
├── admin/          # Admin panel files
├── img/            # Images used in the project
├── phpmailer/      # Email functionality
├── TeamMembers/    # Team member details
│
├── about.php       # About page
├── check_login.php # Login validation
├── contact.php     # Contact page
├── home.php        # Home page
├── index.php       # Main entry point
├── logout.php      # Logout functionality
├── matches.php     # Match listing
├── pay.php         # Payment handling
├── seats.php       # Seat selection
│__ stadiumdb.sql   # database sql file
└── README.md

## Future Enhancements
- Online payment integration
- Seat map selection
- Email & SMS ticket confirmation
- QR code based ticket validation

## Author
Developed by Mohit Mahajan 
