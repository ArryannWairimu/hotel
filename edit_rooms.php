<?php
include 'config.php';
session_start();

// Ensure `id` is set in the URL before processing
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['message'] = "⚠ Missing room ID.";
    header("Location: manage_rooms.php");
    exit;
}

$roomID = intval($_GET['id']); // Ensure room ID is a valid integer

// Fetch room details from the database
$stmt = $conn->prepare("SELECT roomType, availabilityStatus, RoomImage FROM rooms WHERE roomID = ?");
$stmt->bind_param("i", $roomID);
$stmt->execute();
$result = $stmt->get_result();
$room = $result->fetch_assoc();
$stmt->close();

// Redirect if the room is not found
if (!$room) {
    $_SESSION['message'] = "⚠ Room not found.";
    header("Location: manage_rooms.php");
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roomType = trim($_POST['roomType']);
    $availabilityStatus = trim($_POST['availabilityStatus']);
    $roomImage = $room['RoomImage']; // Keep existing image unless updated

    // Image Upload Handling
    $targetDir = "uploads/"; // Ensure this directory exists
    if (!empty($_FILES['roomImage']['name'])) {
        $fileName = basename($_FILES['roomImage']['name']);
        $targetFilePath = $targetDir . time() . "_" . $fileName;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Allowed file types
        $allowedTypes = ["jpg", "jpeg", "png", "gif"];
        if (in_array($fileType, $allowedTypes)) {
            // Ensure the uploads directory exists
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            if (move_uploaded_file($_FILES["roomImage"]["tmp_name"], $targetFilePath)) {
                $roomImage = $targetFilePath; // Update with new image path
            } else {
                $_SESSION['message'] = "⚠ Error uploading image.";
                header("Location: edit_rooms.php?id=" . $roomID);
                exit;
            }
        } else {
            $_SESSION['message'] = "⚠ Invalid image format. Allowed: JPG, JPEG, PNG, GIF.";
            header("Location: edit_rooms.php?id=" . $roomID);
            exit;
        }
    }

    // Update database record
    $stmt = $conn->prepare("UPDATE rooms SET roomType = ?, availabilityStatus = ?, RoomImage = ? WHERE roomID = ?");
    $stmt->bind_param("sssi", $roomType, $availabilityStatus, $roomImage, $roomID);

    if ($stmt->execute()) {
        $_SESSION['message'] = "✅ Room details updated successfully!";
    } else {
        $_SESSION['message'] = "❌ Error updating room: " . $conn->error;
    }
    $stmt->close();

    header("Location: manage_rooms.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Room</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-10 bg-gray-100">
    <h1 class="text-3xl font-bold mb-5">🛏️ Edit Room Details</h1>

    <form method="POST" action="edit_rooms.php?id=<?= htmlspecialchars($roomID) ?>" enctype="multipart/form-data" class="bg-white p-6 shadow-md rounded">
        <input type="hidden" name="roomID" value="<?= htmlspecialchars($roomID) ?>">

        <label class="block mb-2">Room Type:</label>
        <input type="text" name="roomType" value="<?= htmlspecialchars($room['roomType']) ?>" required class="w-full p-2 border rounded">

        <label class="block mt-4 mb-2">Availability Status:</label>
        <select name="availabilityStatus" required class="w-full p-2 border rounded">
            <option value="Available" <?= ($room['availabilityStatus'] == "Available") ? "selected" : "" ?>>Available</option>
            <option value="Unavailable" <?= ($room['availabilityStatus'] == "Unavailable") ? "selected" : "" ?>>Unavailable</option>
        </select>

        <label class="block mt-4 mb-2">Room Image:</label>
        <input type="file" name="roomImage" accept="image/*" class="w-full p-2 border rounded">

        <!-- Display the current image -->
        <?php if (!empty($room['RoomImage'])): ?>
            <img src="<?= !empty($room['RoomImage']) ? htmlspecialchars($room['RoomImage']) : 'uploads/no-image.jpg'; ?>" 
                 alt="Current Room Image" class="mt-3 w-32 h-32 object-cover rounded">
        <?php endif; ?>

        <button type="submit" class="mt-4 p-3 bg-blue-500 text-white rounded">✅ Update Room</button>
        <a href="manage_rooms.php" class="mt-4 p-3 bg-gray-500 text-white rounded">🔙 Cancel</a>
    </form>
</body>
</html>
