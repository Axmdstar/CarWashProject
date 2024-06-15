CREATE TABLE employee (
    id INT NOT NULL AUTO_INCREMENT,
    FirstName VARCHAR(255) NULL,
    MiddleName VARCHAR(255) NULL,
    LastName VARCHAR(255) NOT NULL,
    sex VARCHAR(10) NOT NULL,
    Number VARCHAR(10) NOT NULL,
    District VARCHAR(255) NOT NULL,
    magcaMasuulka VARCHAR(255) NOT NULL,
    NumberkaMassulka VARCHAR(10) NOT NULL,
    EmployeeType VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT,
    Username VARCHAR(255) NOT NULL,
    Pwd VARCHAR(255) NOT NULL,
    Reset BOOLEAN NOT NULL DEFAULT FALSE,
    AccessCode VARCHAR(255) NUll,
    emid INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (emid) REFERENCES Employee(id)
    ON DELETE CASCADE 
);

CREATE TABLE soldProducts (
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
CREATE TABLE product (
    id INT NOT NULL AUTO_INCREMENT,
    ProductName VARCHAR(155) NOT NULL,
    PurchaseAmount FLOAT NOT NULL,
    AddDate DATE NOT NULL,
    Available INT NOT NULL,
    Amount FLOAT NOT NULL,
    LastUpdated DATE NUll,
    PRIMARY KEY (id)
);

CREATE TABLE dailyServices (
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

CREATE TABLE serviceCategory (
    id INT NOT NULL AUTO_INCREMENT,
    CatName VARCHAR(255) NOT NULL,
    CommisionRate FLOAT NOT NULL,
    PRIMARY KEY (id)
);


CREATE TABLE services (
    id INT NOT NULL AUTO_INCREMENT,
    CarName VARCHAR(255) NOT NULL,
    Amount INT NOT NULL,
    ServiceCategoryId INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (ServiceCategoryId) REFERENCES ServiceCategory(id)
);

CREATE TABLE dailyAudit (
    id INT NOT NULL AUTO_INCREMENT,
    CreatedAt DATE NOT NULL,
    ServiceRevenue FLOAT NOT NULL,
    ProductSoldAmount FLOAT NOT NULL,
    CommisionAmount FLOAT NOT NULL,
    Expenses FLOAT NOT NULL,
    DailyIncome FLOAT NOT NULL,
    PRIMARY KEY (id)
);



CREATE TABLE expenses (
    id INT NOT NULL AUTO_INCREMENT,
    ExpenseType VARCHAR(255) NOT NULL,
    Description VARCHAR(255) NOT NULL,
    Amount INT NOT NULL,
    CreatedAt DATETIME NOT NULL,
    UsrId INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (UsrId) REFERENCES Users(id)
);

ALTER TABLE soldProducts ADD CONSTRAINT soldproducts_usrid_foreign FOREIGN KEY (UsrId) REFERENCES Users(id);
ALTER TABLE services ADD CONSTRAINT services_servicecategoryid_foreign FOREIGN KEY (ServiceCategoryId) REFERENCES ServiceCategory(id);
ALTER TABLE dailyServices ADD CONSTRAINT dailyservices_usrid_foreign FOREIGN KEY (UsrId) REFERENCES Users(id);



-- Procedures 

DELIMITER //
CREATE PROCEDURE GetDashboardSummary()
BEGIN
    SELECT
    (SELECT IFNULL(SUM(Quantity),0) FROM soldproducts WHERE DATE(Solddate) = DATE(CURRENT_DATE()))
    as NumofProduct,
    (SELECT IFNULL(COUNT(dailyservices.id),0) FROM  dailyservices WHERE DATE(CreatedAT) = DATE(CURRENT_DATE())) 
    as NumofServices,
    (SELECT IFNULL(SUM(Amount * Quantity), 0) FROM soldproducts WHERE DATE(Solddate) = DATE(CURRENT_DATE()) ) 
    as ProductRevenue,
    (SELECT IFNULL(SUM(Amount),0) FROM dailyServices WHERE DATE(CreatedAT) = DATE(CURRENT_DATE()))  
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
    (IFNULL((SELECT SUM(Amount * Quantity) AS ProductRevenue FROM soldProducts), 0) 
    +
	IFNULL((SELECT SUM(Amount) AS ServiceRevenue FROM dailyServices), 0))
    as TotalRevenue,

# This Month Total
    (IFNULL((SELECT SUM(Amount * Quantity) AS ProductRevenue FROM soldProducts 
     WHERE MONTH(Solddate) = MONTH(CURRENT_DATE()) AND Year(Solddate) = Year(CURRENT_DATE) ), 0)
     +
	IFNULL((SELECT SUM(Amount) AS ServiceRevenue FROM dailyServices 
     WHERE MONTH(CreatedAT) = MONTH(CURRENT_DATE()) AND Year(CreatedAT) = Year(CURRENT_DATE) ), 0)) as MonthRevenue,

# Today
	 (IFNULL((SELECT SUM(Amount * Quantity) AS ProductRevenue FROM soldProducts 
     WHERE DATE(Solddate) = DATE(CURRENT_DATE())), 0)
     +
	IFNULL((SELECT SUM(Amount) AS ServiceRevenue FROM dailyServices 
    WHERE DATE(CreatedAT) = DATE(CURRENT_DATE())), 0)) as TodayRevenue,

# TotalExpense    
    IFNULL((SELECT SUM(Amount) AS TotalExpenses FROM expenses),0) as TotalExpense,

# MonthExpense
	IFNULL((SELECT SUM(Amount) AS TotalExpenses FROM expenses
	WHERE MONTH(CreatedAt) = MONTH(CURRENT_DATE())),0) as MonthExpense;
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
                soldProducts
            WHERE
                DATE(Solddate) = DATE(CURRENT_DATE())
        ), 0
    ) AS TodayProduct,
    IFNULL(
        (
            SELECT
                SUM(Amount) 
            FROM
                dailyServices
            WHERE
                DATE(CreatedAT) = DATE(CURRENT_DATE())
        ), 0
    ) AS TodayServices,
    IFNULL(
        (
            SELECT
                ROUND(SUM(sc.CommisionRate), 2)
            FROM
                dailyServices ds
            JOIN
                Services s ON ds.Cartype = s.CarName
            JOIN
                ServiceCategory sc ON sc.CatName = ds.category
            WHERE
                DATE(ds.CreatedAT) = DATE(CURRENT_DATE())
        ), 0
    ) AS TodayCommission,
    IFNULL(
        (
            SELECT
                SUM(Amount) 
            FROM
                expenses
            WHERE
                DATE(CreatedAt) = DATE(CURRENT_DATE())
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
    FROM soldProducts
    WHERE DATE(Solddate) = DATE(CURRENT_DATE());

    -- Calculate TodayServices
    SELECT IFNULL(SUM(Amount), 0) INTO todayServices
    FROM dailyServices
    WHERE DATE(CreatedAT) = DATE(CURRENT_DATE());

    -- Calculate TodayCommission
    SELECT IFNULL(ROUND(SUM(sc.CommisionRate), 2), 0) INTO todayCommission
    FROM dailyServices ds
    JOIN Services s ON ds.Cartype = s.CarName
    JOIN ServiceCategory sc ON sc.CatName = ds.category
    WHERE DATE(ds.CreatedAT) = DATE(CURRENT_DATE());

    -- Calculate TodayExpense
    SELECT IFNULL(SUM(Amount), 0) INTO todayExpense
    FROM expenses
    WHERE DATE(CreatedAt) = DATE(CURRENT_DATE());

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
    IN p_CustomerNumber VARCHAR(20),
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
