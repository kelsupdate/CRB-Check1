<?php
// Database configuration helper
// Use this file to easily switch between different database configurations

// Choose your database configuration
// Uncomment ONE of the following options:

// Option 1: Local database (recommended for testing)
$config = [
    'host' => 'localhost',
    'user' => 'grandpac_nash1',
    'pass' => 'Kenya@50',
    'name' => 'grandpac_crb_checker_ke'
];

// Option 2: Remote database server
// $config = [
//     'host' => '172.18.180.9',
//     'user' => 'grandpac_nash1',
//     'pass' => 'Kenya@50',
//     'name' => 'grandpac_crb_checker_ke'
// ];

// Function to create database connection
function getDatabaseConnection() {
    global $config;
    
    try {
        $dsn = "mysql:host={$config['host']};dbname={$config['name']};charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 10,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ];
        
        return new PDO($dsn, $config['user'], $config['pass'], $options);
    } catch(PDOException $e) {
        error_log("Database connection failed: " . $e->getMessage());
        throw $e;
    }
}
?>
