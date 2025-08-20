<?php
// Database connection test script
echo "<h2>Database Connection Test</h2>";

// Test different connection scenarios
$test_hosts = [
    'localhost' => 'Local database server',
    '127.0.0.1' => 'Local database server (IP)',
    '172.18.180.9' => 'Remote database server',
    'mysql' => 'Docker/MySQL service name'
];

foreach ($test_hosts as $host => $description) {
    echo "<h3>Testing: $description ($host)</h3>";
    
    try {
        $start = microtime(true);
        
        $dsn = "mysql:host=$host;dbname=grandpac_crb_checker_ke;charset=utf8mb4";
        $conn = new PDO($dsn, 'grandpac_nash1', 'Kenya@50', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 5
        ]);
        
        // Test connection
        $stmt = $conn->query("SELECT 1");
        $result = $stmt->fetch();
        
        $end = microtime(true);
        $duration = round(($end - $start) * 1000, 2);
        
        echo "<p style='color: green'>✅ SUCCESS: Connected in {$duration}ms</p>";
        
    } catch(PDOException $e) {
        echo "<p style='color: red'>❌ FAILED: " . $e->getMessage() . "</p>";
    }
}

// Additional network diagnostics
echo "<h3>Network Diagnostics</h3>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>PDO MySQL available: " . (extension_loaded('pdo_mysql') ? 'Yes' : 'No') . "</p>";

// Test if port 3306 is accessible
$host = '172.18.180.9';
$port = 3306;
$connection = @fsockopen($host, $port, $errno, $errstr, 5);

if ($connection) {
    echo "<p style='color: green'>✅ Port 3306 is accessible on $host</p>";
    fclose($connection);
} else {
    echo "<p style='color: red'>❌ Port 3306 is NOT accessible on $host: $errstr ($errno)</p>";
}

// Check if MySQL service is running
echo "<h3>MySQL Service Check</h3>";
echo "<p>Recommended next steps:</p>";
echo "<ol>";
echo "<li>Verify MySQL service is running on the database server</li>";
echo "<li>Check firewall rules allowing port 3306</li>";
echo "<li>Confirm database user has remote access permissions</li>";
echo "<li>Test connection from command line: mysql -h 172.18.180.9 -u grandpac_nash1 -p</li>";
echo "</ol>";
?>
