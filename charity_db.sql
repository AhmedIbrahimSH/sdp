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

 CREATE TABLE IF NOT EXISTS events
 (
     title                varchar(50) not null,
     id                   int auto_increment
         primary key,
     location             varchar(50) not null,
     date                 date        not null,
     price                double      not null,
     type                 varchar(20) not null,
     registered_attendees int         null,
     constraint title
         unique (title)
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

#Donation tables

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

 INSERT INTO Donation (DonationID, DonationType, DonationDate, PaymentMethod, TotalAmount, PersonID) VALUES
                                                                                                         (1, 'Food', '2024-11-10', 'PayPal', 10 * 10.00, 1),  -- TotalAmount = Quantity * Amount
                                                                                                         (2, 'Cash', '2024-11-15', 'Credit Card', 200.00, 2), -- No Quantity for cash, TotalAmount = Amount
                                                                                                         (3, 'Clothes', '2024-11-18', 'Bank Transfer', 30 * 300.00, 2), -- TotalAmount = Quantity * Amount
                                                                                                         (4, 'Drugs', '2024-11-20', 'PayPal', 15 * 150.00, 3), -- TotalAmount = Quantity * Amount
                                                                                                         (5, 'Food', '2024-11-22', 'Credit Card', 20 * 250.00, 1); -- TotalAmount = Quantity * Amount

 INSERT INTO FoodDonation (DonationID, Quantity, Amount) VALUES
                                                             (1, 10, 10.00),  -- DonationID = 1 from Donation table
                                                             (5, 20, 250.00); -- DonationID = 5 from Donation table
 INSERT INTO CashDonation (DonationID, Amount) VALUES
     (2, 200.00); -- DonationID = 2 from Donation table

 INSERT INTO ClothesDonation (DonationID, Quantity, Amount) VALUES
     (3, 30, 300.00); -- DonationID = 3 from Donation table

 INSERT INTO DrugsDonation (DonationID, Quantity, Amount) VALUES
     (4, 15, 150.00); -- DonationID = 4 from Donation table





 INSERT INTO Invoice (InvoiceID, InvoiceDate, TotalAmount, PersonID) VALUES
     (1, '2024-11-17', 300.00, 101);

 INSERT INTO InvoiceDetails (DetailID, ItemDescription, Quantity, UnitPrice, LineTotal, InvoiceID, DonationID) VALUES
                                                                                                                   (1, 'Food Donation Kit', 2, 50.00, 100.00, 1, 1),
                                                                                                                   (2, 'Winter Clothing', 1, 150.00, 150.00, 1, 2),
                                                                                                                   (3, 'Education Supplies', 5, 10.00, 50.00, 1, 3);



