<?php
session_start();
include 'config.php';

// Ensure user is logged in
if (!isset($_SESSION['userID'])) {
    $_SESSION['error'] = "You must be logged in to cancel a booking.";
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookingID = $_POST["bookingID"];
    $userID = $_SESSION['userID']; // Get logged-in user

    // Check if the booking exists and belongs to the user
    $check_sql = "SELECT * FROM bookings WHERE bookingID = ? AND userID = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ii", $bookingID, $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['error'] = "Invalid booking or unauthorized action.";
        header("Location: my_bookings.php");
        exit;
    }

    // Update booking status to "Cancelled"
    $sql = "UPDATE bookings SET status = 'Cancelled' WHERE bookingID = ? AND userID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $bookingID, $userID);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Booking has been successfully cancelled.";
    } else {
        $_SESSION['error'] = "Failed to cancel the booking.";
    }

    $stmt->close();
    header("Location: my_bookings.php");
    exit;
}
?>
