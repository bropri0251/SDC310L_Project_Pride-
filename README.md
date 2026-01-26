# SDC310L PHP Shopping Cart Application

A modern, MVC-structured PHP shopping cart application built with clean architecture and responsive design.

## Table of Contents
- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Database Setup](#database-setup)
- [Usage](#usage)
- [Project Structure](#project-structure)
- [Technologies Used](#technologies-used)
- [Contributing](#contributing)

## Features

- **MVC Architecture**: Clean separation of concerns with Models, Views, and Controllers
- **Session-based Cart**: Persistent shopping cart using PHP sessions
- **Product Catalog**: Display of gaming/tech products with descriptions and prices
- **Cart Management**: Add, remove, increment, decrement items in cart
- **Order Calculation**: Automatic tax and shipping calculations
- **Responsive Design**: Modern, mobile-friendly UI with dark theme
- **Database Integration**: MySQL database for products and cart persistence

## Requirements

- **XAMPP** (or similar Apache/MySQL/PHP stack)
- **PHP 7.4+**
- **MySQL 5.7+**
- **Web Browser** (Chrome, Firefox, Safari, Edge)

## Installation

1. **Clone/Download the project** to your XAMPP htdocs directory:
   ```
   C:\xampp\htdocs\sdc310L_Project_Pride\
   ```

2. **Start XAMPP** and ensure Apache and MySQL services are running

3. **Access the application** at:
   - Main Application: http://localhost/sdc310L_Project_Pride/public/
   - Catalog: http://localhost/sdc310L_Project_Pride/public/index.php?page=catalog
   - Cart: http://localhost/sdc310L_Project_Pride/public/index.php?page=cart

## Database Setup

### Option 1: Using phpMyAdmin (Recommended)

1. Open phpMyAdmin: http://localhost/phpmyadmin
2. Create a new database named `SDC310L_Project_Pride`
3. Select the database and click "Import"
4. Choose the file: `sql/310L_WK2_Export_pride.sql`
5. Click "Go" to import

### Option 2: Command Line

```bash
# Navigate to the SQL directory
cd C:\xampp\htdocs\sdc310L_Project_Pride\sql

# Import the database
C:\xampp\mysql\bin\mysql.exe -u root SDC310L_Project_Pride < 310L_WK2_Export_pride.sql
```

## Usage

### Browsing Products
- Visit the catalog page to view all available products
- Each product shows name, description, price, and current quantity in cart

### Managing Cart
- **Add to Cart**: Click the "Add" button next to any product
- **Adjust Quantity**:
  - Use + and - buttons to increment/decrement
  - Use "Set Qty" input to set a specific quantity
- **Remove from Cart**: Click "Remove" to completely remove an item

### Checkout Process
- Click "Go to Cart" to view your items
- Review order summary with tax (5%) and shipping (10%) calculations
- Click "Check Out" to clear the cart and return to catalog

## Project Structure

```
c:\xampp\htdocs\sdc310L_Project_Pride\
├── app\                          # Application core
│   ├── controller\               # Controllers handle requests
│   │   ├── CatalogController.php # Product catalog logic
│   │   └── CartController.php    # Shopping cart logic
│   ├── model\                    # Models handle data
│   │   ├── CartModel.php         # Cart operations
│   │   ├── DatabaseModel.php     # Database connection
│   │   └── ProductModel.php      # Product data
│   └── view\                     # Views handle presentation
│       ├── catalog.php           # Product catalog view
│       └── cart.php              # Shopping cart view
├── public\                       # Public web root
│   └── index.php                 # Front controller
├── sql\                          # Database files
│   └── 310L_WK2_Export_pride.sql # Database schema & sample data
├── db.php                        # Database configuration
└── README.md                     # This file
```

## Technologies Used

- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Architecture**: MVC (Model-View-Controller)
- **Frontend**: HTML5, CSS3, Vanilla JavaScript
- **Styling**: Custom CSS with modern design patterns
- **Session Management**: PHP Sessions

## Design Features

- **Dark Theme**: Modern dark color scheme
- **Responsive Layout**: Works on desktop and mobile
- **Smooth Animations**: CSS transitions and hover effects
- **Accessibility**: Proper semantic HTML and ARIA labels
- **Performance**: Optimized queries and minimal dependencies

## Security Features

- **Input Sanitization**: All user inputs are validated
- **SQL Injection Protection**: Prepared statements used
- **Session Security**: Secure session handling
- **XSS Protection**: HTML escaping for output

## Contributing

This is a student project for SDC310L. For improvements:

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## Notes

- **Session-based**: Cart data persists during browser session
- **No User Accounts**: Simple session-based cart (no login required)
- **Sample Data**: Includes 60+ gaming/tech products
- **Educational Purpose**: Built for learning MVC patterns in PHP

## Troubleshooting

**Database Connection Issues:**
- Ensure MySQL service is running in XAMPP
- Check database credentials in `db.php`
- Verify database name matches configuration

**Page Not Loading:**
- Ensure Apache service is running
- Check file permissions
- Verify URL paths are correct

**Cart Not Working:**
- Check PHP session settings
- Ensure database tables are created
- Verify session_id() function works

---

**Student**: Broderick Pride
**Course**: SDC310L
**Project**: PHP Shopping Cart Application
**Date**: Week 2 Database Integration</content>
<parameter name="filePath">c:\xampp\htdocs\sdc310L_Project_Pride\README.md