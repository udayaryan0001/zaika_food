# Zaika-e-Handi Restaurant Management System

A comprehensive restaurant management system built with PHP, MySQL, and modern web technologies.

## Features

- User Authentication (Admin/Customer)
- Menu Management
- Image Gallery
- Order Management
- Newsletter Subscription
- Responsive Design
- Admin Dashboard
- Real-time Updates

## Tech Stack

- PHP 7.4+
- MySQL 5.7+
- HTML5/CSS3
- JavaScript (ES6+)
- Tailwind CSS
- Font Awesome
- FancyBox

## Prerequisites

- XAMPP (or similar PHP development environment)
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web browser (Chrome, Firefox, Safari)

## Installation

1. Clone the repository:
```bash
git clone https://github.com/udayaryan0001/zaika_food.git
```

2. Move the project to your XAMPP htdocs directory:
```bash
mv zaika_food /Applications/XAMPP/htdocs/
```

3. Create a new MySQL database named 'zaika'

4. Import the database schema:
- Open phpMyAdmin
- Select the 'zaika' database
- Import the `database.sql` file

5. Configure the database connection:
- Copy `config.example.php` to `config.php`
- Update the database credentials in `config.php`

6. Create required directories:
```bash
mkdir -p images/gallery images/menu
chmod 777 images/gallery images/menu
```

7. Access the application:
```
http://localhost/zaika_food
```

## Default Admin Credentials

- Email: admin@zaika.com
- Password: password

## Directory Structure

```
zaika_food/
├── admin/           # Admin dashboard and management
├── php/            # PHP backend files
├── images/         # Uploaded images
├── css/           # Stylesheets
├── js/            # JavaScript files
├── database.sql   # Database schema
└── README.md      # Documentation
```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Contact

Uday Aryan - [@udayaryan0001](https://github.com/udayaryan0001) 