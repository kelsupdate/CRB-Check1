<?php
// Database configuration
// IMPORTANT: Update these settings based on your actual database location

// Option 1: If database is on same server as web server
define('DB_HOST', 'localhost');

// Option 2: If database is on remote server (uncomment and update IP)
// define('DB_HOST', '172.18.180.9');

// Option 3: If using external database service (update with actual host)
// define('DB_HOST', 'your-db-host.com');

define('DB_USER', 'grandpac_nash1');
define('DB_PASS', 'Kenya@50');
define('DB_NAME', 'grandpac_crb_checker_ke');

// Create connection with timeout settings
try {
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 10, // 10 second timeout
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
    ];
    
    $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4";
    $conn = new PDO($dsn, DB_USER, DB_PASS, $options);
    
    // Test connection
    $conn->query("SELECT 1");
    
} catch(PDOException $e) {
    // Log detailed error
    error_log("Database connection failed: " . $e->getMessage());
    
    // Provide user-friendly error
    die("Database connection failed. Please check your database settings or contact support.");
}

// Helper function to execute prepared statements
function executeQuery($sql, $params = []) {
    global $conn;
    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    } catch(PDOException $e) {
        error_log("Query failed: " . $e->getMessage());
        return false;
    }
}
?>
