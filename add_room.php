<?php
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roomType = mysqli_real_escape_string($conn, $_POST['roomType']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Handle Image Upload
    $targetDir = "image/";
    $fileName = basename($_FILES["roomImage"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    if (move_uploaded_file($_FILES["roomImage"]["tmp_name"], $targetFilePath)) {
        $query = "INSERT INTO rooms (RoomType, Price, AvailabilityStatus, RoomImage) 
                  VALUES ('$roomType', '$price', '$status', '$fileName')";

        if ($conn->query($query)) {
            echo "<script>alert('Room added successfully!'); window.location='manage_rooms.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Error uploading image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Room</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-10 bg-gray-100">
    <h1 class="text-3xl font-bold mb-5">➕ Add Room</h1>

    <form method="POST" enctype="multipart/form-data" class="bg-white p-5 shadow-md">
        <label class="block">Room Type:</label>
        <input type="text" name="roomType" class="border p-2 w-full mb-3" required>

        <label class="block">Price:</label>
        <input type="number" name="price" class="border p-2 w-full mb-3" required>

        <label class="block">Status:</label>
        <select name="status" class="border p-2 w-full mb-3" required>
            <option value="Available">Available</option>
            <option value="Booked">Booked</option>
        </select>

        <label class="block">Room Image:</label>
        <input type="file" name="roomImage" class="border p-2 w-full mb-3" accept="image/*" required>

        <button type="submit" class="bg-green-500 text-white p-3 rounded">Add Room</button>
    </form>
</body>
</html>
