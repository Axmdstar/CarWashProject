
<!doctype html>
<head>
<html lang="en">
<?php include "../Components/HeadContent.php" ?> 


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<body>

  <?php include '../Components/NavBar.php' ?>

  <main id="main" class="main">

    <form method="POST" action="../Services/Services.php">
      <!-- Content Here  -->
      <?php
      $id = $_GET['id'];
      if (isset($_POST['addNewService'])) {
        $ServiceName = $_POST['ServiceName'];
        $category = $_POST['category'];
        $amount = $_POST['amount'];

        include_once "../Components/connection.php";
        $query = $conn->query("INSERT into services(CarName, Amount, ServiceCategoryId) VALUES('$ServiceName', $amount, $category) ");
        if ($query) {
          echo "<script>alert(data inserted successfully)</script>";

        } else {
          echo "<script>alert(there is an error)</script>";

        }
      }
      ?>

      <div class="card">
        <div class="card-body">
          <h1 class="card-title">New Service</h1>
          
          <div class="row">

            <div class="col">
              <div class="form-floating mb-3 ">
                <input type="text" name="ServiceName" class="form-control" id="floatingInput" placeholder="" autofocus required >
                <label for="floatingInput">Service Name</label>
              </div>
            </div>
            
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

          </div>

          <div class="row">
            
          <div class="col">
              <div class="form-floating mb-3">
                <input type="number" name="amount" class="form-control" id="floatingInput" required step="0.01" required placeholder="$">
                <label for="floatingInput">Amount</label>
              </div>
          </div>

            <button type="submit" class="JazzeraBtn col" value="Add" name="addNewService">Add</button>
          </div>
        </div>
      </div>
    </form>



    <div class="card">
      <div class="card-body">
        <h1 class="card-title">New Category</h1>

        <form  method="POST" class="d-flex flex-row gap-2" >
            

        <?php 
        include_once "../Components/connection.php";
        $id = $_GET['id'];
        $sql = "SELECT `id`, `CatName`, `CommisionRate` FROM `servicecategory` WHERE id = $id";
        $result = $conn->query($sql);
        $UpdateData = $result->fetch_assoc();
        ?>

        <?php
        if (isset($_POST['AddNewCategory'])) {
          $CommissionRate = $_POST["CommissionRate"];
          $CategoryName = $_POST["CategoryName"];
          $id = $_GET['id'];
          include_once "../Components/connection.php";
          $sql = "UPDATE servicecategory SET CatName ='$CategoryName', `CommisionRate`=$CommissionRate WHERE id = $id";
          $query = $conn->query($sql);

          if ($query){
            echo '<script type="text/javascript">
            window.location = "../Services/Services.php";
            </script>  ';
          }
        }?>

        <div class="form-floating mb-3 flex-grow-1">
            <input value="<?php echo$UpdateData["CatName"]; ?>" type="Quantity" name="CategoryName" class="form-control" id="floatingInput" placeholder=""  autofocus required >
            <label for="floatingInput">Category Name </label> 
          </div>

          <div class="form-floating mb-3 flex-grow-1">
            <input value="<?php echo$UpdateData["CommisionRate"]; ?>" type="text" name="CommissionRate" class="form-control" id="floatingInput" placeholder="" autofocus required>
            <label for="floatingInput">Commission Rate</label>
          </div>

          <button type="submit" name="AddNewCategory" class="JazzeraBtn flex-grow-1" >Edit</button>
        </form>

      </div>
    </div>




    <!-- Service Table  -->
    <div class="row gap-2">
      <div class="card col">
            <div class="card-body">
            <h1 class="card-title">All Services</h1>
      
              <table  class=" customTable" >
                    <thead>
                      <tr>
                        <th scope="col">Service Name</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Category</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    // $conn = new mysqli('localhost', 'root', 'root', 'carwash');
                    include_once "../Components/connection.php";
                    $sql = "SELECT `id`, `CarName`, `Amount`, `ServiceCategoryId` FROM `services`";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                      echo "
                        <tr>
                        <td>$row[CarName]</td>
                        <td>$row[Amount]</td>
                        <td>$row[ServiceCategoryId]</td>
                        ";
                        echo "
                        <td><a style='color: black;' href='../Services/DeleteService.php?id=$row[id]'><i class='bi bi-trash-fill'></i></a> </td>
                        <td><a style='color: black;' href='../Services/UpdateService.php?id=$row[id]'><i class='bi bi-pencil-fill'></i></a> </td>
                        </tr>
                        ";
                    }
                    ?>
                      
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- Table Ends  -->

              <!-- Table Two  -->
              <div class="card col">
            <div class="card-body">
            <h1 class="card-title">All Categories</h1>
      
              <table  class=" customTable" >
                    <thead>
                      <tr>
                        <th scope="col">Category Name</th>
                        <th scope="col">Comission Rate</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    include_once "../Components/connection.php";
                    $sql = "SELECT `id`, `CatName`, `CommisionRate` FROM `servicecategory`";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "
                        <tr>
                        <td>$row[CatName]</td>
                        <td>$row[CommisionRate]</td>
                        ";
                        echo "
                        <td><a style='color: black;' href='../Services/DeleteCategory.php?id=$row[id]'><i class='bi bi-trash-fill'></i></a> </td>
                        <td><a style='color: black;' href='../Services/UpdateServiceCategory.php?id=$row[id]'><i class='bi bi-pencil-fill'></i></a> </td>
                        </tr>
                        ";
                        
                    }
                    ?>
                      
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- Table Ends  -->
    </div>



  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</head>
</html>