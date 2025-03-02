<?php 
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $phone = $_POST["phone"];
    $address = $_POST["address"];

    $sql = "INSERT INTO users (name, email, password, phone, address) 
            VALUES ('$name', '$email', '$password', '$phone', '$address')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registration Successful! Please log in.'); window.location='login.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: url('data:image/svg+xml;charset=UTF-8,<svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg"><rect width="100%" height="100%" fill="%23cbd5e1"/><circle cx="30%" cy="40%" r="120" fill="%237f9cf5" opacity="0.3"/><circle cx="70%" cy="60%" r="80" fill="%234c51bf" opacity="0.3"/></svg>');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="flex justify-center items-center h-screen">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-2xl font-bold text-center text-blue-600">Register</h2>
        <form method="POST" class="space-y-4">
            <input type="text" name="name" placeholder="Full Name" required class="w-full p-2 border rounded">
            <input type="email" name="email" placeholder="Email" required class="w-full p-2 border rounded">
            <input type="password" name="password" placeholder="Password" required class="w-full p-2 border rounded">
            <input type="text" name="phone" placeholder="Phone" required class="w-full p-2 border rounded">
            <input type="text" name="address" placeholder="Address" class="w-full p-2 border rounded">
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Register</button>
        </form>

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

        <p class="text-center mt-2">Already have an account? <a href="login.php" class="text-blue-600">Login</a></p>
    </div>
</body>
</html>
