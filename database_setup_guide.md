# MySQL Database Setup Guide

## Option 1: Install MySQL Locally (Recommended for Development)

### Step 1: Install MySQL
```bash
# Update package list
sudo apt update

# Install MySQL Server
sudo apt install mysql-server mysql-client -y

# Start MySQL service
sudo systemctl start mysql
sudo systemctl enable mysql

# Secure installation
sudo mysql_secure_installation
```

### Step 2: Access MySQL
```bash
# Login as root
sudo mysql -u root -p

# Or login without password (if just installed)
sudo mysql
```

### Step 3: Create Database and User
```sql
-- Create database
CREATE DATABASE grandpac_crb_checker_ke;

-- Create user with password
CREATE USER 'grandpac_nash1'@'localhost' IDENTIFIED BY 'Kenya@50';

-- Grant permissions
GRANT ALL PRIVILEGES ON grandpac_crb_checker_ke.* TO 'grandpac_nash1'@'localhost';
FLUSH PRIVILEGES;
```

### Step 4: Import Database Structure
```bash
# Run the setup script
mysql -u root -p grandpac_crb_checker_ke < setup_database.sql
```

## Option 2: Use Remote Database (Production)

### Update db.php for remote connection:
```php
// Change from:
define('DB_HOST', 'localhost');

// To:
define('DB_HOST', '172.18.180.9');
```

## Option 3: Use Docker (Alternative)

### Step 1: Install Docker
```bash
# Install Docker
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh

# Start Docker
sudo systemctl start docker
sudo systemctl enable docker
```

### Step 2: Run MySQL in Docker
```bash
# Run MySQL container
docker run --name mysql-crb -e MYSQL_ROOT_PASSWORD=root -e MYSQL_DATABASE=grandpac_crb_checker_ke -e MYSQL_USER=grandpac_nash1 -e MYSQL_PASSWORD=Kenya@50 -p 3306:3306 -d mysql:latest
```

## Verification Steps

### After installation, test your connection:
```bash
# Test database connection
php test_db_cli.php

# Test with MySQL client
mysql -u grandpac_nash1 -p grandpac_crb_checker_ke
```

### Update db.php based on your setup:
- **Local MySQL**: Use `localhost`
- **Docker MySQL**: Use `localhost`
- **Remote MySQL**: Use the provided IP address

## Quick Start Commands

### Install MySQL and setup database:
```bash
# Make install script executable
chmod +x install_mysql.sh

# Run installation
./install_mysql.sh

# Setup database
sudo mysql < setup_database.sql
```

### Test the connection:
```bash
php test_db_cli.php
```

Your database connection timeout should now be resolved once MySQL is properly installed and configured!
