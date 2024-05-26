<!doctype html>
<html lang="en">
<?php include "../Components/HeadContent.php" ?>

<body>

  <?php include '../Components/NavBar.php' ?>

  <main id="main" class="main">

    <!-- New Product Form  -->
    <form method="POST" action="../Products/Products.php">
      <?php
      include "../Components/connection.php";

      if (isset($_POST['Restock'])) {
        $ProductRestock = $_POST['ProductRestock'];
        $RestockQuantity = $_POST['RestockQuantity'];

        $sql = "UPDATE product SET `Available`= $RestockQuantity WHERE id = $ProductRestock";
        $result = $conn->query($sql);
        if (!$result) {
          echo $conn->error;
        }
        
      }


      if (isset($_POST['add'])) {
        $ProductName = $_POST['ProductName'];
        $NumberOfItems = $_POST['NumberOfItems'];
        $Date = $_POST['Date'];
        $purchaseAmount = $_POST['purchaseAmount'];
        $sellPrice = $_POST['sellPrice'];

        $sql = "INSERT INTO `product`( `ProductName`, `PurchaseAmount`, `Available`, `Amount`, AddDate) 
                  VALUES ('$ProductName', $purchaseAmount, $NumberOfItems , $sellPrice, '$Date')";
        $result = $conn->query($sql);
        if (!$result) {
          echo $conn->error;
        }
      }
      ?>
      <div class="card">
        <div class="card-body">
          <h1 class="card-title">New Product</h1>
          <div class="row">

            <div class="col">
              <div class="form-floating mb-3 ">
                <input type="text" name="ProductName" class="form-control" id="floatingInput" placeholder="" required>
                <label for="floatingInput">Product Name</label>
              </div>
            </div>

          <div class="col">
              <div class="form-floating mb-3 ">
                <input type="number" name="NumberOfItems" class="form-control" id="floatingInput" placeholder="" required>
                <label for="floatingInput">Number Of Items</label>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col">
              <div class="form-floating mb-3">
                <input type="date" name="Date" class="form-control" id="floatingInput" placeholder="" required>
                <label for="floatingInput">Date</label>
              </div>
          </div>

          <div class="col">
            <div class="form-floating mb-3">
              <input type="number" step="0.001" name="purchaseAmount" class="form-control" id="floatingInput" placeholder="" required>
              <label for="floatingInput">Purchase Price</label>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col">
            <div class="form-floating mb-3">
              <input type="number" step="0.001" name="sellPrice" class="form-control" id="floatingInput" placeholder="" required>
              <label for="floatingInput">Sell Price</label>
            </div>
        </div>
            <input type="submit" class="JazzeraBtn col" value="Submit" name="add">
          </div>

        </div>
      </div>
      </div>
      </div>
    </form>

    <!-- Restock  -->
    <div class="card col">
      <div class="card-body">
        <h1 class="card-title">Restock Product</h1>
        <form method="POST" action="">
          
          <div class="row">
            <div class="col">
              <div class="form-floating mb-3">
                <select class="form-select" name="ProductRestock" id="floatingSelect" aria-label="Floating label select example">
                  <option selected>Select Product</option>
                  <?php
                  include_once "../Components/connection.php";
          
                  $sql = "SELECT * FROM `product`";
                  $result = $conn->query($sql);
                  while ($row = $result->fetch_assoc()) {
                    echo "<option value='$row[id]'>$row[ProductName]</option>";
                  } ?>
                </select>
                <label for="floatingSelect">Product</label>
              </div>
            </div>
            <div class="col">
                <div class="form-floating mb-3 ">
                  <input type="number" name="RestockQuantity" class="form-control" id="floatingInput" placeholder="" required>
                  <label for="floatingInput">Quantity</label>
                </div>
              </div>
              <input type="submit" class="JazzeraBtn col" value="Add" name="Restock">
          </div>
        </form>

      </div>
    </div>



    <!-- Table  -->
    <div class="card col">
      <div class="card-body">
        <h1 class="card-title">All Products</h1>

        <table class=" customTable">
          <thead>
            <tr>
              <th scope="col">Product Name</th>
              <th scope="col">Purchase Price</th>
              <th scope="col">Quantity</th>
              <th scope="col">Sell Price</th>
              <th scope="col">Date</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include_once "../Components/connection.php";
            $sql = "SELECT `id`, `ProductName`, `PurchaseAmount`, `Available`, `Amount`, `AddDate` FROM `product` ";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
              echo "
                            <tr>
                            <td>$row[ProductName]</td>
                            <td>$row[PurchaseAmount]</td>
                            ";
              if ($row["Available"] > 0) {
                echo "<td>$row[Available]</td>";
              } else {
                echo "<td class='text-bg-warning'>$row[Available]</td>";
              }
              echo "
                            <td>$row[Amount]</td>
                            <td>$row[AddDate]</td>
                            ";
            }
            ?>

          </tbody>
        </table>
      </div>
    </div>

  </main>


</body>