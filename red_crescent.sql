-- Drop the existing database if it exists
DROP DATABASE IF EXISTS red_crescent;

-- Create a new database
CREATE DATABASE red_crescent;

-- Use the newly created database
USE red_crescent;

-- Create the persons table to hold common attributes
CREATE TABLE persons (
                         person_id INT AUTO_INCREMENT PRIMARY KEY,
                         name VARCHAR(255) NOT NULL,
                         email VARCHAR(255) UNIQUE NOT NULL
);

-- Create the volunteers table using person_id as the primary key
CREATE TABLE volunteers (
                            person_id INT PRIMARY KEY,                -- Primary key and foreign key to persons
                            phone VARCHAR(20),
                            address TEXT,
                            joined_date DATE,
                            role VARCHAR(100),
                            status ENUM('active', 'inactive') DEFAULT 'active',
                            FOREIGN KEY (person_id) REFERENCES persons(person_id) ON DELETE CASCADE
);

-- Create the volunteer_skills table to store skills associated with each volunteer
CREATE TABLE volunteer_skills (
                                  id INT AUTO_INCREMENT PRIMARY KEY,
                                  person_id INT,                            -- Foreign key to volunteers table
                                  skill VARCHAR(255) NOT NULL,
                                  FOREIGN KEY (person_id) REFERENCES volunteers(person_id) ON DELETE CASCADE
);

-- Create the volunteer_schedule table to store schedule information for each volunteer
CREATE TABLE volunteer_schedule (
                                    id INT AUTO_INCREMENT PRIMARY KEY,
                                    person_id INT,                            -- Foreign key to volunteers table
                                    schedule_date DATE NOT NULL,
                                    hours INT NOT NULL,
                                    FOREIGN KEY (person_id) REFERENCES volunteers(person_id) ON DELETE CASCADE
);

-- Create the volunteer_tasks table to store tasks associated with each volunteer
CREATE TABLE volunteer_tasks (
                                 id INT AUTO_INCREMENT PRIMARY KEY,
                                 person_id INT,                            -- Foreign key to volunteers table
                                 task_name VARCHAR(255) NOT NULL,
                                 description TEXT,
                                 due_date DATE,
                                 FOREIGN KEY (person_id) REFERENCES volunteers(person_id) ON DELETE CASCADE
);

-- Create the volunteer_certificates table to store certificates associated with tasks
CREATE TABLE volunteer_certificates (
                                        id INT AUTO_INCREMENT PRIMARY KEY,
                                        task_id INT,                              -- Foreign key to volunteer_tasks table
                                        certificate_name VARCHAR(255) NOT NULL,
                                        date_awarded DATE,
                                        FOREIGN KEY (task_id) REFERENCES volunteer_tasks(id) ON DELETE CASCADE
);

-- Insert initial data into the persons table
INSERT INTO persons (name, email)
VALUES
    ('Alice Smith', 'alice@example.com'),
    ('Bob Johnson', 'bob@example.com'),
    ('Cathy Brown', 'cathy@example.com'),
    ('David Wilson', 'david@example.com'),
    ('Emma Davis', 'emma@example.com');

-- Insert initial data into the volunteers table, referencing the persons table
INSERT INTO volunteers (person_id, phone, address, joined_date, role, status)
VALUES
    (1, '123-456-7890', '123 Elm St, Springfield', '2023-01-15', 'Field Volunteer', 'active'),
    (2, '234-567-8901', '456 Oak St, Springfield', '2022-09-20', 'Coordinator', 'inactive'),
    (3, '345-678-9012', '789 Pine St, Springfield', '2023-05-10', 'Medical Volunteer', 'active'),
    (4, '456-789-0123', '101 Maple St, Springfield', '2022-12-05', 'Logistics Volunteer', 'active'),
    (5, '567-890-1234', '202 Cedar St, Springfield', '2023-07-25', 'Administrative Volunteer', 'inactive');

-- Insert initial data into volunteer_skills table
INSERT INTO volunteer_skills (person_id, skill)
VALUES
    (1, 'First Aid'),
    (1, 'Emergency Response'),
    (2, 'Project Coordination'),
    (3, 'Medical Assistance'),
    (4, 'Logistics Management');

-- Insert initial data into volunteer_schedule table
INSERT INTO volunteer_schedule (person_id, schedule_date, hours)
VALUES
    (1, '2023-01-15', 8),
    (1, '2023-01-16', 4),
    (2, '2023-01-20', 6),
    (3, '2023-02-01', 8);

-- Insert initial data into volunteer_tasks table
INSERT INTO volunteer_tasks (person_id, task_name, description, due_date)
VALUES
    (1, 'Rescue Operation', 'Participated in a major rescue operation', '2023-01-20'),
    (2, 'Coordination Meeting', 'Attended coordination meeting for upcoming projects', '2023-01-25'),
    (3, 'Medical Camp', 'Assisted in a medical camp for refugees', '2023-02-10');

-- Insert initial data into volunteer_certificates table
INSERT INTO volunteer_certificates (task_id, certificate_name, date_awarded)
VALUES
    (1, 'Rescue Certificate', '2023-01-21'),
    (2, 'Coordination Excellence', '2023-01-26'),
    (3, 'Medical Assistance', '2023-02-15');
