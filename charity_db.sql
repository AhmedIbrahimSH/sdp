
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
                           FOREIGN KEY (PersonID) REFERENCES Account(PersonID) ON DELETE CASCADE
);

-- Beneficiary Module


-- Create Beneficiary table
CREATE TABLE IF NOT EXISTS Beneficiary (
    PersonID INT PRIMARY KEY,
    income DECIMAL(10, 2) NOT NULL,
    blood_type VARCHAR(3) NOT NULL,
    hasChronicDisease BOOLEAN DEFAULT FALSE,
    hasDisability BOOLEAN DEFAULT FALSE,
    isHomeless BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (PersonID) REFERENCES Person(PersonID) ON DELETE CASCADE
);



-- Create Storage table
CREATE TABLE IF NOT EXISTS Charity_Storage (
                             NeedID INT AUTO_INCREMENT PRIMARY KEY,
                             type VARCHAR(100) NOT NULL,
                             Amount DECIMAL(10, 2) NOT NULL,
                             Spendings DECIMAL(10, 2) NOT NULL,
                             Donors INT DEFAULT 3,
                             AffectedPeople INT DEFAULT 0
                                
);

-- Create Need tables
CREATE TABLE IF NOT EXISTS CashNeedHistory (
                    AllocationID INT AUTO_INCREMENT PRIMARY KEY,
                             BeneficiaryID INT,
                             Amount DECIMAL(10, 2) NOT NULL,
                             Allocated BOOLEAN DEFAULT FALSE,
                             Accepted BOOLEAN DEFAULT FALSE,
                             RegisterDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                             purpose TEXT DEFAULT "Cash Assistance for Low Income/Disabled beneficiary",
                             FOREIGN KEY (BeneficiaryID) REFERENCES Beneficiary(PersonID) ON DELETE CASCADE
);



