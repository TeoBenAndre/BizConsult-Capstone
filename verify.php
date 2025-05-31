<?php
include('db.php');

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    
    // Check if token exists and is not expired
    $sql = "SELECT uv.*, u.email 
            FROM user_verification uv 
            JOIN users u ON uv.user_id = u.id 
            WHERE uv.verification_token = ? 
            AND uv.token_expiry > NOW() 
            AND uv.is_verified = 0";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $verification = $result->fetch_assoc();
        
        // Start transaction
        $conn->begin_transaction();
        
        try {
            // Update user verification status
            $update_sql = "UPDATE users SET is_verified = 1 WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("i", $verification['user_id']);
            $update_stmt->execute();
            
            // Mark verification token as used
            $mark_used_sql = "UPDATE user_verification SET is_verified = 1 WHERE verification_token = ?";
            $mark_used_stmt = $conn->prepare($mark_used_sql);
            $mark_used_stmt->bind_param("s", $token);
            $mark_used_stmt->execute();
            
            // Commit transaction
            $conn->commit();
            
            $message = "Email verified successfully! You can now login to your account.";
            $message_type = "success";
        } catch (Exception $e) {
            // Rollback transaction on error
            $conn->rollback();
            $message = "Error verifying email. Please try again.";
            $message_type = "error";
        }
    } else {
        $message = "Invalid or expired verification link.";
        $message_type = "error";
    }
} else {
    $message = "No verification token provided.";
    $message_type = "error";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification - BizConsult</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            width: 100%;
        }
        .header h1 {
            color: #4CAF50;
            font-size: 2.5em;
            margin: 0;
            padding: 20px 0;
        }
        .verification-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .success {
            background-color: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
        }
        .error {
            background-color: #ffebee;
            color: #c62828;
            border: 1px solid #ffcdd2;
        }
        .login-btn {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }
        .login-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Welcome to BizConsult</h1>
    </div>
    <div class="verification-container">
        <div class="message <?php echo $message_type; ?>">
            <?php echo $message; ?>
        </div>
        <?php if ($message_type === "success"): ?>
            <a href="login.php" class="login-btn">Go to Login</a>
        <?php endif; ?>
    </div>
</body>
</html>
