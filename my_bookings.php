<?php
session_start();
include 'config.php';

// Ensure session ID is regenerated after login to prevent fixation attacks
session_regenerate_id(true);

// Redirect if user is not logged in
if (!isset($_SESSION['userID'])) {
    $_SESSION['error'] = "You must be logged in to view your bookings.";
    header("Location: login.php");
    exit;
}

$userID = $_SESSION['userID']; // Ensure we match the correct column

// Debugging: Check if userID is set correctly (remove in production)
error_log("Debug: Logged-in User ID: " . htmlspecialchars($userID));

// Ensure database connection exists
if (!$conn) {
    die("Database connection error: " . mysqli_connect_error());
}

// Secure query using prepared statement
$sql = "SELECT b.bookingID, r.roomType, r.roomImage, b.checkInDate, b.checkOutDate, b.status
        FROM bookings b
        JOIN rooms r ON b.roomID = r.roomID
        WHERE b.userID = ?"; // Use correct column name

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("SQL Error: " . $conn->error);
}

$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

// Debugging: Check if bookings are fetched (remove in production)
error_log("Debug: Number of bookings found: " . $result->num_rows);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-blue-600 p-4 text-white flex justify-between items-center">
        <h1 class="text-2xl font-bold">Urban Vines</h1>
        <ul class="flex space-x-4">
            <li><a href="index.php" class="hover:underline">Home</a></li>
            <li><a href="view_rooms.php" class="hover:underline">View Rooms</a></li>
            <li><a href="my_bookings.php" class="hover:underline">My Bookings</a></li>
            <li><a href="logout.php" class="hover:underline">Logout</a></li>
        </ul>
    </nav>

    <!-- Bookings List -->
    <section class="p-8">
        <h2 class="text-3xl font-bold text-blue-600 text-center">My Bookings</h2>

        <!-- Display error messages -->
        <?php if (isset($_SESSION['error'])): ?>
            <p class="text-red-600 text-center"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Debugging: Log fetched room details (remove in production)
                    error_log("Booking ID: " . htmlspecialchars($row["bookingID"]));

                    echo '
                        <div class="bg-white p-4 rounded-lg shadow-md">
                            <img src="images/' . htmlspecialchars($row["roomImage"]) . '" 
                                 alt="Room Image" class="w-full h-40 object-cover rounded">
                            <h3 class="text-xl font-bold mt-2">' . htmlspecialchars($row["roomType"]) . '</h3>
                            <p class="text-gray-600">Check-in: <span class="font-semibold">' . htmlspecialchars($row["checkInDate"]) . '</span></p>
                            <p class="text-gray-600">Check-out: <span class="font-semibold">' . htmlspecialchars($row["checkOutDate"]) . '</span></p>
                            <p class="text-gray-600 font-bold">Status: ' . htmlspecialchars($row["status"]) . '</p>
                            ' . ($row["status"] == "Pending" ? '
                                <form action="cancel_booking.php" method="POST">
                                    <input type="hidden" name="bookingID" value="' . htmlspecialchars($row["bookingID"]) . '">
                                    <button type="submit" class="block mt-2 bg-red-600 text-white text-center py-2 rounded w-full">
                                        Cancel Booking
                                    </button>
                                </form>' 
                                : '') . '
                        </div>
                    ';
                }
            } else {
                echo '<p class="text-center text-gray-600 col-span-3">No bookings found.</p>';
            }
            ?>
        </div>
    </section>

</body>
</html>
