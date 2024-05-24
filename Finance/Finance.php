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
        <button class="nav-link" id="profile-tab" style="background-color: #f6f9ff;" data-bs-toggle="tab" data-bs-target="#Services" type="button" role="tab" aria-controls="Services" aria-selected="false">Services Report</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" style="background-color: #f6f9ff;" data-bs-toggle="tab" data-bs-target="#Products" type="button" role="tab" aria-controls="Products" aria-selected="false">Products Report</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" style="background-color: #f6f9ff;" data-bs-toggle="tab" data-bs-target="#Expenses" type="button" role="tab" aria-controls="Expenses" aria-selected="false">Expenses</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" style="background-color: #f6f9ff;" data-bs-toggle="tab" data-bs-target="#Audits" type="button" role="tab" aria-controls="Audits" aria-selected="false">Audits</button>
      </li>
    </ul>

    <!-- Dashboard  -->
    <div class="tab-content pt-2" id="myTabContent">
      <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <?php  include_once "./FinanceDashboard.php"; ?>
      </div>
      <!-- Service and Product  -->
      <div class="tab-pane fade" id="Services" role="tabpanel" aria-labelledby="S&P-tab">
        <?php include_once "./ServiceReports.php";?>
      </div>
      <div class="tab-pane fade" id="Products" role="tabpanel" aria-labelledby="S&P-tab">
        <?php include_once "./ProductReport.php";?>
      </div>
      <!-- Expense  -->
      <div class="tab-pane fade" id="Expenses" role="tabpanel" aria-labelledby="Expenses-tab">
        <?php include_once "./expense.php";?>
      </div>
      <!-- Audits  -->
      <div class="tab-pane fade" id="Audits" role="tabpanel" aria-labelledby="Audits-tab">
        <?php include_once "./Audits.php";?>
      </div>
    </div>

  </main>
</body>

</html>