DROP DATABASE IF EXISTS charity_db;

-- Create the database
CREATE DATABASE  charity_db;
USE charity_db;

CREATE TABLE  Address (
                                       AddressID INT AUTO_INCREMENT PRIMARY KEY, -- Unique ID for each address
                                       Name VARCHAR(255) NOT NULL,              -- Name of the address
    ParentID INT DEFAULT NULL,               -- Self-referencing Parent ID
    FOREIGN KEY (ParentID) REFERENCES Address(AddressID) ON DELETE SET NULL
    );

-- Create Person table
CREATE TABLE  Person (
                                      person_id INT AUTO_INCREMENT PRIMARY KEY,
                                      FirstName VARCHAR(100) NOT NULL,
    LastName VARCHAR(100) NOT NULL,
    MiddleName VARCHAR(100),
    Nationality VARCHAR(100),
    Gender ENUM('Male', 'Female'),
    PersonPhone VARCHAR(15) UNIQUE ,
    isPersonDeleted TINYINT(1) DEFAULT 0,
    AddressID INT,
    FOREIGN KEY (AddressID) REFERENCES Address(AddressID) ON DELETE SET NULL
    );




-- Create Account table
CREATE TABLE   Account (
                                        person_id INT PRIMARY KEY,
                                        AccountEmail VARCHAR(100) UNIQUE NOT NULL,
    AccountPasswordHashed  VARCHAR(255) NOT NULL UNIQUE ,
    Status ENUM('Active', 'Inactive') DEFAULT 'Active',
    IsUser TINYINT(1) DEFAULT 1,
    IsAccountDeleted TINYINT(1) DEFAULT 0,
    FOREIGN KEY (person_id) REFERENCES Person(person_id) ON DELETE CASCADE
    );
CREATE TABLE  Volunteer (
                            person_id INT PRIMARY KEY,
                                         IsVolunteerDeleted TINYINT(1) DEFAULT 0,
    FOREIGN KEY (person_id) REFERENCES Account(person_id) ON DELETE CASCADE
    );
CREATE TABLE  Skill (
                                     id INT AUTO_INCREMENT PRIMARY KEY,      -- Foreign key to volunteers table
                                     skill VARCHAR(255) NOT NULL
    );

-- Create the volunteer_skills table to store skills associated with each volunteer
CREATE TABLE  Volunteer_Skills (
                                  id INT AUTO_INCREMENT PRIMARY KEY,
                                  person_id INT,                            -- Foreign key to volunteers table
                                  skill_id INT,
                                  IsVolunteerSkillDeleted TINYINT(1) DEFAULT 0,
                                  FOREIGN KEY (person_id) REFERENCES Volunteer(person_id) ON DELETE CASCADE,
                                  FOREIGN KEY (skill_id) REFERENCES Skill(id) ON DELETE CASCADE
);

-- Create Event table (for reference)
CREATE TABLE  Event (
                                     EventID INT AUTO_INCREMENT PRIMARY KEY,
                                     EventName VARCHAR(255) NOT NULL,
    EventDate DATE NOT NULL,
    Description TEXT
    );


-- Volunteer_Events table to associate volunteers with events
CREATE TABLE  Volunteer_Events (
                                                id INT AUTO_INCREMENT PRIMARY KEY,
                                                person_id INT NOT NULL,                            -- Foreign key to volunteers
                                                event_id INT NOT NULL,                             -- Foreign key to Event
                                                IsVolunteerEventDeleted TINYINT(1) DEFAULT 0,
    FOREIGN KEY (person_id) REFERENCES Volunteer(person_id) ON DELETE CASCADE,
    FOREIGN KEY (event_id) REFERENCES Event(EventID) ON DELETE CASCADE
    );


-- Create the volunteer_tasks table to store tasks associated with each volunteer
CREATE TABLE  Volunteer_Tasks (
                                 id INT AUTO_INCREMENT PRIMARY KEY,
                                 person_id INT,                            -- Foreign key to volunteers table
                                 task_name VARCHAR(255) NOT NULL,
                                 description TEXT,
                                 due_date DATE,
                                 FOREIGN KEY (person_id) REFERENCES Volunteer(person_id) ON DELETE CASCADE
);
-- Create the volunteer_schedule table to store schedule information for each volunteer
CREATE TABLE  volunteer_schedule (
                                    id INT AUTO_INCREMENT PRIMARY KEY,
                                    person_id INT,                            -- Foreign key to Volunteer table
                                    schedule_date DATE NOT NULL,
                                    hours INT NOT NULL,
                                    FOREIGN KEY (person_id) REFERENCES Volunteer(person_id) ON DELETE CASCADE
);

-- Create Admin table
CREATE TABLE    Admin (
                                       person_id INT PRIMARY KEY,
                                       AdminType ENUM('BeneficiaryAdmin', 'DonorAdmin', 'VolunteerAdmin') NOT NULL,
    FOREIGN KEY (person_id) REFERENCES Account(person_id) ON DELETE CASCADE
    );


CREATE TABLE  Donor (
                                     person_id INT PRIMARY KEY,
                                     BloodType VARCHAR(3),
    IsDonorDeleted TINYINT(1) DEFAULT 0,
    FOREIGN KEY (person_id) REFERENCES Account(person_id) ON DELETE CASCADE
    );


