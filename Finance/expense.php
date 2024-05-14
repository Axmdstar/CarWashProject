<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "carwash");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $expenseType = $_POST['ExpenseType'];
    $description = $_POST['Description'];
    $amount = $_POST['Amount'];
    $createdAt = $_POST['CreatedAt'];
    $userId = $_POST['UsrId'];

    // Prepared statement to prevent SQL injection
    $sql = "INSERT INTO Expenses (ExpenseType, Description, Amount, CreatedAt, UsrId) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdsi", $expenseType, $description, $amount, $createdAt, $userId);

    if ($stmt->execute()) {
        echo "Saved Successfully";

    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close(); // Close prepared statement
}

$conn->close(); // Close database connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Expense</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }
    .container {
        max-width: 600px;
        margin: 50px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h2 {
        text-align: center;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        margin-bottom: 5px;
    }
    .form-group input[type="text"],
    .form-group input[type="number"],
    .form-group input[type="datetime-local"] {
        width: calc(100% - 12px);
        padding: 8px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .form-group input[type="submit"] {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    .form-group input[type="submit"]:hover {
        background-color: #0056b3;
    }
</style>
</head>
<body>
<div class="container">

    <h2>Add Expense</h2>
    
    <form action="expense.php" method="post">

        <div class="form-group">
            <label for="expense_type">Expense Type:</label>
            <input type="text" id="expense_type" name="ExpenseType" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <input type="text" id="description" name="Description" required>
        </div>
        <div class="form-group">
            <label for="amount">Amount:</label>
            <input type="number" id="amount" name="Amount" min="0" required>
        </div>
        <div class="form-group">
            <label for="created_at">Created At:</label>
            <input type="datetime-local" id="created_at" name="CreatedAt" required>
        </div>
        <div class="form-group">
            <label for="user_id">User ID:</label>
            <input type="number" id="user_id" name="UsrId" min="1" required>
        </div>
        <div class="form-group">
            <input type="submit" value="Add Expense">
        </div>
    </form>
</div>
</body>
</html>
