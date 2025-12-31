-- Database for AK MECHANIC SERVICES
CREATE DATABASE IF NOT EXISTS ak_mechanic_db;
USE ak_mechanic_db;

-- Table for Admin Users
CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Table for Bike Service Bookings
CREATE TABLE IF NOT EXISTS bike_bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    bike_model VARCHAR(100) NOT NULL,
    problem TEXT NOT NULL,
    service_date DATE NOT NULL,
    status ENUM('Pending', 'In Progress', 'Completed') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Default Admin User (username: admin, password: admin123)
-- Password hashed using PHP's password_hash()
INSERT INTO admin (username, password) VALUES ('admin', '$2y$10$O9w.v5j5L0Wl6fN9Sj/qve8.y0lF.pSgF5Y3QvjM.3f.7Q7S1y9.O');
