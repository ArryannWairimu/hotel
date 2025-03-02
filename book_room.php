<?php
include 'config.php';

if (isset($_GET['roomID'])) {
    $roomID = intval($_GET['roomID']); // Prevent SQL Injection

    $sql = "SELECT * FROM rooms WHERE roomID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $roomID);
    $stmt->execute();
    $result = $stmt->get_result();
    $room = $result->fetch_assoc();

    if (!$room) {
        die("Room not found.");
    }
} else {
    die("Invalid room selection.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Room</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-blue-600 p-4 text-white flex justify-between items-center">
        <h1 class="text-2xl font-bold">Hotel Name</h1>
        <ul class="flex space-x-4">
            <li><a href="index.php" class="hover:underline">Home</a></li>
            <li><a href="view_rooms.php" class="hover:underline">View Rooms</a></li>
            <li><a href="my_bookings.php" class="hover:underline">My Bookings</a></li>
            <li><a href="register.php" class="hover:underline">Register</a></li>
        </ul>
    </nav>

    <!-- Booking Form -->
    <section class="p-8">
        <h2 class="text-3xl font-bold text-blue-600 text-center">Book Room</h2>
        <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-lg">
            <img src="images/<?php echo htmlspecialchars($room['roomImage']); ?>" class="w-full h-48 object-cover rounded-lg mb-4">
            <h3 class="text-xl font-bold"><?php echo htmlspecialchars($room['roomType']); ?></h3>
            <p class="text-gray-600 text-lg font-semibold">Ksh <?php echo number_format($room['price']); ?> / Night</p>

            <form action="process_booking.php" method="POST" class="mt-4">
                <input type="hidden" name="roomID" value="<?php echo htmlspecialchars($room['roomID']); ?>">

                <label class="block text-gray-700 font-semibold">Check-in Date</label>
                <input type="date" name="checkInDate" required class="w-full p-2 border rounded mt-1">

                <label class="block text-gray-700 font-semibold mt-3">Check-out Date</label>
                <input type="date" name="checkOutDate" required class="w-full p-2 border rounded mt-1">

                <label class="block text-gray-700 font-semibold mt-3">Special Requests (Optional)</label>
                <textarea name="specialRequests" class="w-full p-2 border rounded mt-1"></textarea>

                <button type="submit" class="mt-4 w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                    Confirm Booking
                </button>
            </form>
        </div>
    </section>

</body>
</html>
