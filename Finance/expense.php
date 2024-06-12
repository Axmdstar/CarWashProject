<div class="card container-fluid">
          <div class="card-body">
            <h1 class="card-title">Add Expense</h1>

            <form action="../Finance/Finance.php" method="post">
              <div class="row">
                <?php
                // Database connection
                include "../Components/connection.php";
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
                  $sql = "INSERT INTO expenses(`ExpenseType`, `Description`, `Amount`, `CreatedAt`, `UsrId`)
                          VALUES ('$expenseType', '$description', $amount , '$createdAt', (SELECT id FROM users WHERE Username = '$_COOKIE[Username]'))";

                  $result = $conn->query($sql);

                  if ($result) {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                          New record created successfully
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>';
                  } else {
                    echo "Error: " . $stmt->error;
                  }
                }
                ?>
                <div class="col">
                  <div class="form-floating mb-3">
                    <select class="form-select" name="ExpenseType" id="floatingSelect" aria-label="Floating label select example" required>
                      <option value="" selected>Select Expense Type</option>
                      <option value="Bill">Bill</option>
                      <option value="Salary">Salary</option>
                      <option value="Utility">Utility</option>
                      <option value="Other">Other</option>
                    </select>
                    <label for="expense_type">Expense Type</label>
                  </div>
                </div>


                <div class="col">
                  <div class="form-floating mb-3 ">
                    <input type="text" name="Amount" class="form-control" id="floatingInput" placeholder="" required>
                    <label for="floatingInput">Amount</label>
                  </div>
                </div>

                <div class="col">
                  <div class="form-floating mb-3">
                    <input class="form-control" type="datetime-local" id="created_at" name="CreatedAt" required>
                    <label for="created_at">Created At</label>
                  </div>
                </div>

              </div>

              <div class="form-floating mb-3">
                <textarea class="form-control" name="Description" placeholder="Leave a comment here" id="floatingTextarea" style="height: 100px;"></textarea>
                <label for="description">Description</label>
              </div>
              <button type="submit" name="Expense" class="JazzeraBtn flex-grow-1" value="Add">Add</button>

            </form>


          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <h1 class="card-title">All Expense</h1>

            <table class=" customTable">
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
                include "../Components/connection.php";
                $sql = "SELECT  `ExpenseType`, `Description`, `Amount`, `CreatedAt`, usr.Username as Createdby FROM `expenses` as exp 
                        join users as usr on usr.id = exp.UsrId  ORDER BY `CreatedAt` DESC";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                  echo "
                        <tr>
                          <td>$row[ExpenseType]</td>
                          <td>$row[Description]</td>
                          <td>$$row[Amount]</td>
                          <td>$row[CreatedAt]</td>
                          <td>$row[Createdby]</td>
                        </tr>
                        ";
                }?>

              </tbody>
            </table>
            <!-- Table Ends  -->
          </div>
        </div>