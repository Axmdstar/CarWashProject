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

    
}
?>


<!doctype html>
<html lang="en">
<?php include "../Components/HeadContent.php" ?>
<link rel="stylesheet" href="service.css">

<body>

  <?php include '../Components/NavBar.php' ?>

  <main id="main" class="main">

    <div class="container">

    <h2>Add Expense</h2>
    
    <form action="expense.php" method="post">

    <!-- <div class="form-floating mb-3 ">
                <input type="text" name="ServiceName" class="form-control" id="floatingInput" placeholder="" autofocus required >
                <label for="floatingInput">Service Name</label>
    </div> -->

        <div class="form-floating mb-3">
            <input class="form-control" type="text" id="expense_type" name="ExpenseType" required>
            <label for="expense_type">Expense Type:</label>
        </div>

        <div class="form-floating mb-3">
            <input class="form-control" type="text" id="description" name="Description" required>
            <label for="description">Description:</label>
        </div>

        <div class="form-floating mb-3">
            <input class="form-control" type="number" id="amount" name="Amount" min="0" required>
            <label for="amount">Amount:</label>
        </div>

        <div class="form-floating mb-3">
            <input class="form-control" type="datetime-local" id="created_at" name="CreatedAt" required>
            <label for="created_at">Created At:</label>
        </div>

        <div class="form-floating mb-3">
            <label for="user_id">User ID:</label>
            <input class="form-control" type="number" id="user_id" name="UsrId" min="1" required>
        </div>

        <div class="form-floating mb-3">
            <input type="submit" value="Add Expense">
        </div>
    </form>
</div>


    


</main>
</body>
</html>
