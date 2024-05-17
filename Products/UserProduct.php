<!doctype html>
<html lang="en">
<?php include "../Components/HeadContent.php" ?>
<link rel="stylesheet" href="service.css">

<body>

  <?php include '../Components/NavBar.php' ?>

  <main id="main" class="main">


    <form method="POST">
      <?php
        if (isset($_POST['add'])) {
          
        }

       ?>
      <div class="card">
        <div class="card-body">
          <h1 class="card-title">Sell Product</h1>

          <div class="row">
            <div class="col">

              <div class="row">

                <div class="col">
                  <div class="form-floating mb-3">
                      <select  class="form-select" name="Product" id="floatingSelect" aria-label="Floating label select example">
                          <option selected>Select Product</option>
                          <?php
                          $available = 0;
                          include_once "../Components/connection.php";
                          $sql = "SELECT `ProductName` FROM `product`";
                          $result = $conn->query($sql);
                          while ($row = $result->fetch_assoc()) {
                            echo "<option value='$row[ProductName]'>$row[ProductName]</option>";
                          } ?>
                      </select>
                      <label for="floatingSelect">Product</label>
                    </div>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                </div>

                  <div class="col">
                    <div class="form-floating mb-3 ">
                      <input type="number" name="Quantity" class="form-control" id="quantity" placeholder="" required>
                      <label for="floatingInput">Quantity</label>
                    </div>
                  </div>
                  
              </div>


              <div class="row">
                <div class="col">
                  
                  <div class="form-floating mb-3">
                    <input type="text" name="CustomerNumber" class="form-control" id="floatingInput" placeholder="" required>
                    <label for="floatingInput">Customer Number</label>
                  </div>
                </div>
              </div>
              <div class="row"><input type="submit" class="JazzeraBtn col" value="Add" name="add"></div>

              
          </div>
          
            <div class="col">
                  <div class="row align-items-baseline">
                    <h3 class="col label">Available</h3>
                    <div class="col" id="available"><?php echo $available; ?></div>
                  </div>
                  
                  <div class="row align-items-baseline">
                    <h3 class="col label">Price</h3>
                    <div class="col" id="Price" >0</div>
                  </div>
                  <hr>
                  <div class="row align-items-baseline">
                    <h2 class="col label">Total:</h2>
                    <div class="col" id="Total" >0</div>
                  </div>
            </div>
          </div>
        </div>
      </div>
    </form>

    <div class="card col">
        <div class="card-body">
            <h1 class="card-title">All Products</h1>
      
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
                            INNER JOIN users as usr on sp.UsrId = usr.id ";
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
  </main>
</body>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let price = 0;
    // Function to handle change in select dropdown
    document.getElementById("floatingSelect").addEventListener("change", function() {
        var selectedProduct = this.value;
        
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
                document.getElementById("available").textContent = data.data.available_quantity;
                document.getElementById("Price").textContent = data.data.price;
                price = data.data.price;
            })
            .catch(function(error) {
                // Handle errors
                console.error("Fetch error:", error);
            });
    });


  document.getElementById("quantity").addEventListener("change", function() {
    var quantity = this.value;
    // var price = document.getElementById("Price").textContent;
    console.log(quantity);
    document.getElementById("Total").textContent = price * quantity;
  })
});
</script>

</html>