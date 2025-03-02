<?php
include 'config.php';
session_start();

if (isset($_GET['id'])) {
    $roomID = intval($_GET['id']);

    // Fetch current room details
    $stmt = $conn->prepare("SELECT roomType, price FROM rooms WHERE roomID = ?");
    $stmt->bind_param("i", $roomID);
    $stmt->execute();
    $result = $stmt->get_result();
    $room = $result->fetch_assoc();
    $stmt->close();

    if (!$room) {
        $_SESSION['message'] = "Room not found.";
        header("Location: manage_rooms.php");
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roomID = intval($_POST['roomID']);
    $newPrice = floatval($_POST['price']);

    if ($roomID > 0 && $newPrice > 0) {
        $stmt = $conn->prepare("UPDATE rooms SET price = ? WHERE roomID = ?");
        $stmt->bind_param("di", $newPrice, $roomID);

        if ($stmt->execute()) {
            $_SESSION['message'] = "✅ Room price updated successfully!";
        } else {
            $_SESSION['message'] = "❌ Error updating price: " . $conn->error;
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "⚠ Invalid room ID or price.";
    }

    header("Location: manage_rooms.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Room Price</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-10 bg-gray-100">
    <h1 class="text-3xl font-bold mb-5">💰 Update Room Price</h1>

    <form method="POST" action="update_price.php" class="bg-white p-6 shadow-md rounded">
        <input type="hidden" name="roomID" value="<?= htmlspecialchars($roomID) ?>">

        <label class="block mb-2">Room Type:</label>
        <input type="text" value="<?= htmlspecialchars($room['roomType']) ?>" class="w-full p-2 border rounded" disabled>

        <label class="block mt-4 mb-2">New Price (Ksh):</label>
        <input type="number" name="price" value="<?= htmlspecialchars($room['price']) ?>" required class="w-full p-2 border rounded">

        <button type="submit" class="mt-4 p-3 bg-blue-500 text-white rounded">✅ Update Price</button>
        <a href="manage_rooms.php" class="mt-4 p-3 bg-gray-500 text-white rounded">🔙 Cancel</a>
    </form>
</body>
</html>
