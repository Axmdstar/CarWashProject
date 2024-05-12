<!doctype html>
<html lang="en">
  <?php include "../Components/HeadContent.php" ?>
  
  <body>
    
  <?php include '../Components/NavBar.php' ?>

  
  <main id="main" class="main">
       <form method="">
        <div class="card">
            <div class="card-body">
            <h1 class="card-title">New Product</h1>
            <div class="row">

                <div class="col">
                    <div class="form-floating mb-3 ">
                        <input type="text" name="ProductName" class="form-control" id="floatingInput" placeholder="" >
                        <label for="floatingInput">Product Name</label>
                    </div>
                </div>
            
                <div class="col">
                    <div class="form-floating mb-3 ">
                        <input type="text" name="NumberOfItems" class="form-control" id="floatingInput" placeholder="">
                        <label for="floatingInput">Number Of Items</label>
                    </div>
                </div>

          </div>

          <div class="row">
            
            <div class="col">
              <div class="form-floating mb-3">
                <input type="date" name="Date" class="form-control" id="floatingInput" placeholder="">
                <label for="floatingInput">Date</label>
              </div>
            </div>
            <div class="col">
              <div class="form-floating mb-3">
                <input type="number" name="purchaseAmount" class="form-control" id="floatingInput" placeholder="">
                <label for="floatingInput">Purchase Amount</label>
              </div>
            </div>

          </div>
          <div class="row">
          <div class="col">
              <div class="form-floating mb-3">
                <input type="number" name="sellPrice" class="form-control" id="floatingInput" placeholder="">
                <label for="floatingInput">Sell Price</label>
              </div>
            </div>
            <input type="submit" class="JazzeraBtn col" value="Add">
          </div>
          
        </div>
      </div>
            </div>
        </div>
       </form>

       <div class="row gap-2">
      
      <div class="card col">
            <div class="card-body">
            <h1 class="card-title">All Products</h1>
      
              <table  class=" customTable" >
                    <thead>
                      <tr>
                        <th scope="col">Product Name</th>
                        <th scope="col">Purchase Amount</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Sell Price</th>
                      </tr>
                    </thead>
                    <tbody>
      
                      <tr>
                        <td>Raheem </td>
                        <td>20</td>
                        <td>Something</td>
                        <td>20</td>
                        <td>buttons</td>
                      </tr>
                      <tr>
                        <td>Raheem </td>
                        <td>20</td>
                        <td>Something</td>
                        <td>20</td>
                      </tr>
                      <tr>
                        <td>Raheem </td>
                        <td>20</td>
                        <td>Something</td>
                        <td>20</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

  </main>
      
    
  </body>