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
              <hr>
                <h2 class="col">Total</h2>
                <h5 class="col text-end w-25" id="TotalEstimated">000</h5>
              </div>

              <script>
                  let ServicesTotal = document.getElementById("ServicesTotal")
                  let CommissionTotal = document.getElementById("CommissionTotal")
                  document.getElementById("TotalEstimated").innerText = Number(ServicesTotal.innerText.slice(1)) - Number(CommissionTotal.innerText.slice(1))
              </script>
            </div>
          </div>
        </div>

    <div class="card">
      <div class="card-body">
      <?php
             include "../Components/connection.php";
             $sql = "CALL IncomeStatement
            ";
             $result = $conn->query($sql);
             $row = $result->fetch_assoc();
        ?>
        <h1 clatat="card-title">Daily Audit</h1>
        <div class=" row">
                <h5 class="col">Services Revenue</h5>
                <h5 class="col w-25 text-end" id="Services_Revenue">$<?php echo $row["TodayServices"]; ?></h5>
        </div>

        <div class="row">
                <h5 class="col-6">Products Revenue</h5>
                <h5 class="col w-25 text-end" id="Products_Revenue">$<?php echo $row["TodayProduct"]; ?></h5>
        </div>

        <div class="row">
                <h5 class="col-6">Commission</h5>
                <h5 class="col w-25 text-end" id="Commission">-$<?php echo $row["TodayCommission"]; ?></h5>
        </div>

        <div class="row">
                <h5 class="col-6">Expense</h5>
                <h5 class="col w-25 text-end" id="Expense">-$<?php echo $row["TodayExpense"]; ?></h5>
        </div>

        <div class="row">
            <hr>
                <h3 class="col-6">Total</h3>
                <p class="col w-25 text-end" id="IncomeTotal"></p>
        </div>
        <script>
            let TodayExpense = document.getElementById("Expense")
            let TodayCommission = document.getElementById("Commission")
            let TodayServices = document.getElementById("Services_Revenue")
            let TodayProduct = document.getElementById("Products_Revenue")
            // Calculate total income
            const totalIncome = (Number(TodayServices.innerText.slice(1)) + Number(TodayProduct.innerText.slice(1))) 
                                -
                                (Number(TodayExpense.innerText.slice(2)) + Number(TodayCommission.innerText.slice(2)));
            console.log(totalIncome);
            // Set the value of IncomeTotal element
            document.getElementById("IncomeTotal").innerText = totalIncome;

            // Add a class to IncomeTotal based on the sign of totalIncome
            if (totalIncome > 0) {
                document.getElementById("IncomeTotal").classList.add("positive-income");
            } else if (totalIncome < 0) {
                document.getElementById("IncomeTotal").classList.add("negative-income");
            } else {
                // If totalIncome is 0, you can add a class to indicate neutral
                document.getElementById("IncomeTotal").classList.add("neutral-income");
            }

        </script>

        </div>
    </div>


    <div class="card">
      <div class="card-body">
        <h1 class="card-title">Recent Services Done</h1>
        <table class=" customTable">
          <thead>
            <tr>
              <th scope="col">CarType</th>
              <th scope="col">Category</th>
              <th scope="col">Price</th>
              <th scope="col">Customer Number</th>
              <th scope="col">Createdby</th>
              <th scope="col">Date</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include "../Components/connection.php";
            $sql = "SELECT `Cartype`, `category`, `Amount`, `CreatedAT`, `CustomerNumber`, usr.Username as Createdby FROM `dailyservices` as ds 
            INNER JOIN users as usr on ds.UsrId = usr.id
            ORDER BY `ds`.`CreatedAT` DESC
            LIMIT 10
            ";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
              echo "
                      <tr>
                      <td>$row[Cartype]</td>
                      <td>$row[category]</td>
                      <td>$$row[Amount]</td>
                      <td>$row[CustomerNumber]</td>
                      <td>$row[Createdby]</td>
                      <td>$row[CreatedAT]</td>
                      </tr>
                      ";}?>

          </tbody>
        </table>
      </div>
    </div>


    <div class="card col">
        <div class="card-body">
            <h1 class="card-title">Recent Products Sold</h1>
      
          <table  class=" customTable" >
                    <thead>
                      <tr>
                        <th scope="col">Product Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                        <th scope="col">CustomerNumber</th>
                        <th scope="col">Date</th>
                        <th scope="col">CreatedBy</th>
                      </tr>
                    </thead>
                <tbody>
                    <?php
                    include_once "../Components/connection.php";
                    $sql = "SELECT `ProductName`, `Quantity`, `Amount`, `CustomerNumber`, `Solddate`, usr.Username as Createdby FROM `soldproducts` as sp
                            INNER JOIN users as usr on sp.UsrId = usr.id
                            ORDER BY sp.Solddate DESC
                            LIMIT 10
                             ";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                      echo "
                            <tr>
                            <td>$row[ProductName]</td>
                            <td>$row[Quantity]</td>
                            <td>$$row[Amount]</td>
                            <td>$row[CustomerNumber]</td>
                            <td>$row[Solddate]</td>
                            <td>$row[Createdby]</td>
                            ";
                    }
                    ?>
              </tbody>
          </table>
      </div>
    </div>