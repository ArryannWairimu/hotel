<?php
session_start();
include 'config.php';

// Check if admin is logged in
if (!isset($_SESSION['adminID'])) {
    header("Location: admin_login.php");
    exit();
}

// Get admin details
$adminID = $_SESSION['adminID'];
$admin = $conn->query("SELECT * FROM admins WHERE adminID = $adminID")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #b3e5fc;
        }
    </style>
</head>
<body class="p-10 min-h-screen flex flex-col items-center text-white">
    <h1 class="text-4xl font-extrabold mb-6 animate-fade-in text-black">Welcome, <?= htmlspecialchars($admin['name']) ?> 👋</h1>

    <div class="grid grid-cols-1 md-grid-cols-3 gap-6 w-full max-w-4xl">
        <a href="manage_users.php" class="p-6 bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white text-lg font-bold rounded-xl shadow-xl transform hover:scale-105 transition-all duration-300">👤 Manage Users</a>
        <a href="manage_rooms.php" class="p-6 bg-gradient-to-r from-green-500 to-green-700 hover:from-green-600 hover:to-green-800 text-white text-lg font-bold rounded-xl shadow-xl transform hover:scale-105 transition-all duration-300">🏨 Manage Rooms</a>
        <a href="manage_bookings.php" class="p-6 bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-600 hover:to-purple-800 text-white text-lg font-bold rounded-xl shadow-xl transform hover:scale-105 transition-all duration-300">📅 Manage Bookings</a>
    </div>

    <div class="mt-6">
        <a href="admin_logout.php" class="p-3 bg-red-500 hover:bg-red-700 text-white rounded-lg shadow-lg transition duration-300 transform hover:scale-105">🚪 Logout</a>
    </div>
</body>
</html>
