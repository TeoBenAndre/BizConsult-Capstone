<?php
session_start();
include('../db.php');

// Check if user is logged in and is a client
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'client') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard - BizConsult</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            margin: 0;
            font-size: 1.5rem;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .logout-btn {
            background-color: white;
            color: #4CAF50;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }
        .logout-btn:hover {
            background-color: #f0f0f0;
        }
        .dashboard-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }
        .dashboard-card {
            background-color: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .dashboard-card h2 {
            margin-top: 0;
            color: #333;
        }
        .welcome-message {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>BizConsult - Client Dashboard</h1>
        <div class="user-info">
            <span>Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?></span>
            <a href="../logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <div class="dashboard-container">
        <div class="welcome-message">
            <h2>Welcome to Your Dashboard</h2>
            <p>Here you can manage your consulting services and track your progress.</p>
        </div>

        <div class="dashboard-grid">
            <div class="dashboard-card">
                <h2>My Projects</h2>
                <p>View and manage your ongoing consulting projects.</p>
                <!-- Add project list or summary here -->
            </div>

            <div class="dashboard-card">
                <h2>Consultants</h2>
                <p>Browse and connect with available consultants.</p>
                <!-- Add consultant list or search here -->
            </div>

            <div class="dashboard-card">
                <h2>Messages</h2>
                <p>Check your messages and notifications.</p>
                <!-- Add message center here -->
            </div>

            <div class="dashboard-card">
                <h2>Profile Settings</h2>
                <p>Update your profile information and preferences.</p>
                <!-- Add profile settings here -->
            </div>
        </div>
    </div>
</body>
</html> 