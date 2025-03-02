<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Management</title>
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

    <!-- Hero Section -->
    <section class="relative h-[400px] bg-cover bg-center flex items-center justify-center" style="background-image: url('images/hotel1.jpg');">
        <div class="text-white text-center">
            <h2 class="text-4xl font-bold">Luxury Redefined</h2>
            <p class="text-lg">Experience comfort like never before.</p>
            <a href="view_rooms.php" class="mt-4 inline-block bg-white text-blue-600 px-6 py-2 rounded-lg font-bold">Explore More</a>
        </div>
    </section>

    <!-- About Section -->
    <section class="p-8 bg-white text-center">
        <h2 class="text-3xl font-bold text-blue-600">About Us</h2>
        <p class="mt-2 text-gray-600"> Nestled in the heart of Nairobi, our hotel offers a perfect blend of comfort, elegance, and convenience. 
        Whether you're visiting for business or leisure, we provide world-class hospitality just minutes away 
        from iconic landmarks such as Nairobi National Park, Jomo Kenyatta International Airport (JKIA), and Wilson Airport. 
        Our luxurious rooms, fine dining experiences, and state-of-the-art amenities ensure that every stay is memorable. 
        With personalized service and a serene ambiance, we redefine luxury to give you the ultimate home away from home.</p>
    </section>

    <!-- Offers Section -->
<section class="p-8 bg-gray-200 text-center">
    <h2 class="text-3xl font-bold text-blue-600">Special Offers</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
        <div class="p-4 bg-white rounded-lg shadow transform transition duration-300 hover:scale-105 hover:shadow-lg">
            <img src="images/offer1.jpg" class="w-full h-40 object-cover rounded transition duration-300 hover:opacity-80">
            <h3 class="text-xl font-bold mt-2">50% Off Deluxe Rooms</h3>
        </div>
        <div class="p-4 bg-white rounded-lg shadow transform transition duration-300 hover:scale-105 hover:shadow-lg">
            <img src="images/offer2.jpg" class="w-full h-40 object-cover rounded transition duration-300 hover:opacity-80">
            <h3 class="text-xl font-bold mt-2">Free Drinks on Arrival</h3>
        </div>
        <div class="p-4 bg-white rounded-lg shadow transform transition duration-300 hover:scale-105 hover:shadow-lg">
            <img src="images/offer3.jpg" class="w-full h-40 object-cover rounded transition duration-300 hover:opacity-80">
            <h3 class="text-xl font-bold mt-2">Weekend Getaway Packages</h3>
        </div>
    </div>
</section>


    <!-- Highlights Section -->
       <section class="p-8 bg-white text-center">
    <h2 class="text-3xl font-bold text-blue-600">Hotel Highlights</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
        <div class="p-4 bg-gray-100 rounded-lg shadow transform transition duration-300 hover:scale-105 hover:shadow-lg">
            <img src="images/heated_pool.jpg" alt="Heated Pool" class="w-full h-40 object-cover rounded-lg mb-2 transition duration-300 hover:opacity-80">
            <h3 class="text-xl font-bold">Heated Pool</h3>
            <p>Relax in our temperature-controlled pool.</p>
        </div>
        <div class="p-4 bg-gray-100 rounded-lg shadow transform transition duration-300 hover:scale-105 hover:shadow-lg">
            <img src="images/rooftop_lounge.webp" alt="Rooftop Lounge" class="w-full h-40 object-cover rounded-lg mb-2 transition duration-300 hover:opacity-80">
            <h3 class="text-xl font-bold">Rooftop Lounge</h3>
            <p>Enjoy cocktails with an amazing view.</p>
        </div>
        <div class="p-4 bg-gray-100 rounded-lg shadow transform transition duration-300 hover:scale-105 hover:shadow-lg">
            <img src="images/spa.jpg" alt="Gym & Spa" class="w-full h-40 object-cover rounded-lg mb-2 transition duration-300 hover:opacity-80">
            <h3 class="text-xl font-bold">Gym & Spa</h3>
            <p>Stay fit and relaxed during your stay.</p>
        </div>
    </div>
