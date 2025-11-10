# Coding Learning Platform

PHP 기반의 교육용 웹 플랫폼 (PHP-based Educational Web Platform)

## 📋 Overview

A comprehensive coding learning platform built with PHP, designed for hosting on Dothome or similar shared hosting services. This platform enables users to practice coding problems, submit solutions, and track their learning progress.

## ✨ Features

- **User Authentication**: Secure registration and login system with password hashing
- **Problem Management**: CRUD operations for coding problems with difficulty levels
- **Interactive Interface**: Bootstrap-based responsive design
- **Submission Tracking**: Monitor user submissions and progress
- **Admin Panel**: Administrative tools for managing problems and users
- **Security**: Built-in protection against SQL injection and XSS attacks
- **Database**: MySQL with well-structured schema

## 🗂️ Project Structure

```
coding-learning-platform/
├── api/                    # API endpoints
│   ├── auth.php           # Authentication API
│   └── problems.php       # Problems management API
├── config/                # Configuration files
│   └── config.php         # Database and app configuration
├── css/                   # Stylesheets
│   └── style.css          # Custom styles
├── js/                    # JavaScript files
│   ├── app.js             # Main application logic
│   └── problems.js        # Problems page functionality
├── sql/                   # Database scripts
│   └── init.sql           # Database initialization script
├── templates/             # Reusable templates
│   ├── header.php         # Page header
│   └── footer.php         # Page footer
├── index.php              # Homepage
├── login.php              # Login page
├── register.php           # Registration page
├── problems.php           # Problems listing page
├── dashboard.php          # User dashboard
├── .env.example           # Environment configuration example
└── .gitignore             # Git ignore rules
```

## 🚀 Installation

### Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- mod_rewrite enabled (for Apache)

### Step 1: Clone Repository

```bash
git clone https://github.com/mahyun-dev/coding-learning-platform.git
cd coding-learning-platform
```

### Step 2: Database Setup

1. Create a new MySQL database:
```sql
CREATE DATABASE coding_platform CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. Import the initialization script:
```bash
mysql -u your_username -p coding_platform < sql/init.sql
```

Or import via phpMyAdmin by uploading the `sql/init.sql` file.

### Step 3: Configuration

1. Copy the environment example file:
```bash
cp .env.example .env
```

2. Edit `.env` with your database credentials:
```env
DB_HOST=localhost
DB_NAME=coding_platform
DB_USER=your_username
DB_PASS=your_password
APP_ENV=production
APP_URL=https://your-domain.com
```

### Step 4: Set Permissions

```bash
chmod 644 .env
chmod 755 api/
chmod 755 config/
```

### Step 5: Access the Platform

Navigate to your domain in a web browser. Default admin credentials:
- Username: `admin`
- Password: `admin123`

**⚠️ Important: Change the admin password immediately after first login!**

## 🔧 Configuration

### Database Connection

Edit `config/config.php` to customize database settings or use environment variables in `.env` file.

### Security Settings

The platform includes several security features:

- **Password Hashing**: Uses bcrypt for secure password storage
- **Prepared Statements**: All database queries use prepared statements
- **Input Sanitization**: User inputs are sanitized to prevent XSS
- **CSRF Protection**: CSRF token generation and verification
- **Session Security**: HTTP-only, secure cookies

## 📖 Usage

### For Students

1. **Register**: Create an account using the registration page
2. **Browse Problems**: View available coding problems
3. **Solve Problems**: Submit your solutions
4. **Track Progress**: Monitor your achievements on the dashboard

### For Administrators

1. **Login**: Use admin credentials
2. **Manage Problems**: Create, edit, or delete coding problems
3. **View Submissions**: Monitor user submissions
4. **User Management**: Manage user accounts

## 🔐 API Endpoints

### Authentication (`api/auth.php`)

- `POST /api/auth.php?action=login` - User login
- `POST /api/auth.php?action=register` - User registration
- `GET /api/auth.php?action=logout` - User logout
- `GET /api/auth.php?action=check` - Check authentication status

### Problems (`api/problems.php`)

- `GET /api/problems.php?action=list` - List all problems
- `GET /api/problems.php?action=get&id={id}` - Get single problem
- `POST /api/problems.php` - Create problem (admin only)
- `PUT /api/problems.php` - Update problem (admin only)
- `DELETE /api/problems.php` - Delete problem (admin only)

## 🗄️ Database Schema

### Users Table
- `user_id`: Primary key
- `username`: Unique username
- `password`: Hashed password
- `email`: User email
- `role`: User role (student/admin)
- `created_at`: Registration timestamp
- `last_login`: Last login timestamp

### Problems Table
- `problem_id`: Primary key
- `title`: Problem title
- `description`: Problem description
- `difficulty`: Difficulty level (easy/medium/hard)
- `category`: Problem category
- `test_cases`: JSON test cases
- `solution_template`: Code template
- `created_at`: Creation timestamp
- `updated_at`: Last update timestamp

### Submissions Table
- `submission_id`: Primary key
- `user_id`: Foreign key to users
- `problem_id`: Foreign key to problems
- `code`: Submitted code
- `language`: Programming language
- `status`: Submission status
- `execution_time`: Execution time in ms
- `memory_used`: Memory usage
- `created_at`: Submission timestamp

## 🛠️ Development

### Adding New Features

1. Create API endpoints in the `api/` directory
2. Add frontend pages in the root directory
3. Update JavaScript in `js/` directory
4. Add styles to `css/style.css`

### Testing

Test your changes locally before deploying:

1. Set `APP_ENV=development` in `.env`
2. Enable error reporting in `config/config.php`
3. Test all API endpoints
4. Verify database operations

## 🚢 Deployment on Dothome

1. Upload files via FTP to your Dothome hosting
2. Import the database through phpMyAdmin
3. Update `.env` with production credentials
4. Set `APP_ENV=production`
5. Ensure `.htaccess` is configured properly

### Example .htaccess

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]

# Security headers
Header set X-Content-Type-Options "nosniff"
Header set X-Frame-Options "SAMEORIGIN"
Header set X-XSS-Protection "1; mode=block"
```

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License.

## 👥 Support

For issues, questions, or suggestions:
- Open an issue on GitHub
- Email: info@codingplatform.com

## 🔄 Version History

- **v1.0.0** (2024) - Initial release
  - Basic project structure
  - User authentication
  - Problem management
  - Submission tracking
  - Admin panel

## 🙏 Acknowledgments

- Bootstrap for the responsive UI framework
- Font Awesome for icons
- PHP community for best practices and security guidelines
