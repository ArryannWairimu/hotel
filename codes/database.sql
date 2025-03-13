-- Table for Admins
CREATE TABLE admins (
    adminID INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255)
);

-- Table for Users
CREATE TABLE users (
    userID INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    phone VARCHAR(20),
    address TEXT
);

-- Table for Profiles
CREATE TABLE profiles (
    profileID INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    phone VARCHAR(20),
    address TEXT,
    language VARCHAR(50),
    dark_mode BOOLEAN DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(userID) ON DELETE CASCADE
);

-- Table for Rooms
CREATE TABLE rooms (
    roomID INT AUTO_INCREMENT PRIMARY KEY,
    RoomType VARCHAR(100),
    Price DECIMAL(10,2),
    AvailabilityStatus ENUM('Available', 'Booked'),
    RoomImage VARCHAR(255)
);

-- Table for Bookings
CREATE TABLE bookings (
    bookingID INT AUTO_INCREMENT PRIMARY KEY,
    userID INT,
    roomID INT,
    checkInDate DATE,
    checkOutDate DATE,
    status ENUM('Pending', 'Confirmed', 'Cancelled') DEFAULT 'Pending',
    FOREIGN KEY (userID) REFERENCES users(userID) ON DELETE CASCADE,
    FOREIGN KEY (roomID) REFERENCES rooms(roomID) ON DELETE CASCADE
);

-- Sample Queries
INSERT INTO admins (name, email, password) VALUES (?, ?, ?);
INSERT INTO users (name, email, password, phone, address) VALUES (?, ?, ?, ?, ?);
INSERT INTO rooms (RoomType, Price, AvailabilityStatus, RoomImage) VALUES (?, ?, ?, ?);
INSERT INTO bookings (userID, roomID, checkInDate, checkOutDate, status) VALUES (?, ?, ?, ?, ?);
INSERT INTO profiles (user_id) VALUES (?);

SELECT * FROM admins WHERE adminID = ?;
SELECT * FROM users WHERE userID = ?;
SELECT * FROM rooms WHERE roomID = ?;
SELECT * FROM bookings WHERE bookingID = ? AND userID = ?;

UPDATE bookings SET status = 'Cancelled' WHERE bookingID = ? AND userID = ?;
UPDATE profiles SET phone = ?, address = ?, language = ?, dark_mode = ? WHERE user_id = ?;
UPDATE bookings SET Status = ? WHERE BookingID = ?;

DELETE FROM bookings WHERE bookingID = ?;
DELETE FROM rooms WHERE roomID = ?;
DELETE FROM users WHERE userID = ?;
