# CRB Checker Kenya - Deployment Guide

## 404 Error Resolution

This guide helps resolve 404 errors when deploying the CRB Checker application.

### 1. Server Requirements
- **Apache** with mod_rewrite enabled
- **PHP** 7.4 or higher
- **MySQL** 5.7 or higher

### 2. Apache Configuration

#### Enable mod_rewrite:
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

#### Virtual Host Configuration:
Create `/etc/apache2/sites-available/crb-checker.conf`:

```apache
<VirtualHost *:80>
    ServerName crbchecker.local
    DocumentRoot /var/www/html/crb
    
    <Directory /var/www/html/crb>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
        
        # Handle PHP files
        <FilesMatch \.php$>
            SetHandler application/x-httpd-php
        </FilesMatch>
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/crb-checker-error.log
    CustomLog ${APACHE_LOG_DIR}/crb-checker-access.log combined
</VirtualHost>
```

Enable the site:
```bash
sudo a2ensite crb-checker.conf
sudo systemctl reload apache2
```

### 3. File Permissions

Set proper permissions:
```bash
sudo chown -R www-data:www-data /var/www/html/crb
sudo chmod -R 755 /var/www/html/crb
sudo chmod 644 /var/www/html/crb/.htaccess
```

### 4. Database Setup

1. Create database:
```sql
CREATE DATABASE crb_checker CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. Import database schema (if available)

### 5. Environment Configuration

Create `.env` file (if needed):
```
DB_HOST=localhost
DB_NAME=crb_checker
DB_USER=your_username
DB_PASS=your_password
```

### 6. Common 404 Fixes

#### Check .htaccess is working:
- Verify `.htaccess` exists in root directory
- Ensure `AllowOverride All` is set in Apache config
- Check Apache error logs: `sudo tail -f /var/log/apache2/error.log`

#### Test URLs:
- `http://yourdomain.com/` → Should load index.php
- `http://yourdomain.com/login` → Should load login.php
- `http://yourdomain.com/register` → Should load register.php

### 7. Nginx Configuration (Alternative)

If using Nginx, create `/etc/nginx/sites-available/crb-checker`:

```nginx
server {
    listen 80;
    server_name crbchecker.local;
    root /var/www/html/crb;
    index index.php index.html;

    location / {
        try_files $uri $uri/ @rewrite;
    }

    location @rewrite {
        rewrite ^/([a-zA-Z0-9_-]+)$ /$1.php last;
        rewrite ^/$ /index.php last;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

### 8. Troubleshooting

#### Check PHP processing:
```bash
php -v
# Should show PHP version

# Create test file
echo "<?php phpinfo(); ?>" > /var/www/html/crb/info.php
# Visit http://yourdomain.com/info.php
```

#### Check file permissions:
```bash
ls -la /var/www/html/crb/
# Ensure .htaccess is readable by web server
```

#### Check Apache modules:
```bash
apache2ctl -M | grep rewrite
# Should show rewrite_module
```

### 9. Testing Checklist

- [ ] .htaccess file exists and is readable
- [ ] mod_rewrite is enabled
- [ ] Apache AllowOverride is set to All
- [ ] PHP files are processed correctly
- [ ] Database connection works
- [ ] All major routes accessible:
  - [ ] /
  - [ ] /login
  - [ ] /register
  - [ ] /pricing
  - [ ] /report

### 10. Debug Commands

```bash
# Check Apache error logs
sudo tail -f /var/log/apache2/error.log

# Check access logs
sudo tail -f /var/log/apache2/access.log

# Test PHP syntax
php -l index.php

# Check file permissions
ls -la
```

## Support

If issues persist:
1. Check server error logs
2. Verify .htaccess syntax
3. Ensure PHP is properly configured
4. Test with a simple PHP file first
