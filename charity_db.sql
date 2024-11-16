 #DROP DATABASE charity_db;

-- Create the database
CREATE DATABASE IF NOT EXISTS charity_db;
USE charity_db;

 CREATE TABLE IF NOT EXISTS Address (
                                        AddressID INT AUTO_INCREMENT PRIMARY KEY, -- Unique ID for each address
                                        Name VARCHAR(255) NOT NULL,              -- Name of the address
                                        ParentID INT DEFAULT NULL,               -- Self-referencing Parent ID
                                        FOREIGN KEY (ParentID) REFERENCES Address(AddressID) ON DELETE SET NULL
 );

-- Create Person table
CREATE TABLE IF NOT EXISTS Person (
                                      PersonID INT AUTO_INCREMENT PRIMARY KEY,
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
CREATE TABLE IF NOT EXISTS  Account (
                                    PersonID INT PRIMARY KEY,
                                    AccountEmail VARCHAR(100) UNIQUE NOT NULL,
                                    AccountPasswordHashed  VARCHAR(255) NOT NULL UNIQUE ,
                                    Status ENUM('Active', 'Inactive') DEFAULT 'Active',
                                    IsUser TINYINT(1) DEFAULT 1,
                                    IsAccountDeleted TINYINT(1) DEFAULT 0,
                                    FOREIGN KEY (PersonID) REFERENCES Person(PersonID) ON DELETE CASCADE
);
-- Create Admin table
CREATE TABLE  IF NOT EXISTS  Admin (
                               PersonID INT PRIMARY KEY,
                               AdminType ENUM('BeneficiaryAdmin', 'DonorAdmin', 'VolunteerAdmin') NOT NULL,
                               FOREIGN KEY (PersonID) REFERENCES Account(PersonID) ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS Donor (
                             PersonID INT PRIMARY KEY,
                             BloodType VARCHAR(3),
                             IsDonorDeleted TINYINT(1) DEFAULT 0,
                             FOREIGN KEY (PersonID) REFERENCES Account(PersonID) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Volunteer (
                           PersonID INT PRIMARY KEY,
                           IsVolunteerDeleted TINYINT(1) DEFAULT 0,
                           FOREIGN KEY (PersonID) REFERENCES Person(PersonID) ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS Beneficiary (
                             PersonID INT PRIMARY KEY,
                             IsBeneficiaryDeleted TINYINT(1) DEFAULT 0,
                             FOREIGN KEY (PersonID) REFERENCES Person(PersonID) ON DELETE CASCADE
);
-- Create Appointments table
CREATE TABLE IF NOT EXISTS  Appointments (
                                             AppointmentID INT AUTO_INCREMENT PRIMARY KEY,
                                             AppointmentDate DATE NOT NULL,
                                             AppointmentTime TIME NOT NULL,
                                             CurrentCapacity INT DEFAULT 0,
                                             MaxCapacity INT NOT NULL

);

-- Create Reserve table
CREATE TABLE IF NOT EXISTS Reserve (
                         PersonID INT,
                         AppointmentID INT,
                         ReservationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                         PRIMARY KEY (PersonID, AppointmentID),
                         FOREIGN KEY (PersonID) REFERENCES Donor(PersonID) ON DELETE CASCADE,
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


-- Insert John Doe
INSERT INTO Person (FirstName, LastName, MiddleName, Nationality, Gender, PersonPhone, isPersonDeleted, AddressID)
VALUES ('John', 'Doe', 'Michael', 'American', 'Male', '1234567890', 0, 7);
SET @last_person_id = LAST_INSERT_ID();
INSERT INTO Account (PersonID, AccountEmail, AccountPasswordHashed, Status, IsUser, IsAccountDeleted)
VALUES (@last_person_id, 'johndoe@example.com', 'hashed_password_123', 'Active', 1, 0);
INSERT INTO Donor (PersonID, BloodType, IsDonorDeleted)
VALUES (@last_person_id, 'O+', 0);

-- Insert Jane Smith
INSERT INTO Person (FirstName, LastName, MiddleName, Nationality, Gender, PersonPhone, isPersonDeleted, AddressID)
VALUES ('Jane', 'Smith', NULL, 'British', 'Female', '0987654321', 0, 8);
SET @last_person_id = LAST_INSERT_ID();
INSERT INTO Account (PersonID, AccountEmail, AccountPasswordHashed, Status, IsUser, IsAccountDeleted)
VALUES (@last_person_id, 'janesmith@example.com', 'hashed_password_456', 'Active', 1, 0);
INSERT INTO Donor (PersonID, BloodType, IsDonorDeleted)
VALUES (@last_person_id, NULL, 0);

-- Insert Alex Taylor
INSERT INTO Person (FirstName, LastName, MiddleName, Nationality, Gender, PersonPhone, isPersonDeleted, AddressID)
VALUES ('Alex', 'Taylor', 'Lee', 'Canadian', 'male', '1122334455', 0, 9);
SET @last_person_id = LAST_INSERT_ID();
INSERT INTO Account (PersonID, AccountEmail, AccountPasswordHashed, Status, IsUser, IsAccountDeleted)
VALUES (@last_person_id, 'alextaylor@example.com', 'hashed_password_789', 'Active', 1, 0);
INSERT INTO Donor (PersonID, BloodType, IsDonorDeleted)
VALUES (@last_person_id, NULL, 0);

