<?php
// Database configuration - UPDATE THIS BASED ON YOUR TEST RESULTS

// For local development/testing, use localhost
define('DB_HOST', 'localhost');

// For production remote database (uncomment if needed)
// define('DB_HOST', '172.18.180.9');

define('DB_USER', 'grandpac_nash1');
define('DB_PASS', 'Kenya@50');
define('DB_NAME', 'grandpac_crb_checker_ke');

// Create connection with timeout settings
try {
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 15, // Increased timeout for slower connections
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
    ];
    
    $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4", DB_USER, DB_PASS, $options);
    
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
