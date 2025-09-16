-- Create the database
CREATE DATABASE IF NOT EXISTS final_project;
USE final_project;

-- Shop table (for shop profile, only one row with id=1)
CREATE TABLE IF NOT EXISTS shop (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    logo VARCHAR(255)
);

INSERT INTO shop (id, name, description, logo) VALUES (1, 'My Shop', 'Your shop description here', NULL)
    ON DUPLICATE KEY UPDATE id=id;

-- Products table
CREATE TABLE IF NOT EXISTS products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description TEXT,
    category VARCHAR(50),
    image VARCHAR(255),
    availability ENUM('Available', 'Out of Stock') DEFAULT 'Available'
);

-- Orders table
CREATE TABLE IF NOT EXISTS orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    status ENUM('Pending', 'Completed', 'Cancelled') DEFAULT 'Pending',
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);