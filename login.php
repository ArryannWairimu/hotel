<?php
include 'config.php';
ob_start();
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (!isset($conn)) {
        die("Database connection error.");
    }

    // Use prepared statements for security
    $stmt = $conn->prepare("SELECT userID, role, password FROM users WHERE email = ?");
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user["password"])) {
                $_SESSION["userID"] = $user["userID"];
                $_SESSION["role"] = $user["role"];

                // Redirect based on role
                if ($user["role"] === "admin") {
                    header("Location: admin_dashboard.php");
                    exit();
                } else {
                    header("Location: my_bookings.php");
                    exit();
                }
            } else {
                echo "<script>alert('Incorrect password.'); window.location='login.php';</script>";
            }
        } else {
            echo "<script>alert('User not found.'); window.location='login.php';</script>";
        }
        $stmt->close();
    } else {
        die("An error occurred. Please try again later.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: url('data:image/svg+xml;charset=utf-8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%230084d1" fill-opacity="1" d="M0,96L60,128C120,160,240,224,360,218.7C480,213,600,139,720,138.7C840,139,960,213,1080,213.3C1200,213,1320,139,1380,96L1440,53.3L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path></svg>');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
    </style>
</head>
<body class="flex justify-center items-center h-screen">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-2xl font-bold text-center text-blue-600">Login</h2>
        
        <form method="POST" class="space-y-4">
            <input type="email" name="email" placeholder="Email" required class="w-full p-2 border rounded">
            <input type="password" name="password" placeholder="Password" required class="w-full p-2 border rounded">
            
            <a href="forgot_password.php" class="text-blue-600 text-sm block text-right">Forgot Password?</a>
            
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Login</button>
        </form>
        
        <div class="mt-4 text-center">
            <p>Or sign in with</p>
            <div class="flex justify-center space-x-3 mt-2">
                <button class="w-1/2 flex items-center justify-center bg-gray-100 border rounded p-2">
                   <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5 mr-2">

                    Google
                </button>
                <button class="w-1/2 flex items-center justify-center bg-gray-100 border rounded p-2">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg" class="w-5 h-5 mr-2">
                    Apple
                </button>
            </div>
        </div>

        <p class="text-center mt-4">No account yet? <a href="register.php" class="text-blue-600">Register</a></p>
    </div>
</body>
</html>
