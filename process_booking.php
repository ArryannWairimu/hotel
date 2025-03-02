<?php
session_start();
include 'config.php';

// Ensure user is logged in
if (!isset($_SESSION['userID'])) {
    $_SESSION['error'] = "You must be logged in to book a room.";
    header("Location: login.php");
    exit;
}

$userID = $_SESSION['userID']; // FIXED: Corrected from customerID to userID

// Debugging: Check if userID is set correctly
error_log("Debug: Logged-in User ID: " . htmlspecialchars($userID));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $roomID = $_POST["roomID"];
    $checkInDate = $_POST["checkInDate"];
    $checkOutDate = $_POST["checkOutDate"];
    $status = "Pending"; // Default booking status

    // Validate data
    if (empty($roomID) || empty($checkInDate) || empty($checkOutDate)) {
        $_SESSION['error'] = "All fields are required!";
        header("Location: view_rooms.php");
        exit;
    }

    // Prepare SQL query
    $sql = "INSERT INTO bookings (userID, roomID, checkInDate, checkOutDate, status) 
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }

    $stmt->bind_param("iisss", $userID, $roomID, $checkInDate, $checkOutDate, $status);

    // Execute query
    if ($stmt->execute()) {
        $_SESSION['success'] = "Booking successful!";
        header("Location: my_bookings.php");
    } else {
        $_SESSION['error'] = "Booking failed: " . $stmt->error;
        header("Location: view_rooms.php");
    }

    $stmt->close();
} else {
    $_SESSION['error'] = "Invalid request!";
    header("Location: view_rooms.php");
}
?>
