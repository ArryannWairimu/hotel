<?php
include 'config.php';
session_start();

// Fetch rooms and handle errors
$rooms = $conn->query("SELECT * FROM rooms");
if (!$rooms) {
    die("Query Failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Rooms</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-10 bg-gray-100">
    <h1 class="text-3xl font-bold mb-5">🏨 Manage Rooms</h1>

    <a href="add_room.php" class="p-3 bg-green-500 text-white rounded">➕ Add Room</a>

    <table class="border w-full bg-white shadow-md mt-5">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-3">ID</th>
                <th class="p-3">Type</th>
                <th class="p-3">Price</th>
                <th class="p-3">Status</th>
                <th class="p-3">Image</th>
                <th class="p-3">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($room = $rooms->fetch_assoc()) { ?>
                <tr class="border-b">
                    <td class="p-3"><?= htmlspecialchars($room['roomID'] ?? 'N/A') ?></td>
                    <td class="p-3"><?= htmlspecialchars($room['roomType'] ?? 'N/A') ?></td>
                    <td class="p-3">Ksh<?= number_format($room['price'] ?? 0, 2) ?></td>
                    <td class="p-3">
                        <?php
                        $statusColor = ($room['availabilityStatus'] === 'Available') ? 'text-green-600' : 'text-red-600';
                        ?>
                        <span class="<?= $statusColor ?> font-bold"> <?= htmlspecialchars($room['availabilityStatus'] ?? 'N/A') ?> </span>
                    </td>
                    <td class="p-3">
                        <?php 
                        $imagePath = !empty($room['roomImage']) && file_exists("images/" . $room['roomImage']) ? "images/" . htmlspecialchars($room['roomImage']) : "images/no-image.jpg"; 
                        ?>
                        <img src="<?= $imagePath ?>" alt="Room Image" class="w-20 h-20 object-cover rounded-md">
                    </td>
                    <td class="p-3">
                        <a href="update_price.php?id=<?= $room['roomID'] ?>" class="text-blue-500 mr-2">💰 Update Price</a>
                        <a href="edit_rooms.php?id=<?= $room['roomID'] ?>" class="text-green-500 mr-2">✏ Edit</a>
                        <a href="delete_room.php?id=<?= $room['roomID'] ?>" class="text-red-500" onclick="return confirm('Delete this room?')">🗑 Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
