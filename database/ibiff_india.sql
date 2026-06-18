-- Ibiff India Database Schema

CREATE DATABASE IF NOT EXISTS ibiff_india;
USE ibiff_india;

-- Admins Table
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    username VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('superadmin', 'admin') DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Gallery Table
CREATE TABLE IF NOT EXISTS gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    year YEAR NOT NULL,
    title VARCHAR(255),
    image VARCHAR(255) NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Films Table
CREATE TABLE IF NOT EXISTS films (
    id INT AUTO_INCREMENT PRIMARY KEY,
    year YEAR NOT NULL,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    poster VARCHAR(255),
    banner VARCHAR(255),
    director VARCHAR(255),
    producer VARCHAR(255),
    cast TEXT,
    genre VARCHAR(255),
    duration VARCHAR(50),
    language VARCHAR(100),
    country VARCHAR(100),
    release_date DATE,
    trailer_url VARCHAR(255),
    synopsis TEXT,
    awards TEXT,
    festival_status VARCHAR(255),
    age_rating VARCHAR(50),
    rating_score DECIMAL(3,1),
    rating_count VARCHAR(50),
    popularity_score INT,
    writers VARCHAR(255),
    tagline VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Festival Schedule Table
CREATE TABLE IF NOT EXISTS festival_schedule (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME,
    title VARCHAR(255) NOT NULL,
    venue VARCHAR(255),
    hall VARCHAR(100),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Contact Messages Table
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255),
    message TEXT NOT NULL,
    status ENUM('unread', 'read', 'replied') DEFAULT 'unread',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert a default admin (password: admin123)
-- Hash generated using password_hash('admin123', PASSWORD_DEFAULT)
INSERT INTO admins (name, email, username, password, role) 
VALUES ('Super Admin', 'admin@ibiffindia.com', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'superadmin');