CREATE TABLE  Beneficiary (
                                           person_id INT PRIMARY KEY,
                                           IsBeneficiaryDeleted TINYINT(1) DEFAULT 0,
    FOREIGN KEY (person_id) REFERENCES Account(person_id) ON DELETE CASCADE
    );
-- Create Appointments table
CREATE TABLE   Appointments (
                                             AppointmentID INT AUTO_INCREMENT PRIMARY KEY,
                                             AppointmentDate DATE NOT NULL,
                                             AppointmentTime TIME NOT NULL,
                                             CurrentCapacity INT DEFAULT 0,
                                             MaxCapacity INT NOT NULL

);

-- Create Reserve table
CREATE TABLE  Reserve (
                                       person_id INT,
                                       AppointmentID INT,
                                       ReservationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                       PRIMARY KEY (person_id, AppointmentID),
    FOREIGN KEY (person_id) REFERENCES Donor(person_id) ON DELETE CASCADE,
    FOREIGN KEY (AppointmentID) REFERENCES Appointments(AppointmentID) ON DELETE CASCADE
    );



-- Insert data into Address table
INSERT INTO Address (Name, ParentID)
VALUES
    ('USA', NULL),  -- Top-level country
    ('UK', NULL),   -- Top-level country
    ('Canada', NULL); -- Top-level country



INSERT INTO Address (Name, ParentID)
VALUES
    ('New York', 1), -- City, Parent is 'USA' (AddressID 1)
    ('London', 2),   -- City, Parent is 'UK' (AddressID 2)
    ('Toronto', 3);  -- City, Parent is 'Canada' (AddressID 3)

INSERT INTO Address (Name, ParentID)
VALUES
    ('5th Avenue', 4),  -- Street, Parent is 'New York' (AddressID 4)
    ('Oxford Street', 5), -- Street, Parent is 'London' (AddressID 5)
    ('Yonge Street', 6); -- Street, Parent is 'Toronto' (AddressID 6)


-- Insert John Doe as Volunteer
INSERT INTO Person (FirstName, LastName, MiddleName, Nationality, Gender, PersonPhone, isPersonDeleted, AddressID)
VALUES ('John', 'Doe', 'Michael', 'American', 'Male', '1234567890', 0, 7);
SET @last_person_id = LAST_INSERT_ID();
INSERT INTO Account (person_id, AccountEmail, AccountPasswordHashed, Status, IsUser, IsAccountDeleted)
VALUES (@last_person_id, 'johndoe@example.com', 'hashed_password_123', 'Active', 1, 0);
INSERT INTO Volunteer (person_id, IsVolunteerDeleted)
VALUES (@last_person_id, 0);

-- Insert Jane Smith as Volunteer
INSERT INTO Person (FirstName, LastName, MiddleName, Nationality, Gender, PersonPhone, isPersonDeleted, AddressID)
VALUES ('Jane', 'Smith', NULL, 'British', 'Female', '0987654321', 0, 8);
SET @last_person_id = LAST_INSERT_ID();
INSERT INTO Account (person_id, AccountEmail, AccountPasswordHashed, Status, IsUser, IsAccountDeleted)
VALUES (@last_person_id, 'janesmith@example.com', 'hashed_password_456', 'Active', 1, 0);
INSERT INTO Volunteer (person_id, IsVolunteerDeleted)
VALUES (@last_person_id, 0);

-- Insert Alex Taylor as Volunteer
INSERT INTO Person (FirstName, LastName, MiddleName, Nationality, Gender, PersonPhone, isPersonDeleted, AddressID)
VALUES ('Alex', 'Taylor', 'Lee', 'Canadian', 'Male', '1122334455', 0, 9);
SET @last_person_id = LAST_INSERT_ID();
INSERT INTO Account (person_id, AccountEmail, AccountPasswordHashed, Status, IsUser, IsAccountDeleted)
VALUES (@last_person_id, 'alextaylor@example.com', 'hashed_password_789', 'Active', 1, 0);
INSERT INTO Volunteer (person_id, IsVolunteerDeleted)
VALUES (@last_person_id, 0);

INSERT INTO Skill (skill)
VALUES
    ('First Aid'),
    ('Emergency Response'),
    ('Project Coordination'),
    ('Medical Assistance'),
    ('Logistics Management');
ALTER TABLE Volunteer_Skills ADD UNIQUE(person_id, skill_id);
ALTER TABLE Volunteer_Events ADD UNIQUE(person_id, event_id);

INSERT INTO Volunteer_Skills (person_id, skill_id)
VALUES
    (1, 1),  -- Volunteer 1 has 'First Aid'
    (1, 2),  -- Volunteer 1 has 'Emergency Response'
    (2, 3);  -- Volunteer 2 has 'Project Coordination'


INSERT INTO Event (EventName, EventDate, Description)
VALUES
    ('Health Camp', '2023-03-01', 'Assist at a free health check-up camp'),
    ('Community Cleanup', '2023-03-05', 'Participate in a neighborhood cleanup drive');

-- Associate volunteers with events
INSERT INTO Volunteer_Events (person_id, event_id)
VALUES
    (1, 1),  -- Volunteer 1 attending 'Health Camp'
    (2, 2);  -- Volunteer 2 attending 'Community Cleanup'