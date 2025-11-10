# Setup Guide for Dothome Hosting

This guide will help you deploy the Coding Learning Platform on Dothome hosting.

## Prerequisites

- Dothome hosting account
- FTP client (e.g., FileZilla)
- MySQL database access via phpMyAdmin
- Basic understanding of PHP and MySQL

## Step-by-Step Deployment

### 1. Database Setup

1. **Login to Dothome's phpMyAdmin**
   - Access through your Dothome control panel
   - Navigate to phpMyAdmin

2. **Create New Database**
   ```sql
   CREATE DATABASE your_database_name CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

3. **Import Database Schema**
   - Select your newly created database
   - Click on "Import" tab
   - Choose file: `sql/init.sql`
   - Click "Go" to execute

4. **Verify Tables Created**
   - Check that `users`, `problems`, and `submissions` tables exist
   - Verify sample data is inserted

### 2. File Upload via FTP

1. **Connect to Dothome FTP**
   - Host: your-domain.dothome.co.kr
   - Username: your-ftp-username
   - Password: your-ftp-password
   - Port: 21

2. **Upload Files**
   - Upload all files to your web root directory (usually `public_html` or `html`)
   - Maintain the directory structure

3. **Files to Upload:**
   ```
   /api/
   /config/
   /css/
   /js/
   /sql/
   /templates/
   *.php files (index.php, login.php, etc.)
   ```

4. **Do NOT Upload:**
   - `.git/` directory
   - `.env` file (create this manually on server)
   - Any local development files

### 3. Configuration

1. **Create .env file on Server**
   - Using FTP or file manager, create `.env` file in root directory
   - Copy content from `.env.example`
   - Update with your actual database credentials:
   ```env
   DB_HOST=localhost
   DB_NAME=your_actual_database_name
   DB_USER=your_database_username
   DB_PASS=your_database_password
   APP_ENV=production
   APP_URL=https://your-domain.dothome.co.kr
   ```

2. **Set File Permissions**
   - `.env` file: 644 (read-only for security)
   - PHP files: 644
   - Directories: 755

### 4. Apache Configuration

Create `.htaccess` file in root directory if not exists:

```apache
# Enable Rewrite Engine
RewriteEngine On

# Redirect to index.php if file doesn't exist
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]

# Security Headers
<IfModule mod_headers.c>
    Header set X-Content-Type-Options "nosniff"
    Header set X-Frame-Options "SAMEORIGIN"
    Header set X-XSS-Protection "1; mode=block"
</IfModule>

# Prevent directory browsing
Options -Indexes

# Protect sensitive files
<FilesMatch "^\.env|^\.git|\.sql$">
    Order allow,deny
    Deny from all
</FilesMatch>

# PHP settings
php_value upload_max_filesize 10M
php_value post_max_size 10M
php_value max_execution_time 30
php_value session.cookie_httponly 1
```

### 5. Testing

1. **Access Your Site**
   - Navigate to: https://your-domain.dothome.co.kr

2. **Test Login**
   - Username: `admin`
   - Password: `admin123`
   - **Important: Change this password immediately!**

3. **Verify Functionality**
   - User registration
   - Problem listing
   - Admin panel access
   - Problem creation

### 6. Post-Deployment Security

1. **Change Admin Password**
   - Login as admin
   - Navigate to profile settings
   - Change password immediately

2. **Review Database**
   - Remove any test data if needed
   - Verify user roles are correct

3. **Check Permissions**
   - Ensure `.env` is not publicly accessible
   - Test that sensitive directories are protected

4. **Enable Error Logging**
   - Set `APP_ENV=production` in `.env`
   - Check error logs regularly

### 7. Common Issues and Solutions

#### Problem: "Database connection failed"
**Solution:**
- Verify database credentials in `.env`
- Check if database exists
- Ensure database user has proper permissions

#### Problem: "Page not found" errors
**Solution:**
- Check `.htaccess` is uploaded
- Verify mod_rewrite is enabled on server
- Check file paths in includes

#### Problem: "Permission denied" errors
**Solution:**
- Set correct file permissions (644 for files, 755 for directories)
- Ensure web server user has read access

#### Problem: Session not working
**Solution:**
- Check if sessions directory is writable
- Verify `session.save_path` in PHP settings
- Ensure cookies are enabled

### 8. Maintenance

1. **Regular Backups**
   - Backup database weekly
   - Backup files monthly
   - Store backups off-site

2. **Update Content**
   - Add new problems regularly
   - Monitor user submissions
   - Review and moderate content

3. **Security Updates**
   - Keep PHP version updated
   - Review security logs
   - Monitor for suspicious activity

4. **Performance Monitoring**
   - Check page load times
   - Monitor database size
   - Optimize queries if needed

## Support

For issues or questions:
1. Check the main README.md file
2. Review Dothome documentation
3. Contact support team

## Additional Resources

- Dothome Help Center: https://help.dothome.co.kr
- PHP Documentation: https://www.php.net/docs.php
- MySQL Documentation: https://dev.mysql.com/doc/

---

**Last Updated:** 2024-11-10
