<?php 
include 'config.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Rooms</title>
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
            <li><a href="register.php" class="hover:underline">Register</a></li>
        </ul>
    </nav>

    <!-- Room List -->
    <section class="p-8">
        <h2 class="text-3xl font-bold text-blue-600 text-center">Available Rooms</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
            <?php
            $rooms = [
                ["roomID" => 1, "roomType" => "Deluxe Room", "price" => 5000, "availability" => 3, "roomImage" => "images/room1.jpg"],
                ["roomID" => 2, "roomType" => "Executive Suite", "price" => 8000, "availability" => 2, "roomImage" => "images/room2.jpg"],
                ["roomID" => 3, "roomType" => "Standard Room", "price" => 4000, "availability" => 5, "roomImage" => "images/room3.jpg"],
                ["roomID" => 4, "roomType" => "Presidential Suite", "price" => 15000, "availability" => 1, "roomImage" => "images/room4.webp"],
                ["roomID" => 5, "roomType" => "Single Room", "price" => 3000, "availability" => 2, "roomImage" => "images/room5.webp"],
                ["roomID" => 6, "roomType" => "Family Room", "price" => 7000, "availability" => 4, "roomImage" => "images/room6.jpg"]
            ];

            foreach ($rooms as $row) {
                echo '
                    <div class="relative p-4 bg-white rounded-lg shadow transform transition duration-300 hover:scale-105">
                        <!-- Room Image -->
                        <img src="'.$row["roomImage"].'" alt="'.$row["roomType"].'" class="w-full h-48 object-cover rounded-lg mb-3">

                        <!-- Availability Badge -->
                        ' . ($row["availability"] == 2 ? '<span class="absolute top-2 right-2 bg-red-600 text-white text-sm px-2 py-1 rounded-full">Only 2 left!</span>' : '') . '

                        <h3 class="text-xl font-bold">'.$row["roomType"].'</h3>
                        <p class="text-gray-700">Comfortable and well-furnished room.</p>
                        <p class="text-lg font-semibold text-blue-600">Ksh '.$row["price"].' / Night</p>

                        <a href="book_room.php?roomID='.$row["roomID"].'" class="mt-3 block px-4 py-2 bg-blue-600 text-white text-center rounded-lg hover:bg-blue-700">Book Now</a>
                    </div>
                ';
            }
            ?>
        </div>
    </section>

</body>
</html>
