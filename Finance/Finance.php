<!doctype html>
<html lang="en">
<?php include "../Components/HeadContent.php" ?>

<body>

  <?php include '../Components/NavBar.php' ?>
  <main id="main" class="main">

    <!-- Tabss  -->
    <ul class="nav nav-tabs"  id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" style="background-color: #f6f9ff;" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Dashboard</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" style="background-color: #f6f9ff;" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Report</button>
      </li>

    </ul>
    <div class="tab-content pt-2" id="myTabContent">
      <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

        <!-- Summary -->
        <div class="card container-fluid">
          <div class="card-body">
            <h1 class="card-title">Summary</h1>

            <!-- <div style="display: flex; flex-direction: row; justify-content: space-between; gap: 20px;"> -->
            <div class=" d-flex flex-row flex-wrap gap-2 ">
              <?php
              include "../Components/connection.php";
              if ($conn->connect_error) {
                die('' . $conn->connect_error);
              }
              $sql = "CALL FinDashBoardData()";
              $result = $conn->query($sql);
              if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
              }

              ?>
              <div class="JazzeraCards col">
                <h2>$<?php echo $row["TotalRevenue"]; ?></h2>
                <h3>Total Revenue</h3>
              </div>

              <div class="JazzeraCards col">
                <h2>$<?php echo $row["MonthRevenue"]; ?></h2>
                <h3>This month Revenue</h3>
              </div>

              <div class="JazzeraCards col">
                <h2>$<?php echo $row["TodayRevenue"]; ?></h2>
                <h3>Today Revenue</h3>
              </div>


              <div class="JazzeraCards col">
                <h2>$<?php echo $row["TotalExpense"]; ?></h2>
                <h3>Total Expense</h3>
              </div>

              <div class="JazzeraCards col">
                <h2>$<?php echo $row["MonthExpense"]; ?></h2>
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
                <?php
                include "../Components/connection.php";
                $sql = "CALL ServiceChartData";
                $result = $conn->query($sql);

                $ServiceNames = array();
                $ServiceCounts = array();
                while ($row = $result->fetch_assoc()) {
                  $ServiceNames[] = $row['ServiceName'];
                  $ServiceCounts[] = $row['ServiceCount'];
                }

                ?>
                var SN = <?php echo json_encode($ServiceNames); ?>;
                var SC = <?php echo json_encode($ServiceCounts); ?>;
                let SCtotal = SC.reduce((i1, i2) => Number(i1) + Number(i2), 0);
                SC = SC.map((i) => Number(i) / SCtotal * 100)
                document.addEventListener("DOMContentLoaded", () => {
                  new ApexCharts(document.querySelector("#pieChart"), {
                    series: SC,
                    chart: {
                      height: 250,
                      type: 'pie',
                      toolbar: {
                        show: true
                      }
                    },
                    labels: SN
                  }).render();
                });
              </script>
            </div>
            <!-- End Pie Chart -->



          </div>
          <div class="card container-fluid col">
            <div class="card-body d-flex flex-column ">
          <?php
             include "../Components/connection.php";
             $sql = "SELECT IFNULL(SUM(ds.Amount), 0) as DailyAmount, IFNULL(Round(SUM(sc.CommisionRate),2), 0) as commission
                FROM DailyServices ds
                JOIN Services s ON ds.Cartype = s.CarName 
                JOIN ServiceCategory sc ON sc.CatName = ds.category
                WHERE Day(ds.CreatedAT) = Day(CURRENT_DATE());
            ";
             $result = $conn->query($sql);
             $row = $result->fetch_assoc();

           ?>
              <h1 class="card-title ">Estimated Commisson</h1>

              <div class=" row">
                <h4 class="col">Services Total</h4>
                <h5 class="col w-25 text-end" id="ServicesTotal">$<?php echo $row["DailyAmount"]; ?></h5>
              </div>

              <div class="row">
                <h4 class="col-6">Commission Total</h4>
                <h5 class="col w-25 text-end" id="CommissionTotal">$<?php echo $row["commission"]; ?></h5>
              </div>

              <div class="row" style="margin-top: auto;">
                <h2 class="col">Total</h2>
                <h5 class="col text-end w-25" id="TotalEstimated">000</h5>
              </div>

              <script>
                  let ServicesTotal = document.getElementById("ServicesTotal")
                  let CommissionTotal = document.getElementById("CommissionTotal")


                  console.log(CommissionTotal.innerText.slice(1));
                  console.log(ServicesTotal.innerText);
                  console.log(document.getElementById("TotalEstimated").innerText);
                  document.getElementById("TotalEstimated").innerText = Number(ServicesTotal.innerText.slice(1)) + Number(CommissionTotal.innerText.slice(1))
              </script>


            </div>
          </div>
        </div>




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
                    join users as usr on usr.id = exp.UsrId;";
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
                }

                ?>


              </tbody>
            </table>
            <!-- Table Ends  -->
          </div>
        </div>

      </div>
      <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        Nesciunt totam et. Consequuntur magnam aliquid eos nulla dolor iure eos quia. Accusantium distinctio omnis et atque fugiat. Itaque doloremque aliquid sint quasi quia distinctio similique. Voluptate nihil recusandae mollitia dolores. Ut laboriosam voluptatum dicta.
      </div>
    </div>


  </main>
</body>

</html>