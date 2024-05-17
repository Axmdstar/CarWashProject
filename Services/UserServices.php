<!doctype html>
<html lang="en">
<?php include "../Components/HeadContent.php" ?>
<link rel="stylesheet" href="service.css">

<body>

  <?php include '../Components/NavBar.php' ?>




  <main id="main" class="main">

  <div class="card">
      <div class="card-body">
        <h1 class="card-title">Record a Service</h1>
    <form method="Post">

    <?php
    include_once "../Components/connection.php";
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    // Check if form is submitted
    if (isset($_POST['submit'])) {
      $cartype = $_POST['cartype'];
      $category = $_POST['category'];
      $amount = $_POST['amount'];
      $customernumber = $_POST['customernumber'];
      // Validate input data
      if (!empty($cartype) && !empty($category) && !empty($amount) && !empty($customernumber)) {
        $sql = "INSERT INTO dailyServices (`Cartype`, `category`, `Amount`, `CreateddateTime`, `CustomerNumber`, `UsrId`) 
                VALUES ('$cartype', '$category', $amount, Now(), '$customernumber', (SELECT id FROM users WHERE Username = '$_COOKIE[Username]') )";

        if ($conn->query($sql) === TRUE) {
          echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          New record created successfully
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';

        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
      } else {
        echo "Error: All fields are required.";
      }
    }
    ?>

      <div class="row">
        <div class="col">
          <div class="form-floating mb-3">
                  <select class="form-select" name="category" id="floatingSelect" aria-label="Floating label select example">
                      <option selected>Select Category</option>
                      <?php
                      include_once "../Components/connection.php";
                      $sql = "SELECT `id`, `CatName`, `CommisionRate` FROM `servicecategory`";
                      $result = $conn->query($sql);
                      while ($row = $result->fetch_assoc()) {
                        echo "
                            <option value='$row[id]'>$row[CatName]</option>
                              ";
                      }
                      ?>
                  </select>
                  <label for="floatingSelect">Category</label>
          </div>
        </div>

        <div class="col">
        <div class="form-floating mb-3">
                  <select class="form-select" name="cartype" id="floatingSelect" required aria-label="Floating label select example">
                      <option selected>Select Cartype</option>
                      <option value="Sedan">Sedan</option>
                      <option value="SUV">SUV</option>
                      <option value="Truck">Truck</option>
                    </select>
                  <label for="floatingSelect">CarType</label>
              </div> 
        </div>

        <div class="col">
        <div class="form-floating mb-3">
          <input required type="text" name="amount" class="form-control" id="floatingInput" placeholder="name@example.com">
          <label for="floatingInput">Price</label>
        </div>

        </div>
      </div>

      <div class="row">
      <div class="col">
        <div class="form-floating mb-3">
            <input required type="text" name="customernumber" class="form-control" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Customer Number</label>
          </div>
      </div>

      
        <input type="submit" name="submit" class="JazzeraBtn col" value="ADD">
      

      </div>

    </form>
  </div>
  </div>

  <div class="card">
      <div class="card-body">
        <h1 class="card-title">Recent Service</h1>
      <table  class=" customTable" >
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
                  include_once "../Components/connection.php";
                  $sql = "SELECT `Cartype`, `category`, `Amount`, `CreateddateTime`, `CustomerNumber`, usr.Username as Createdby FROM
                    `dailyservices` as ds INNER JOIN users as usr on ds.UsrId = usr.id";
                  $result = $conn->query($sql);
                  while ($row = $result->fetch_assoc()) {
                    echo "
                      <tr>
                      <td>$row[Cartype]</td>
                      <td>$row[category]</td>
                      <td>$$row[Amount]</td>
                      <td>$row[CustomerNumber]</td>
                      <td>$row[Createdby]</td>
                      <td>$row[CreateddateTime]</td>
                      </tr>
                      ";
                  }
                  ?>
                    
                  </tbody>
      </table>

  </div>
  </div>



</main>
</body>
</html>
