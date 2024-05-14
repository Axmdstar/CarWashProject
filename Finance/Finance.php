<!doctype html>
<html lang="en">
<?php include "../Components/HeadContent.php" ?>

<body>

  <?php include '../Components/NavBar.php' ?>

  <main id="main" class="main">
    <!-- Summary -->
    <div class="card container-fluid">
      <div class="card-body">
        <h1 class="card-title">Summary</h1>

        <!-- <div style="display: flex; flex-direction: row; justify-content: space-between; gap: 20px;"> -->
        <div class=" d-flex flex-row flex-wrap gap-2 ">

          <div class="JazzeraCards col">
            <h2>$000</h2>
            <h3>Total Revenue</h3>
          </div>

          <div class="JazzeraCards col">
            <h2>$000</h2>
            <h3>Today Revenue</h3>
          </div>

          <div class="JazzeraCards col">
            <h2>$000</h2>
            <h3>This month Revenue</h3>
          </div>

          <div class="JazzeraCards col">
            <h2>$000</h2>
            <h3>Total Expense</h3>
          </div>

          <div class="JazzeraCards col">
            <h2>$000</h2>
            <h3>This month Expense</h3>
          </div>

        </div>
      </div>
    </div>
    <!-- summary end  -->


    <div class="d-flex flex-row flex-wrap gap-2">
      <!-- Pie Chart  -->
      <div class="card container-fluid col">
        <div class="card-body">
          <h1 class="card-title">Top Services</h1>
          <div id="pieChart"></div>

          <script>
            document.addEventListener("DOMContentLoaded", () => {
              new ApexCharts(document.querySelector("#pieChart"), {
                series: [44, 55, 13, 43, 22],
                chart: {
                  height: 250,
                  type: 'pie',
                  toolbar: {
                    show: true
                  }
                },
                labels: ['Service a', 'Service b', 'Service c', 'Service d', 'Service e']
              }).render();
            });
          </script>
        </div>
        <!-- End Pie Chart -->



      </div>
      <div class="card container-fluid col">
        <div class="card-body d-flex flex-column ">
          <h1 class="card-title ">Estimated Commisson</h1>

          <div class=" row">
            <h2 class="col">Services Total</h2>
            <h5 class="col w-25 text-end">000</h5>
          </div>

          <div class="row">
            <h2 class="col-10">Commission Total</h2>
            <h5 class="col w-25 text-end">000</h5>
          </div>

          <div class="row" style="margin-top: auto;">
            <h2 class="col">Total</h2>
            <h5 class="col text-end w-25">000</h5>
          </div>

          
        </div>
      </div>
    </div>


    <?php
// Database connection
include_once "../Components/connection.php";
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['Expense'])) {
    // Retrieve form data
    $expenseType = $_POST['ExpenseType'];
    $description = $_POST['Description'];
    $amount = $_POST['Amount'];
    $createdAt = $_POST['CreatedAt'];
    
    

    // Prepared statement to prevent SQL injection
    $sql = "INSERT INTO expenses(`ExpenseType`, `Description`, `Amount`, `CreatedDateTime`, `UsrId`)
     VALUES ('$expenseType', '$description', $amount , '$createdAt', (SELECT id FROM users WHERE Username = '$_COOKIE[Username]'))";
    
    $result = $conn->query($sql);

    if ($result) {
        echo "Saved Successfully";

    } else {
        echo "Error: " . $stmt->error;
    }
}

?>

    <div class="card container-fluid">
      <div class="card-body">
        <h1 class="card-title">Add Expense</h1>
    
    <form action="../Finance/Finance.php" method="post">
        <div class="row">

          <div class="col">
            <div class="form-floating mb-3">
                <input class="form-control" type="text" id="expense_type" name="ExpenseType" required>
                <label for="expense_type">Expense Type:</label>
            </div>
          </div>
  
          
          <div class="col">
            <div class="form-floating mb-3">
              <input class="form-control" type="number" id="amount" name="Amount" min="0" required>
              <label for="amount">Amount:</label>
            </div>
          </div>
          
          <div class="col">
            <div class="form-floating mb-3">
              <input class="form-control" type="datetime-local"  id="created_at" name="CreatedAt" required>
              <label for="created_at">Created At:</label>
            </div>
          </div>

        </div>
        
        <div class="form-floating mb-3">
            <textarea class="form-control" name="Description" placeholder="Leave a comment here" id="floatingTextarea" style="height: 100px;"></textarea>
            <label for="description">Description:</label>
        </div>
        <button type="submit" name="Expense" class="JazzeraBtn flex-grow-1" value="Add">Add</button>

    </form>


      </div>
    </div>

    <div class="card">
          <div class="card-body">
          <h1 class="card-title">All Employees</h1>
        
            <table  class=" customTable" >
                  <thead>
                    <tr>
                      <th scope="col">Expense Type</th>
                      <th scope="col">Description</th>
                      <th scope="col">Price</th>
                      <th scope="col">Date/Time</th>
                      <th scope="col">CreatedBy</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    include_once "../Components/connection.php";
                    $sql = "SELECT  `ExpenseType`, `Description`, `Amount`, `CreatedDateTime`, usr.Username as Createdby FROM `expenses` as exp 
                    INNER join users as usr on usr.id = exp.id;";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "
                        <tr>
                          <td>$row[ExpenseType]</td>
                          <td>$row[Description]</td>
                          <td>$row[Amount]</td>
                          <td>$row[CreatedDateTime]</td>
                          <td>$row[Createdby]</td>
                        </tr>
                        ";
                    }
                    
                    ?>


                  </tbody>
                </table>
                <!-- Table Ends  -->
      </div>
    </div>


  </main>
</body>

</html>