CREATE TABLE IF NOT EXISTS FoodNeedHistory (
    AllocationID INT AUTO_INCREMENT PRIMARY KEY,
                            BeneficiaryID INT Not NULL,
                                Amount DECIMAL(10, 2) NOT NULL,
                                Allocated BOOLEAN DEFAULT FALSE,
                                Accepted BOOLEAN DEFAULT FALSE,
                                RegisterDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                purpose TEXT DEFAULT "Food Assistance for low income beneficiary",
                                FOREIGN KEY (BeneficiaryID) REFERENCES Beneficiary(PersonID) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS ShelterNeedHistory (
    -- no need for allocation id as the beneficiary will have 1 shelter allocation
                            BeneficiaryID INT Not NULL,
                                Amount DECIMAL(10, 2) DEFAULT 1,
                                Allocated BOOLEAN DEFAULT FALSE,
                                Accepted BOOLEAN DEFAULT FALSE,
                                RegisterDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                purpose TEXT DEFAULT "Shelter Assistance for Homeless beneficiary",
                                FOREIGN KEY (BeneficiaryID) REFERENCES Beneficiary(PersonID) ON DELETE CASCADE 
);

CREATE TABLE IF NOT EXISTS ClothingNeedHistory (
    AllocationID INT AUTO_INCREMENT PRIMARY KEY,
                            BeneficiaryID INT Not NULL,
                                Amount DECIMAL(10, 2) DEFAULT 1,
                                Allocated BOOLEAN DEFAULT FALSE,
                                Accepted BOOLEAN DEFAULT FALSE,
                                RegisterDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                purpose TEXT DEFAULT "Clothing Assistance for low income beneficiary",
                                FOREIGN KEY (BeneficiaryID) REFERENCES Beneficiary(PersonID) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS MedicalNeedHistory (
    AllocationID INT AUTO_INCREMENT PRIMARY KEY,
                            BeneficiaryID INT Not NULL,
                                Amount DECIMAL(10, 2) DEFAULT 1,
                                Allocated BOOLEAN DEFAULT FALSE,
                                Accepted BOOLEAN DEFAULT FALSE,
                                RegisterDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                purpose TEXT DEFAULT "Medical Assistance for Low Income beneficiary",
                                FOREIGN KEY (BeneficiaryID) REFERENCES Beneficiary(PersonID) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS DrugNeedHistory (
    AllocationID INT AUTO_INCREMENT PRIMARY KEY,
                            BeneficiaryID INT Not NULL,
                                Amount DECIMAL(10, 2) DEFAULT 1,
                                Allocated BOOLEAN DEFAULT FALSE,
                                Accepted BOOLEAN DEFAULT FALSE,
                                RegisterDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                purpose TEXT DEFAULT "Assistance for Low Income/Has Chronic Disease beneficiary",
                                FOREIGN KEY (BeneficiaryID) REFERENCES Beneficiary(PersonID) ON DELETE CASCADE
);



-- Beneficiary Module 

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

-- Insert Beneficiary Admin: Omar Diab
INSERT INTO Person (FirstName, LastName, MiddleName, Nationality, Gender, PersonPhone, AddressID)
VALUES ('Omar', 'Diab', 'Mosaad', 'Egyptian', 'Male', '01076543210', 2);
SET @last_person_id = LAST_INSERT_ID();

INSERT INTO Account (PersonID, AccountEmail, AccountPasswordHashed, Status, IsUser, IsAccountDeleted)
VALUES (@last_person_id, 'omarmdiab35@gmail.com', 'hashed_password_admin_001', 'Active', 1, 0);

INSERT INTO Admin (PersonID, AdminType)
VALUES (@last_person_id, 'BeneficiaryAdmin');



-- Beneficiaries Fill

-- Insert Beneficiary 1: Ahmed Hassan
INSERT INTO Person (FirstName, LastName, MiddleName, Nationality, Gender, PersonPhone, AddressID)
VALUES ('Ahmed', 'Hassan', 'Ali', 'Egyptian', 'Male', '01012345678', 1);

SET @last_person_id = LAST_INSERT_ID();
INSERT INTO Beneficiary (PersonID, income, blood_type, hasChronicDisease, hasDisability, isHomeless)
VALUES (@last_person_id, 2000.00, 'A+', FALSE, TRUE, FALSE);



-- Insert Beneficiary 2: Sara Mohamed
INSERT INTO Person (FirstName, LastName, MiddleName, Nationality, Gender, PersonPhone, AddressID)
VALUES ('Sara', 'Mohamed', 'Youssef', 'Egyptian', 'Female', '01098765432', 2);

SET @last_person_id = LAST_INSERT_ID();
INSERT INTO Beneficiary (PersonID, income, blood_type, hasChronicDisease, hasDisability, isHomeless)
VALUES (@last_person_id, 1500.00, 'B-', TRUE, FALSE, FALSE);



-- Insert Beneficiary 3: Omar Adel
INSERT INTO Person (FirstName, LastName, MiddleName, Nationality, Gender, PersonPhone, AddressID)
VALUES ('Omar', 'Adel', 'Khaled', 'Egyptian', 'Male', '01056781234', 3);

SET @last_person_id = LAST_INSERT_ID();
INSERT INTO Beneficiary (PersonID, income, blood_type, hasChronicDisease, hasDisability, isHomeless)
VALUES (@last_person_id, 0.00, 'O+', FALSE, FALSE, TRUE);



-- Insert Beneficiary 4: Mariam Ehab
INSERT INTO Person (FirstName, LastName, MiddleName, Nationality, Gender, PersonPhone, AddressID)
VALUES ('Mariam', 'Ehab', 'Fouad', 'Egyptian', 'Female', '01023456789', 1);

SET @last_person_id = LAST_INSERT_ID();
INSERT INTO Beneficiary (PersonID, income, blood_type, hasChronicDisease, hasDisability, isHomeless)
VALUES (@last_person_id, 1000.00, 'AB-', TRUE, TRUE, FALSE);

-- Insert storage data
INSERT INTO Charity_Storage (type, Amount, Spendings,AffectedPeople)
VALUES 
    ('Cash', 15000.00, 0.00,0),
    ('Food', 5000.00, 0.00,0),
    ('Clothing', 2000.00, 0.00,0),
    ('Drugs', 3000.00, 0.00,0),
    ('Shelter', 1000.00, 0.00,0),
    ('Medical', 8000.00, 0.00,0);


INSERT INTO CashNeedHistory (BeneficiaryID, Amount, Allocated, Accepted)
VALUES ((SELECT PersonID FROM Beneficiary WHERE PersonID = 2), 1000.00, TRUE,TRUE);


UPDATE Charity_Storage 
SET Spendings = Spendings + 1000.00, Amount = Amount - 1000.00, AffectedPeople = AffectedPeople + 1
WHERE type = 'Cash';




INSERT INTO FoodNeedHistory (BeneficiaryID, Amount, Allocated, Accepted)
VALUES ((SELECT PersonID FROM Beneficiary WHERE PersonID = 2), 1.00, TRUE,TRUE);


UPDATE Charity_Storage 
SET Spendings = Spendings + 1.00, Amount = Amount - 1.00, AffectedPeople = AffectedPeople + 1
WHERE type = 'Food';




INSERT INTO CashNeedHistory (BeneficiaryID, Amount, Allocated, Accepted)
VALUES ((SELECT PersonID FROM Beneficiary WHERE PersonID = 3), 1500.00, FALSE, FALSE);


INSERT INTO FoodNeedHistory (BeneficiaryID, Amount, Allocated, Accepted)
VALUES ((SELECT PersonID FROM Beneficiary WHERE PersonID = 3), 2.00, FALSE,TRUE);




-- Insert John Doe
INSERT INTO Person (FirstName, LastName, MiddleName, Nationality, Gender, PersonPhone, AddressID)
VALUES ('John', 'Doe', 'Michael', 'American', 'Male', '1234567890',  1);
SET @last_person_id = LAST_INSERT_ID();
INSERT INTO Account (PersonID, AccountEmail, AccountPasswordHashed, Status, IsUser, IsAccountDeleted)
VALUES (@last_person_id, 'johndoe@example.com', 'hashed_password_123', 'Active', 1, 0);
INSERT INTO Donor (PersonID, BloodType, IsDonorDeleted)
VALUES (@last_person_id, 'O+', 0);

-- Insert Jane Smith
INSERT INTO Person (FirstName, LastName, MiddleName, Nationality, Gender, PersonPhone, AddressID)
VALUES ('Jane', 'Smith', NULL, 'British', 'Female', '0987654321', 2);
SET @last_person_id = LAST_INSERT_ID();
INSERT INTO Account (PersonID, AccountEmail, AccountPasswordHashed, Status, IsUser, IsAccountDeleted)
VALUES (@last_person_id, 'janesmith@example.com', 'hashed_password_456', 'Active', 1, 0);
INSERT INTO Donor (PersonID, BloodType, IsDonorDeleted)
VALUES (@last_person_id, NULL, 0);

-- Insert Alex Taylor
INSERT INTO Person (FirstName, LastName, MiddleName, Nationality, Gender, PersonPhone, AddressID)
VALUES ('Alex', 'Taylor', 'Lee', 'Canadian', 'Other', '1122334455', 3);
SET @last_person_id = LAST_INSERT_ID();
INSERT INTO Account (PersonID, AccountEmail, AccountPasswordHashed, Status, IsUser, IsAccountDeleted)
VALUES (@last_person_id, 'alextaylor@example.com', 'hashed_password_789', 'Active', 1, 0);
INSERT INTO Donor (PersonID, BloodType, IsDonorDeleted)
VALUES (@last_person_id, NULL, 0);


