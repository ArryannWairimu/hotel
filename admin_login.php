<?php
session_start();
ob_start();
include 'config.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$error = ""; // Initialize error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (!empty($email) && !empty($password)) {
        // Prepare and execute the SQL query
        if ($stmt = $conn->prepare("SELECT adminID, name, password FROM admins WHERE email = ? LIMIT 1")) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $admin = $result->fetch_assoc();
                
                if (password_verify($password, $admin["password"])) {
                    $_SESSION["adminID"] = $admin["adminID"];
                    $_SESSION["adminName"] = $admin["name"];
                    header("Location: admin_home.php");
                    exit();
                } else {
                    $error = "Invalid password!";
                }
            } else {
                $error = "Admin not found!";
            }
            $stmt->close();
        } else {
            $error = "Database query failed!";
        }
    } else {
        $error = "Please fill in all fields!";
    }
}
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Hotel Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('data:image/svg+xml;charset=UTF-8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%236485ED" fill-opacity="1" d="M0,192L40,186.7C80,181,160,171,240,149.3C320,128,400,96,480,122.7C560,149,640,235,720,256C800,277,880,235,960,192C1040,149,1120,107,1200,117.3C1280,128,1360,192,1400,224L1440,256L1440,0L1400,0C1360,0,1280,0,1200,0C1120,0,1040,0,960,0C880,0,800,0,720,0C640,0,560,0,480,0C400,0,320,0,240,0C160,0,80,0,40,0L0,0Z"></path></svg>');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            width: 100%;
            max-width: 380px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .form-control {
            font-size: 14px;
            padding: 8px;
        }
        .login-container p {
            font-size: 14px;
            margin: 8px 0;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h4>Admin Login</h4>
    <?php if (!empty($error)) : ?>
        <div class="alert alert-danger"> <?php echo htmlspecialchars($error); ?> </div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="mb-2">
            <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="mb-2">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
        <p><a href="#">Forgot password?</a></p>
        <p>Don't have an account? <a href="admin_register.php">Register</a></p>
    </form>
</div>

</body>
</html>