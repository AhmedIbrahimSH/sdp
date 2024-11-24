
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
                                      Phone VARCHAR(15) UNIQUE ,
                                      AddressID INT,
                                      FOREIGN KEY (AddressID) REFERENCES Address(AddressID) ON DELETE SET NULL
);


-- Create Account table
CREATE TABLE IF NOT EXISTS  Account (
                                    PersonID INT PRIMARY KEY,
                                    Email VARCHAR(100) UNIQUE NOT NULL,
                                    PasswordHashed  VARCHAR(255) NOT NULL,
                                    IsUser TINYINT(1) DEFAULT 1,
                                    IsAccountDeleted TINYINT(1) DEFAULT 0,
                                    FOREIGN KEY (PersonID) REFERENCES Person(PersonID) ON DELETE CASCADE
);

-- Create Admin table
CREATE TABLE  IF NOT EXISTS  Admin (
                               PersonID INT PRIMARY KEY,
                               Type ENUM('BeneficiaryAdmin', 'DonationAdmin', 'VolunteerAdmin','PayementAdmin','EventAdmin') NOT NULL,
                               FOREIGN KEY (PersonID) REFERENCES Account(PersonID) ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS Donor (
                             PersonID INT PRIMARY KEY,
                             IsDonorDeleted TINYINT(1) DEFAULT 0,
                             FOREIGN KEY (PersonID) REFERENCES Account(PersonID) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Volunteer (
    PersonID INT PRIMARY KEY,
    IsVolunteerDeleted TINYINT(1) DEFAULT 0,
    FOREIGN KEY (PersonID) REFERENCES Account(PersonID) ON DELETE CASCADE
);

-- Beneficiary Module Begin


-- Create Beneficiary table
CREATE TABLE IF NOT EXISTS Beneficiary (
    PersonID INT PRIMARY KEY,
    income DECIMAL(10, 2) NOT NULL,
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
                             Donations INT DEFAULT 0,
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
    AllocationID INT AUTO_INCREMENT PRIMARY KEY,
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
-- Beneficiary Module END


-- Donation Module Begin
CREATE TABLE IF NOT EXISTS Donation (
                           DonationID INT PRIMARY KEY,
                           DonationType VARCHAR(50),
                           DonationDate DATE,
                           PaymentMethod VARCHAR(50),
                           TotalAmount DECIMAL(10, 2),
                           PersonID INT
 );


 CREATE TABLE IF NOT EXISTS FoodDonation (
                               DonationID INT PRIMARY KEY,
                               Quantity INT,
                               Amount DECIMAL(10, 2),
                               FOREIGN KEY (DonationID) REFERENCES Donation(DonationID)
 );

 CREATE TABLE IF NOT EXISTS CashDonation (
                               DonationID INT PRIMARY KEY,
                               -- Currency VARCHAR(50),
                               Amount DECIMAL(10, 2),
                               FOREIGN KEY (DonationID) REFERENCES Donation(DonationID)
 );
 CREATE TABLE IF NOT EXISTS ClothesDonation (
                                  DonationID INT PRIMARY KEY,
                                  Quantity INT,
                                  Amount DECIMAL(10, 2),
                                  FOREIGN KEY (DonationID) REFERENCES Donation(DonationID)
 );
 CREATE TABLE IF NOT EXISTS DrugsDonation (
                                DonationID INT PRIMARY KEY,
                                Quantity INT,
                                Amount DECIMAL(10, 2),
                                FOREIGN KEY (DonationID) REFERENCES Donation(DonationID)
 );
 CREATE TABLE IF NOT EXISTS Payment (
                          PaymentID INT PRIMARY KEY,
                          PaymentAmount DECIMAL(10, 2),
                          PaymentDate DATE,
                          Status VARCHAR(50),
                          DonationID INT,
                          FOREIGN KEY (DonationID) REFERENCES Donation(DonationID)
 );

 CREATE TABLE IF NOT EXISTS Paypal (
                         PaymentID INT PRIMARY KEY,
                         PayPalEmail VARCHAR(100),
                         FOREIGN KEY (PaymentID) REFERENCES Payment(PaymentID)
 );

 CREATE TABLE IF NOT EXISTS CreditCard (
                             PaymentID INT PRIMARY KEY,
                             CardNumber VARCHAR(16),
                             CardHolderName VARCHAR(100),
                             ExpirationDate DATE,
                             CVV VARCHAR(4),
                             FOREIGN KEY (PaymentID) REFERENCES Payment(PaymentID)
 );

 CREATE TABLE IF NOT EXISTS BankTransfer (
                               PaymentID INT PRIMARY KEY,
                               BankAccountNumber VARCHAR(50),
                               BankName VARCHAR(100),
                               FOREIGN KEY (PaymentID) REFERENCES Payment(PaymentID)
 );

 CREATE TABLE IF NOT EXISTS Invoice (
                          InvoiceID INT PRIMARY KEY,
                          InvoiceDate DATE,
                          TotalAmount DECIMAL(10, 2),
                          PersonID INT
 );

 CREATE TABLE IF NOT EXISTS  InvoiceDetails (
                                 DetailID INT PRIMARY KEY,
                                 ItemDescription VARCHAR(255),
                                 Quantity INT,
                                 UnitPrice DECIMAL(10, 2),
                                 LineTotal DECIMAL(10, 2),
                                 InvoiceID INT,
                                 DonationID INT,
                                 FOREIGN KEY (InvoiceID) REFERENCES Invoice(InvoiceID),
                                 FOREIGN KEY (DonationID) REFERENCES Donation(DonationID)
 );
-- Donation Module END



-- Event Module Begin
CREATE TABLE IF NOT EXISTS events (
    EventID INT AUTO_INCREMENT PRIMARY KEY,
    Title VARCHAR(50) NOT NULL UNIQUE,
    Location VARCHAR(50) NOT NULL,
    Date DATE NOT NULL,
    Price DECIMAL(10, 2) NOT NULL,
    Type VARCHAR(20) NOT NULL,
    RegisteredAttendees INT DEFAULT 0
);
-- Event Module END


-- Volunteer Module Begin
CREATE TABLE  Skill (
    id INT AUTO_INCREMENT PRIMARY KEY,      -- Foreign key to volunteers table
    skill VARCHAR(255) NOT NULL
    );

-- Create the volunteer_skills table to store skills associated with each volunteer
CREATE TABLE  Skills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    PersonID INT,                            -- Foreign key to volunteers table
    skill_id INT,
    FOREIGN KEY (PersonID) REFERENCES Volunteer(PersonID) ON DELETE CASCADE,
    FOREIGN KEY (skill_id) REFERENCES Skill(id) ON DELETE CASCADE
);




-- Create the volunteer_tasks table to store tasks associated with each volunteer
CREATE TABLE  Tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    PersonID INT,                            -- Foreign key to volunteers table
    task_name VARCHAR(255) NOT NULL,
    description TEXT,
    due_date DATE,
    FOREIGN KEY (PersonID) REFERENCES Volunteer(PersonID) ON DELETE CASCADE
);
-- Create the volunteer_schedule table to store schedule information for each volunteer
CREATE TABLE  schedule (
    id INT AUTO_INCREMENT PRIMARY KEY,
    PersonID INT,                            -- Foreign key to Volunteer table
    schedule_date DATE NOT NULL,
    hours INT NOT NULL,
    FOREIGN KEY (PersonID) REFERENCES Volunteer(PersonID) ON DELETE CASCADE
);


-- Volunteer Module END

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
INSERT INTO Person (FirstName, LastName, MiddleName, Nationality, Gender, Phone, AddressID)
VALUES ('Omar', 'Diab', 'Mosaad', 'Egyptian', 'Male', '01076543210', 2);
SET @last_PersonID = LAST_INSERT_ID();

INSERT INTO Account (PersonID, Email, PasswordHashed,  IsUser, IsAccountDeleted)
VALUES (@last_PersonID, 'omarmdiab35@gmail.com', 'hashed_password_admin_001',  1, 0);

INSERT INTO Admin (PersonID, Type)
VALUES (@last_PersonID, 'BeneficiaryAdmin');



-- Beneficiaries Fill

-- Insert Beneficiary 1: Ahmed Hassan
INSERT INTO Person (FirstName, LastName, MiddleName, Nationality, Gender, Phone, AddressID)
VALUES ('Ahmed', 'Hassan', 'Ali', 'Egyptian', 'Male', '01012345678', 1);

SET @last_PersonID = LAST_INSERT_ID();
INSERT INTO Beneficiary (PersonID, income,  hasChronicDisease, hasDisability, isHomeless)
VALUES (@last_PersonID, 2000.00,  FALSE, TRUE, FALSE);



-- Insert Beneficiary 2: Sara Mohamed
INSERT INTO Person (FirstName, LastName, MiddleName, Nationality, Gender, Phone, AddressID)
VALUES ('Sara', 'Mohamed', 'Youssef', 'Egyptian', 'Female', '01098765432', 2);

SET @last_PersonID = LAST_INSERT_ID();
INSERT INTO Beneficiary (PersonID, income,  hasChronicDisease, hasDisability, isHomeless)
VALUES (@last_PersonID, 1500.00,  TRUE, FALSE, FALSE);



-- Insert Beneficiary 3: Omar Adel
INSERT INTO Person (FirstName, LastName, MiddleName, Nationality, Gender, Phone, AddressID)
VALUES ('Omar', 'Adel', 'Khaled', 'Egyptian', 'Male', '01056781234', 3);

SET @last_PersonID = LAST_INSERT_ID();
INSERT INTO Beneficiary (PersonID, income,  hasChronicDisease, hasDisability, isHomeless)
VALUES (@last_PersonID, 0.00,  FALSE, FALSE, TRUE);



-- Insert Beneficiary 4: Mariam Ehab
INSERT INTO Person (FirstName, LastName, MiddleName, Nationality, Gender, Phone, AddressID)
VALUES ('Mariam', 'Ehab', 'Fouad', 'Egyptian', 'Female', '01023456789', 1);

SET @last_PersonID = LAST_INSERT_ID();
INSERT INTO Beneficiary (PersonID, income,  hasChronicDisease, hasDisability, isHomeless)
VALUES (@last_PersonID, 1000.00, TRUE, TRUE, FALSE);

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
INSERT INTO Person (FirstName, LastName, MiddleName, Nationality, Gender, Phone, AddressID)
VALUES ('John', 'Doe', 'Michael', 'American', 'Male', '1234567890',  1);
SET @last_PersonID = LAST_INSERT_ID();
INSERT INTO Account (PersonID, Email, PasswordHashed,  IsUser, IsAccountDeleted)
VALUES (@last_PersonID, 'johndoe@example.com', 'hashed_password_123',  1, 0);
INSERT INTO Donor (PersonID,IsDonorDeleted)
VALUES (@last_PersonID,  0);

-- Insert Jane Smith
INSERT INTO Person (FirstName, LastName, MiddleName, Nationality, Gender, Phone, AddressID)
VALUES ('Jane', 'Smith', NULL, 'British', 'Female', '0987654321', 2);
SET @last_PersonID = LAST_INSERT_ID();
INSERT INTO Account (PersonID, Email, PasswordHashed,  IsUser, IsAccountDeleted)
VALUES (@last_PersonID, 'janesmith@example.com', 'hashed_password_456',  1, 0);
INSERT INTO Donor (PersonID, IsDonorDeleted)
VALUES (@last_PersonID,  0);

-- Insert Alex Taylor
INSERT INTO Person (FirstName, LastName, MiddleName, Nationality, Gender, Phone, AddressID)
VALUES ('Alex', 'Taylor', 'Lee', 'Canadian', 'Other', '1122334455', 3);
SET @last_PersonID = LAST_INSERT_ID();
INSERT INTO Account (PersonID, Email, PasswordHashed,  IsUser, IsAccountDeleted)
VALUES (@last_PersonID, 'alextaylor@example.com', 'hashed_password_789',  1, 0);
INSERT INTO Donor (PersonID, IsDonorDeleted)
VALUES (@last_PersonID, 0);
