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

  </main>


</body>

</html>