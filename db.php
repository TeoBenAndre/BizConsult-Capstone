<?php
$servername = "localhost"; // Your MySQL server
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "bizconsult"; // The database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if is_verified column exists in users table
$result = $conn->query("SHOW COLUMNS FROM users LIKE 'is_verified'");
if ($result->num_rows == 0) {
    // Add is_verified column if it doesn't exist
    $sql = "ALTER TABLE users ADD COLUMN is_verified TINYINT(1) DEFAULT 0";
    $conn->query($sql);
}

// Check if user_verification table exists
$result = $conn->query("SHOW TABLES LIKE 'user_verification'");
if ($result->num_rows == 0) {
    // Create user_verification table if it doesn't exist
    $sql = "CREATE TABLE user_verification (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        verification_token VARCHAR(255) NOT NULL,
        token_expiry DATETIME NOT NULL,
        is_verified TINYINT(1) DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )";
    $conn->query($sql);
}
?>
