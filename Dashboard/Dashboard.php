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

        <div style="display: flex; flex-direction: row; justify-content: space-between; gap: 20px;">

          <div class="JazzeraCards">
            <h2>000</h2>
            <h3>Product</h3>
          </div>

          <div class="JazzeraCards">
            <h2>000</h2>
            <h3>Services</h3>
          </div>

          <div class="JazzeraCards">
            <h2>$000</h2>
            <h3>Revenue</h3>
          </div>
          
        </div>
      </div>
    </div><!-- End Default Card -->


    <!-- Chart  -->
    <div class="card">
            <div class="card-body">
              <h5 class="card-title">Column Chart</h5>

              <!-- Column Chart -->
              <div id="columnChart"></div>

              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  new ApexCharts(document.querySelector("#columnChart"), {
                    series: [{
                      name: 'Net Profit',
                      data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
                    }, {
                      name: 'Revenue',
                      data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
                    }, {
                      name: 'Free Cash Flow',
                      data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
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
                      categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
                    },
                    yaxis: {
                      title: {
                        text: '$ (thousands)'
                      }
                    },
                    fill: {
                      opacity: 1
                    },
                    tooltip: {
                      y: {
                        formatter: function(val) {
                          return "$ " + val + " thousands"
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


          <!-- Table  -->
          <table class="table table-borderless">
                <thead>
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Emp Name</th>
                    <th scope="col">Username</th>
                  </tr>
                </thead>
                <tbody>
                  
                  <tr>
                    <td>Raheem Lehner</td>
                    <td>Dynamic Division Officer</td>
                    <td>47</td>
                  </tr>
                </tbody>
              </table>
              <!-- Table Ends  -->

  </main>
</body>

</html>