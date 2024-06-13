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
        $UnitSellRestock = $_POST['UnitSellRestock'];
        $PurchaseAmountRestock = $_POST['PurchaseAmountRestock'];

        // $sql = "UPDATE product SET Available = Available + $RestockQuantity WHERE id = $ProductRestock";

        $sql = "UPDATE `product` SET `PurchaseAmount`='$PurchaseAmountRestock',`Available`= Available + $RestockQuantity,
                `Amount`='$UnitSellRestock', `LastUpdated`= CURRENT_DATE() WHERE ProductName = '$ProductRestock'";
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
        

        try {
          $query = $conn->query($sql);
          if ($query) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            New Product added Successfully
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
          }  
        } catch (\Throwable $th) {
          //throw $th;
          echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            '.$ProductName .' already exists.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
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
                <input type="date" name="Date" max="<?= date('Y-m-d'); ?>" class="form-control" id="floatingInput" placeholder="" required>
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
                <label for="floatingInput">Unit Sell</label>
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
                <select class="form-select" name="ProductRestock" id="floatingSelectRestock" aria-label="Floating label select example" required>
                  <option selected disabled value="">Select Product</option>
                  <?php
                  include_once "../Components/connection.php";

                  $sql = "SELECT * FROM `product`";
                  $result = $conn->query($sql);
                  while ($row = $result->fetch_assoc()) {
                    echo "<option value='$row[ProductName]'>$row[ProductName]</option>";
                  } ?>
                </select>
                <label for="floatingSelect">Product</label>
              </div>
            </div>
            <div class="col">
              <div class="form-floating mb-3 ">
                <input type="number" name="RestockQuantity" class="form-control" id="RestockQuantity" placeholder="" required>
                <label for="floatingInput">Quantity</label>
              </div>
            </div>
          </div>

          <div class="row">

            <div class="col">
                <div class="form-floating mb-3 ">
                  <input type="number" name="PurchaseAmountRestock" class="form-control" id="PurchaseAmountRestock" placeholder="" required>
                  <label for="floatingInput">Purchase Amount</label>
                </div>
            </div>

            <div class="col">
                <div class="form-floating mb-3 ">
                  <input type="number" name="UnitSellRestock"  step="0.001" class="form-control" id="PriceR" placeholder="" required>
                  <label for="floatingInput">Unit Sell</label>
                </div>
            </div>

            <input type="submit" class="JazzeraBtn col" value="Update" name="Restock">
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
              <th scope="col">Last Updated</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include_once "../Components/connection.php";
            $sql = "SELECT `id`, `ProductName`, `PurchaseAmount`, `Available`, `Amount`, `AddDate`,
                    IFNULL(`LastUpdated`, '---') as `LastUpdated` FROM `product`  ORDER BY `AddDate` DESC";
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
                    <td>$row[LastUpdated]</td>
                    ";
            }
            ?>

          </tbody>
        </table>
      </div>
    </div>

  </main>

  <script>

    document.addEventListener("DOMContentLoaded", function() {
    // let price = 0;
    // Function to handle change in select dropdown
    document.getElementById("floatingSelectRestock").addEventListener("change", function() {
        var selectedProduct = this.value;

        // console.log(this.te);
        // Make a fetch request
        fetch("http://localhost/CarWashProject/Products/GetProductInfo.php?product=" + encodeURIComponent(selectedProduct))
            .then(function(response) {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then(function(data) {
                // Update available quantity on success
                document.getElementById("RestockQuantity").value = data.data.available_quantity;
                document.getElementById("PriceR").value = data.data.price;
                document.getElementById("PurchaseAmountRestock").value = data.data.PurchaseAmount;
                // price = data.data.price;
            })
            .catch(function(error) {
                // Handle errors
                console.error("Fetch error:", error);
            });
    })});


  </script>

</body>
</html>