</section>


   
<!-- Contact Us Section -->
<section class="p-8 bg-gray-200 text-center">
    <h2 class="text-3xl font-bold text-blue-600">Contact Us</h2>
    <p class="text-gray-600">We'd love to hear from you! Reach out through our social media platforms or send us a message.</p>

    <!-- Social Media Links -->
    <div class="mt-4 flex justify-center space-x-6">
        <!-- Facebook -->
        <a href="#" class="text-blue-600 hover:text-blue-800 flex items-center space-x-2">
            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M22 12a10 10 0 1 0-11.5 9.9v-7h-2.4V12h2.4V9.4c0-2.4 1.4-3.7 3.5-3.7 1 0 2 .2 2 .2v2.3h-1.2c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.4v7A10 10 0 0 0 22 12z"/>
            </svg>
            <span>Facebook</span>
        </a>

        <!-- Twitter -->
        <a href="#" class="text-blue-400 hover:text-blue-600 flex items-center space-x-2">
            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.36 1.88-2.35-.83.49-1.75.83-2.72 1.02a4.33 4.33 0 0 0-7.39 3.94c-3.6-.18-6.8-1.91-8.94-4.54a4.33 4.33 0 0 0 .69 5.78 4.3 4.3 0 0 1-1.96-.54v.06a4.33 4.33 0 0 0 3.47 4.24c-.48.13-.99.2-1.51.2a3.92 3.92 0 0 1-.81-.08 4.33 4.33 0 0 0 4.04 3A8.7 8.7 0 0 1 2 18.26 12.27 12.27 0 0 0 8.3 20c7.55 0 11.7-6.26 11.7-11.7 0-.18 0-.37-.01-.55A8.36 8.36 0 0 0 22.46 6z"/>
            </svg>
            <span>Twitter</span>
        </a>

        <!-- Instagram -->
        <a href="#" class="text-pink-500 hover:text-pink-700 flex items-center space-x-2">
            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M7 2C4.2 2 2 4.2 2 7v10c0 2.8 2.2 5 5 5h10c2.8 0 5-2.2 5-5V7c0-2.8-2.2-5-5-5H7zm10 2c1.7 0 3 1.3 3 3v10c0 1.7-1.3 3-3 3H7c-1.7 0-3-1.3-3-3V7c0-1.7 1.3-3 3-3h10zm-5 3a5 5 0 1 0 .1 10 5 5 0 0 0 0-10zm0 2a3 3 0 1 1 0 6 3 3 0 0 1 0-6zm5.5-.5a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3z"/>
            </svg>
            <span>Instagram</span>
        </a>
    </div>
</section>


    </section>  

         <!-- Live Chat -->
    <div class="fixed bottom-5 right-5">
    <!-- Chat icon button -->
    <div id="chatIcon" class="bg-blue-600 text-white p-3 rounded-full shadow-lg cursor-pointer flex items-center justify-center w-14 h-14" onclick="document.getElementById('chatBox').classList.toggle('hidden')">
        <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 15h6M21 12c0 4.418-4.03 8-9 8-1.347 0-2.63-.263-3.786-.733C6.293 19.632 3 21 3 21s.368-3.134.733-5.214A8.958 8.958 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
        </svg>
    </div>

    <!-- Chat box -->
    <div id="chatBox" class="hidden bg-white shadow-xl p-4 rounded w-72 fixed bottom-16 right-5 border">
        <div class="flex justify-between items-center">
            <p class="font-bold">Chat with us</p>
            <button onclick="document.getElementById('chatBox').classList.add('hidden')" class="text-gray-500 hover:text-gray-800">
                ✖
            </button>
        </div>
        <textarea class="w-full border p-2 mt-2 rounded" placeholder="Type your message..."></textarea>
        <button class="bg-blue-600 text-white px-3 py-1 mt-2 rounded w-full">Send</button>
    </div>
</div>



    <!-- Footer -->
    <footer class="bg-blue-600 text-white text-center p-4">
        <p>&copy; 2025 Urban Vines. All rights reserved. </p>
    </footer>

</body>
</html>
