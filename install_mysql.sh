#!/bin/bash
# MySQL Installation Script for Ubuntu/Debian

echo "=== MySQL Installation Guide ==="
echo ""

# Update package list
echo "1. Updating package list..."
sudo apt update

# Install MySQL Server
echo "2. Installing MySQL Server..."
sudo apt install mysql-server mysql-client -y

# Start MySQL service
echo "3. Starting MySQL service..."
sudo systemctl start mysql
sudo systemctl enable mysql

# Check MySQL status
echo "4. Checking MySQL status..."
sudo systemctl status mysql --no-pager

# Secure MySQL installation
echo "5. Securing MySQL installation..."
sudo mysql_secure_installation

echo ""
echo "=== MySQL Installation Complete ==="
echo "MySQL is now installed and running!"
echo ""
echo "Next steps:"
echo "1. Run: sudo mysql -u root -p"
echo "2. Create your database and user"
echo "3. Update db.php with correct credentials"
