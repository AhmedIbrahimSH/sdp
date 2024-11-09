-- Drop the existing database if it exists
DROP DATABASE IF EXISTS red_crescent;

-- Create a new database
CREATE DATABASE red_crescent;

-- Use the newly created database
USE red_crescent;

-- Create the volunteers table
CREATE TABLE volunteers (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            name VARCHAR(255) NOT NULL,
                            email VARCHAR(255) UNIQUE NOT NULL,
                            phone VARCHAR(20),
                            address TEXT,
                            joined_date DATE,
                            role VARCHAR(100),
                            status ENUM('active', 'inactive') DEFAULT 'active'
);

-- Insert initial data into the volunteers table
INSERT INTO volunteers (name, email, phone, address, joined_date, role, status)
VALUES
    ('Alice Smith', 'alice@example.com', '123-456-7890', '123 Elm St, Springfield', '2023-01-15', 'Field Volunteer', 'active'),
    ('Bob Johnson', 'bob@example.com', '234-567-8901', '456 Oak St, Springfield', '2022-09-20', 'Coordinator', 'inactive'),
    ('Cathy Brown', 'cathy@example.com', '345-678-9012', '789 Pine St, Springfield', '2023-05-10', 'Medical Volunteer', 'active'),
    ('David Wilson', 'david@example.com', '456-789-0123', '101 Maple St, Springfield', '2022-12-05', 'Logistics Volunteer', 'active'),
    ('Emma Davis', 'emma@example.com', '567-890-1234', '202 Cedar St, Springfield', '2023-07-25', 'Administrative Volunteer', 'inactive');
