<?php
include 'config.php';
session_start();

// Ensure only admin can access
if (!isset($_SESSION['adminID'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch users
$users = $conn->query("SELECT UserID, name, email FROM users");

// Fetch bookings
$bookings = $conn->query("
    SELECT b.BookingID, u.name, u.email, r.RoomType, r.Price, b.Status 
    FROM bookings b
    JOIN users u ON b.UserID = u.UserID
    JOIN rooms r ON b.RoomID = r.RoomID
");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-10 bg-gray-100">
    <h1 class="text-3xl font-bold mb-5">User Management</h1>

    <h2 class="text-xl font-semibold mb-3">User List</h2>
    <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-3 text-left">ID</th>
                <th class="p-3 text-left">Name</th>
                <th class="p-3 text-left">Email</th>
                <th class="p-3 text-left">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($user = $users->fetch_assoc()): ?>
                <tr class="border-t">
                    <td class="p-3"><?= htmlspecialchars($user['UserID'] ?? 'N/A') ?></td>
                    <td class="p-3"><?= htmlspecialchars($user['name'] ?? 'N/A') ?></td>
                    <td class="p-3"><?= htmlspecialchars($user['email'] ?? 'N/A') ?></td>
                    <td class="p-3">
                        <a href="delete_user.php?id=<?= $user['UserID'] ?? '' ?>" 
                           class="text-red-500" 
                           onclick="return confirm('Are you sure?')">🗑 Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h2 class="text-xl font-semibold mt-10 mb-3">User Bookings</h2>
    <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-3 text-left">ID</th>
                <th class="p-3 text-left">User</th>
                <th class="p-3 text-left">Room</th>
                <th class="p-3 text-left">Price</th>
                <th class="p-3 text-left">Status</th>
                <th class="p-3 text-left">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($booking = $bookings->fetch_assoc()): ?>
                <tr class="border-t">
                    <td class="p-3"><?= htmlspecialchars($booking['BookingID'] ?? 'N/A') ?></td>
                    <td class="p-3"><?= htmlspecialchars($booking['name'] ?? 'N/A') ?> (<?= htmlspecialchars($booking['email'] ?? 'N/A') ?>)</td>
                    <td class="p-3"><?= htmlspecialchars($booking['RoomType'] ?? 'N/A') ?></td>
                    <td class="p-3">Ksh<?= htmlspecialchars($booking['Price'] ?? '0.00') ?></td>
                    <td class="p-3"><?= htmlspecialchars($booking['Status'] ?? 'Pending') ?></td>
                    <td class="p-3">
                        <a href="update_booking.php?id=<?= $booking['BookingID'] ?? '' ?>" 
                           class="text-blue-500">🔄 Update</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
