<?php
session_start();
include 'config.php';

// Fetch all bookings with related user and room details
$query = "
    SELECT 
        b.bookingID, 
        COALESCE(u.Name, 'Unknown') AS Name, 
        COALESCE(u.Email, 'No Email') AS Email, 
        COALESCE(r.RoomType, 'No Room') AS RoomType, 
        COALESCE(r.Price, 0) AS Price, 
        COALESCE(b.status, 'Pending') AS Status
    FROM bookings b
    LEFT JOIN users u ON b.userID = u.userID  -- Corrected column name
    LEFT JOIN rooms r ON b.roomID = r.roomID
";

$bookings = $conn->query($query);

// Error handling
if (!$bookings) {
    die("<p class='text-red-500'>Error fetching bookings: " . htmlspecialchars($conn->error) . "</p>");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-10 bg-gray-100">
    <h1 class="text-3xl font-bold mb-5">📌 Manage Bookings</h1>

    <table class="border w-full bg-white shadow-md">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-3">Customer</th>
                <th class="p-3">Room</th>
                <th class="p-3">Price</th>
                <th class="p-3">Status</th>
                <th class="p-3">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($booking = $bookings->fetch_assoc()) { ?>
                <tr class="border-b">
                    <td class="p-3">
                        <?= htmlspecialchars($booking['Name']) ?> 
                        (<?= htmlspecialchars($booking['Email']) ?>)
                    </td>
                    <td class="p-3"><?= htmlspecialchars($booking['RoomType']) ?></td>
                    <td class="p-3">Ksh<?= number_format($booking['Price'], 2) ?></td>
                    <td class="p-3"><?= htmlspecialchars($booking['Status']) ?></td>
                    <td class="p-3">
                        <a href="update_booking.php?id=<?= htmlspecialchars($booking['bookingID']) ?>" 
                           class="text-blue-500">🔄 Update</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
