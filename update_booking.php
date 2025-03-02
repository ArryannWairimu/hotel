<?php
include 'config.php'; // Database connection
session_start();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "❌ Invalid or missing Booking ID!";
    header("Location: admin_dashboard.php");
    exit();
}

$bookingID = intval($_GET['id']); // Ensure it's an integer

// Fetch booking details
$stmt = $conn->prepare("SELECT b.*, u.name AS user_name, u.email, r.RoomType, r.Price 
                        FROM bookings b
                        JOIN users u ON b.UserID = u.UserID
                        JOIN rooms r ON b.RoomID = r.RoomID
                        WHERE b.BookingID = ?");
$stmt->bind_param("i", $bookingID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = "❌ Booking not found!";
    header("Location: admin_dashboard.php");
    exit();
}

$booking = $result->fetch_assoc();
$bookingStatus = $booking['Status'] ?? 'Pending';

// Handle update request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['status'])) {
        $newStatus = $_POST['status'];

        // Update booking status
        $updateStmt = $conn->prepare("UPDATE bookings SET Status = ? WHERE BookingID = ?");
        $updateStmt->bind_param("si", $newStatus, $bookingID);

        if ($updateStmt->execute()) {
            $_SESSION['message'] = "✅ Booking updated successfully!";
            header("Location: admin_home.php");
            exit();
        } else {
            $_SESSION['error'] = "❌ Failed to update booking! Error: " . $conn->error;
        }
    } else {
        $_SESSION['error'] = "❌ Invalid status selection!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Booking</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <form method="POST" class="bg-white p-6 shadow-md rounded-lg">
        <h2 class="text-xl font-bold mb-4">Update Booking</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <p class="text-red-500"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php endif; ?>

        <p><strong>User:</strong> <?php echo htmlspecialchars($booking['user_name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($booking['email']); ?></p>
        <p><strong>Room Type:</strong> <?php echo htmlspecialchars($booking['RoomType']); ?></p>
        <p><strong>Price:</strong> $<?php echo htmlspecialchars($booking['Price']); ?></p>
        <p><strong>Current Status:</strong> <?php echo htmlspecialchars($bookingStatus); ?></p>

        <label for="status" class="block mt-4">Update Status:</label>
        <select name="status" id="status" class="border p-2 w-full">
            <option value="Pending" <?php if ($bookingStatus == 'Pending') echo 'selected'; ?>>Pending</option>
            <option value="Confirmed" <?php if ($bookingStatus == 'Confirmed') echo 'selected'; ?>>Confirmed</option>
            <option value="Checked-In" <?php if ($bookingStatus == 'Checked-In') echo 'selected'; ?>>Checked-In</option>
        </select>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 w-full mt-4">Update Booking</button>
    </form>
</body>
</html>
