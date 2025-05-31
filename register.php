<?php
include('db.php');

$message = '';
$message_type = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $user_type = $_POST['user_type'];
    $full_name = $_POST['full_name'];
    $phone_number = $_POST['phone_number'];

    // Check if the email already exists
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $message = "Email already registered.";
        $message_type = "error";
    } else {
        // Insert user into the users table with is_verified = 1
        $sql = "INSERT INTO users (email, password, user_type, full_name, phone_number, is_verified) VALUES (?, ?, ?, ?, ?, 1)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $email, $password, $user_type, $full_name, $phone_number);
        
        if ($stmt->execute()) {
            $message = "Registration successful! You can now login.";
            $message_type = "success";
            // Redirect to login page after 2 seconds
            header("refresh:2;url=login.php");
        } else {
            $message = "Error: " . $stmt->error;
            $message_type = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - BizConsult</title>
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
        .register-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        input[type="email"],
        input[type="password"],
        input[type="text"],
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .submit-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        .submit-btn:hover {
            background-color: #45a049;
        }
        .login-link {
            text-align: center;
            margin-top: 15px;
        }
        .login-link a {
            color: #4CAF50;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            text-align: center;
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
    </style>
</head>
<body>
    <div class="header">
        <h1>Welcome to BizConsult</h1>
    </div>
    <div class="register-container">
        <h2>Create an Account</h2>
        <?php if ($message): ?>
            <div class="message <?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="register.php">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="user_type">User Type:</label>
                <select id="user_type" name="user_type">
                    <option value="client">Client</option>
                    <option value="consultant">Consultant</option>
                </select>
            </div>
            <div class="form-group">
                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" name="full_name" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="text" id="phone_number" name="phone_number">
            </div>
            <button type="submit" class="submit-btn">Register</button>
        </form>
        <div class="login-link">
            Already have an account? <a href="login.php">Login here</a>
        </div>
    </div>
</body>
</html>
