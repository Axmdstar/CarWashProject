CREATE TABLE Employee (
    id INT NOT NULL AUTO_INCREMENT,
    FirstName VARCHAR(255) NULL,
    MiddleName VARCHAR(255) NULL,
    LastName VARCHAR(255) NOT NULL,
    sex VARCHAR(10) NOT NULL,
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
    Reset BOOLEAN NOT NULL DEFAULT FALSE,
    emid INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (emid) REFERENCES Employee(id)
);

CREATE TABLE SoldProducts (
    id INT NOT NULL AUTO_INCREMENT,
    ProductName VARCHAR(255) NOT NULL,
    Quantity INT NOT NULL,
    Amount FLOAT NOT NULL,
    CustomerNumber INT NOT NULL,
    Solddate DATETIME NOT NULL,
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
    Amount FLOAT NOT NULL,
    CreatedAT DATETIME NOT NULL,
    CustomerNumber INT NOT NULL,
    UsrId INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (UsrId) REFERENCES Users(id)
);

CREATE TABLE ServiceCategory (
    id INT NOT NULL AUTO_INCREMENT,
    CatName VARCHAR(255) NOT NULL,
    CommisionRate FLOAT NOT NULL,
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
    ServiceRevenue FLOAT NOT NULL,
    ProductSoldAmount FLOAT NOT NULL,
    CommisionAmount FLOAT NOT NULL,
    Expenses FLOAT NOT NULL,
    DailyIncome FLOAT NOT NULL,
    PRIMARY KEY (id)
);



CREATE TABLE Expenses (
    id INT NOT NULL AUTO_INCREMENT,
    ExpenseType VARCHAR(255) NOT NULL,
    Description VARCHAR(255) NOT NULL,
    Amount INT NOT NULL,
    CreatedAt DATETIME NOT NULL,
    UsrId INT NOT NULL,
    PRIMARY KEY (id)
);

ALTER TABLE SoldProducts ADD CONSTRAINT soldproducts_usrid_foreign FOREIGN KEY (UsrId) REFERENCES Users(id);
ALTER TABLE Services ADD CONSTRAINT services_servicecategoryid_foreign FOREIGN KEY (ServiceCategoryId) REFERENCES ServiceCategory(id);
ALTER TABLE DailyServices ADD CONSTRAINT dailyservices_usrid_foreign FOREIGN KEY (UsrId) REFERENCES Users(id);



-- Procedures 

DELIMITER //
CREATE PROCEDURE GetDashboardSummary()
BEGIN
     SELECT
    (SELECT IFNULL(SUM(Quantity),0) FROM soldproducts WHERE DAY(Solddate) = DAY(CURRENT_DATE()))
    as NumofProductSoldAndRevenue,
    (SELECT IFNULL(COUNT(dailyservices.id),0) FROM  dailyservices WHERE DAY(CreatedAT) = DAY(CURRENT_DATE())) 
    as NumofServices,
    (SELECT IFNULL(SUM(Amount * Quantity), 0) FROM soldproducts WHERE DAY(Solddate) = DAY(CURRENT_DATE()) ) 
    as ProductRevenue,
    (SELECT IFNULL(SUM(Amount),0) FROM DailyServices WHERE DAY(CreatedAT) = DAY(CURRENT_DATE()))  
    as ServiceRevenue;
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


Pie Chart Data
DELIMITER //
CREATE PROCEDURE ServiceChartData()
BEGIN
    SELECT Cartype As ServiceName, COUNT(Cartype) As ServiceCount FROM dailyservices
    GROUP BY Cartype;
END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE FinDashBoardData()
BEGIN
# Total
SELECT
    (IFNULL((SELECT SUM(Amount * Quantity) AS ProductRevenue FROM SoldProducts), 0) 
    +
	IFNULL((SELECT SUM(Amount) AS ServiceRevenue FROM DailyServices), 0))
    as TotalRevenue,
# This Month Total
    (IFNULL((SELECT SUM(Amount * Quantity) AS ProductRevenue FROM SoldProducts 
     WHERE MONTH(Solddate) = MONTH(CURRENT_DATE())), 0)
     +
	IFNULL((SELECT SUM(Amount) AS ServiceRevenue FROM DailyServices 
     WHERE MONTH(CreatedAT) = MONTH(CURRENT_DATE())), 0)) as MonthRevenue,
# Today
	 (IFNULL((SELECT SUM(Amount * Quantity) AS ProductRevenue FROM SoldProducts 
     WHERE DAY(Solddate) = DAY(CURRENT_DATE())), 0)
     +
	IFNULL((SELECT SUM(Amount) AS ServiceRevenue FROM DailyServices 
    WHERE DAY(CreatedAT) = DAY(CURRENT_DATE())), 0)) as TodayRevenue,
