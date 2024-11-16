-- Create the database
CREATE DATABASE IF NOT EXISTS charity_db;
USE charity_db;

-- Create the donors table
CREATE TABLE IF NOT EXISTS donors (
                                      personID INT AUTO_INCREMENT PRIMARY KEY,
                                      name VARCHAR(100) NOT NULL,
                                      email VARCHAR(100) UNIQUE NOT NULL,
                                      phone VARCHAR(15),
                                      address TEXT
);

-- Create the donations table
CREATE TABLE IF NOT EXISTS donations (
                                         donationID INT AUTO_INCREMENT PRIMARY KEY,
                                         donorID INT NOT NULL,
                                         eventID INT, -- Assuming an event table may be added later
                                         donationDate DATETIME,
                                         FOREIGN KEY (donorID) REFERENCES donors(personID) ON DELETE CASCADE
);

-- Insert sample data into donors table (only if table is empty)
INSERT IGNORE INTO donors (name, email, phone, address) VALUES
                                                            ('John Doe', 'john.doe@example.com', '1234567890', '123 Main St, Cityville'),
                                                            ('Jane Smith', 'jane.smith@example.com', '0987654321', '456 Elm St, Townsville'),
                                                            ('Alice Johnson', 'alice.johnson@example.com', '1122334455', '789 Oak St, Villagetown');
