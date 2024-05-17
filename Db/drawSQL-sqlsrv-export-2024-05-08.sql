CREATE TABLE Employee (
    id INT NOT NULL AUTO_INCREMENT,
    FirstName VARCHAR(255) NULL,
    MiddleName VARCHAR(255) NULL,
    LastName VARCHAR(255) NOT NULL,
    Number INT NOT NULL,
    District VARCHAR(255) NOT NULL,
    magcaMasuulka VARCHAR(255) NOT NULL,
    NumberkaMassulka INT NOT NULL,
    EmployeeType VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT,
    Username VARCHAR(255) NOT NULL,
    Pwd VARCHAR(255) NOT NULL,
    emid INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (emid) REFERENCES Employee(id)
);

CREATE TABLE SoldProducts (
    id INT NOT NULL AUTO_INCREMENT,
    ProductName VARCHAR(255) NOT NULL,
    Quantity INT NOT NULL,
    Amount INT NOT NULL,
    CustomerNumber INT NOT NULL,
    DateTIme DATETIME NOT NULL,
    UsrId INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (UsrId) REFERENCES Users(id)
);

-- Changed items to Available
CREATE TABLE Product (
    id INT NOT NULL AUTO_INCREMENT,
    ProductName VARCHAR(155) NOT NULL,
    PurchaseAmount FLOAT NOT NULL,
    AddDate DATE NOT NULL,
    Available INT NOT NULL,
    Amount FLOAT NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE DailyServices (
    id INT NOT NULL AUTO_INCREMENT,
    Cartype VARCHAR(255) NOT NULL,
    category VARCHAR(255) NOT NULL,
    Amount INT NOT NULL,
    CreatedAT DATETIME NOT NULL,
    CustomerNumber INT NOT NULL,
    UsrId INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (UsrId) REFERENCES Users(id)
);

CREATE TABLE ServiceCategory (
    id INT NOT NULL AUTO_INCREMENT,
    CatName VARCHAR(255) NOT NULL,
    CommisionRate DECIMAL(8, 2) NOT NULL,
    PRIMARY KEY (id)
);


CREATE TABLE Services (
    id INT NOT NULL AUTO_INCREMENT,
    CarName VARCHAR(255) NOT NULL,
    Amount INT NOT NULL,
    ServiceCategoryId INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (ServiceCategoryId) REFERENCES ServiceCategory(id)
);

CREATE TABLE DailyAudit (
    id INT NOT NULL AUTO_INCREMENT,
    CreatedAt DATE NOT NULL,
    ServiceRevenue DECIMAL(8, 2) NOT NULL,
    ProductSoldAmount DECIMAL(8, 2) NOT NULL,
    CommisionAmount DECIMAL(8, 2) NOT NULL,
    Joornaati INT NOT NULL,
    DailyIncome DECIMAL(8, 2) NOT NULL,
    PRIMARY KEY (id)
);



CREATE TABLE Expenses (
    id INT NOT NULL AUTO_INCREMENT,
    ExpenseType VARCHAR(255) NOT NULL,
    Description VARCHAR(255) NOT NULL,
    Amount INT NOT NULL,
    CreatedAt DATETIME NULL,
    UsrId INT NOT NULL,
    PRIMARY KEY (id)
);

ALTER TABLE SoldProducts ADD CONSTRAINT soldproducts_usrid_foreign FOREIGN KEY (UsrId) REFERENCES Users(id);
ALTER TABLE Services ADD CONSTRAINT services_servicecategoryid_foreign FOREIGN KEY (ServiceCategoryId) REFERENCES ServiceCategory(id);
ALTER TABLE DailyServices ADD CONSTRAINT dailyservices_usrid_foreign FOREIGN KEY (UsrId) REFERENCES Users(id);



-- Procedures 

DELIMITER //
CREATE PROCEDURE GetNumberOfProductSold()
BEGIN
    SELECT SUM(Quantity) as NumofProductSold FROM soldproducts;
END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE GetUserId(
    IN username VARCHAR(100)
)
BEGIN
    SELECT users.id FROM users WHERE users.Username = username ;
END //
DELIMITER ;