# TotalExpense    
    (SELECT SUM(Amount) AS TotalExpenses FROM Expenses) as TotalExpense,
# MonthExpense
	(SELECT SUM(Amount) AS TotalExpenses FROM Expenses
	WHERE MONTH(CreatedAt) = MONTH(CURRENT_DATE())) as MonthExpense;
END //
DELIMITER ;




DELIMITER //
CREATE PROCEDURE IncomeStatement() 
BEGIN
SELECT
    IFNULL(
        (
            SELECT
                SUM(Amount * Quantity) AS ProductRevenue
            FROM
                SoldProducts
            WHERE
                DAY(Solddate) = DAY(CURRENT_DATE())
        ), 0
    ) AS TodayProduct,
    IFNULL(
        (
            SELECT
                SUM(Amount) 
            FROM
                DailyServices
            WHERE
                DAY(CreatedAT) = DAY(CURRENT_DATE())
        ), 0
    ) AS TodayServices,
    IFNULL(
        (
            SELECT
                ROUND(SUM(sc.CommisionRate), 2)
            FROM
                DailyServices ds
            JOIN
                Services s ON ds.Cartype = s.CarName
            JOIN
                ServiceCategory sc ON sc.CatName = ds.category
            WHERE
                DAY(ds.CreatedAT) = DAY(CURRENT_DATE())
        ), 0
    ) AS TodayCommission,
    IFNULL(
        (
            SELECT
                SUM(Amount) 
            FROM
                Expenses
            WHERE
                DAY(CreatedAt) = DAY(CURRENT_DATE())
        ), 0
    ) AS TodayExpense;

END //
DELIMITER ;



DELIMITER //

CREATE PROCEDURE InsertDailyAudit()
BEGIN
    DECLARE todayProduct DECIMAL(10, 2);
    DECLARE todayServices DECIMAL(10, 2);
    DECLARE todayCommission DECIMAL(10, 2);
    DECLARE todayExpense DECIMAL(10, 2);
    DECLARE dailyIncome DECIMAL(10, 2);

    -- Calculate TodayProduct
    SELECT IFNULL(SUM(Amount * Quantity), 0) INTO todayProduct
    FROM SoldProducts
    WHERE DAY(Solddate) = DAY(CURRENT_DATE());

    -- Calculate TodayServices
    SELECT IFNULL(SUM(Amount), 0) INTO todayServices
    FROM DailyServices
    WHERE DAY(CreatedAT) = DAY(CURRENT_DATE());

    -- Calculate TodayCommission
    SELECT IFNULL(ROUND(SUM(sc.CommisionRate), 2), 0) INTO todayCommission
    FROM DailyServices ds
    JOIN Services s ON ds.Cartype = s.CarName
    JOIN ServiceCategory sc ON sc.CatName = ds.category
    WHERE DAY(ds.CreatedAT) = DAY(CURRENT_DATE());

    -- Calculate TodayExpense
    SELECT IFNULL(SUM(Amount), 0) INTO todayExpense
    FROM Expenses
    WHERE DAY(CreatedAt) = DAY(CURRENT_DATE());

    -- Calculate DailyIncome
    SET dailyIncome = todayProduct + todayServices - todayExpense - todayCommission;

    -- Insert into dailyaudit table
    INSERT INTO dailyaudit (CreatedAt, ServiceRevenue, ProductSoldAmount, CommisionAmount, Expenses, DailyIncome)
    VALUES (CURRENT_DATE(), todayServices, todayProduct, todayCommission, todayExpense, dailyIncome);
END //

DELIMITER ;



DELIMITER //
CREATE EVENT DailyAuditEvent
ON SCHEDULE EVERY 1 DAY
STARTS TIMESTAMP(CURRENT_DATE) + INTERVAL 10 HOUR   -- This specifies the time of day to run the event (10:00:00 in this case)
DO
BEGIN
    CALL InsertDailyAudit; -- Replace my_task() with the name of your stored procedure
END //
DELIMITER ;




DELIMITER //
CREATE PROCEDURE UpdateProduct(
    
    IN p_ProductName VARCHAR(255),
    IN p_Quantity INT,
    IN p_Amount DECIMAL(10,2),
    IN p_CustomerNumber INT,
    IN p_UsrName VARCHAR(255)
)
BEGIN

    -- Update the product table
    UPDATE product as pt
    SET 
        pt.Available = pt.Available - p_Quantity -- Subtract quantity from Available
    WHERE pt.ProductName = p_ProductName;

    -- Insert into soldproducts table
    INSERT INTO soldproducts (
        ProductName, Quantity, Amount, CustomerNumber, Solddate, UsrId
    ) VALUES (
         p_ProductName, p_Quantity, p_Amount, p_CustomerNumber, NOW(), (SELECT id FROM users WHERE Username = p_UsrName)
    );

END //

DELIMITER ;
