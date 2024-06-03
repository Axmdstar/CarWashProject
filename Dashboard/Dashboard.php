<!doctype html>
<html lang="en">
<?php include "../Components/HeadContent.php" ?>

<body>

  <?php include '../Components/NavBar.php' ?>

  <main id="main" class="main">

    <!-- SummaryCards -->
    <div class="card">
      <div class="card-body">
        <h1 class="card-title">Recent Activity</h1>

        <?php
        include "../Components/connection.php";
        if ($conn->connect_error) {
          die('' . $conn->connect_error);
        }
        $sql = 'Call GetDashboardSummary';
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
        }

        ?>
        <div style="display: flex; flex-direction: row; justify-content: space-between; gap: 20px;">

          <div class="JazzeraCards">
            <h2><?php echo "$row[NumofProductSoldAndRevenue]"; ?></h2>
            <h3>Product</h3>
          </div>

          <div class="JazzeraCards">
            <h2><?php echo "$row[NumofServices]"; ?></h2>
            <h3>Services</h3>
          </div>

          <div class="JazzeraCards">

            <h2>$<?php
                  $AddRevenue = $row['ProductRevenue'] + $row['ServiceRevenue'];
                  echo "$AddRevenue"; ?></h2>
            <h3>Revenue</h3>
          </div>

        </div>
      </div>
    </div><!-- End Default Card -->


    <!-- Chart  -->
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Revenue Chart</h5>

        <!-- Column Chart -->
        <div id="columnChart"></div>

        <script>
          document.addEventListener("DOMContentLoaded", () => {
            new ApexCharts(document.querySelector("#columnChart"), {
              series: [{
                name: 'Services',
                data: [<?php echo "$row[NumofServices]"; ?>]
              }, {
                name: 'Product',
                data: [<?php echo "$row[NumofProductSold]"; ?>]
              }],
              chart: {
                type: 'bar',
                height: 350
              },
              plotOptions: {
                bar: {
                  horizontal: false,
                  columnWidth: '55%',
                  endingShape: 'rounded'
                },
              },
              dataLabels: {
                enabled: false
              },
              stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
              },
              xaxis: {
                categories: ['Today'],
              },
              yaxis: {
                title: {
                  text: 'Number'
                }
              },
              fill: {
                opacity: 1
              },
              tooltip: {
                y: {
                  formatter: function(val) {
                    return "Completed " + val + " today"
                  }
                }
              }
            }).render();
          });
        </script>
        <!-- End Column Chart -->

      </div>
    </div>
    <!-- Chart end  -->


    <!-- User Table  -->
    <div class="card">
      <div class="card-body">
        <h1 class="card-title">Users</h1>

        <table class=" customTable">
          <thead>
            <tr>
              <th scope="col">Id</th>
              <th scope="col">Emp Name</th>
              <th scope="col">Username</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include "../Components/connection.php";
            $sql = "SELECT users.id, CONCAT(emp.FirstName,' ', emp.MiddleName,' ', emp.LastName) as name, users.Username FROM users
                    JOIN employee as emp on emp.id = users.id ";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
              echo "
                        <tr>
                        <td>$row[id]</td>
                        <td>$row[name]</td>
                        <td>$row[Username]</td>
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