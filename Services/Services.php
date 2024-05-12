<!doctype html>
<html lang="en">
<?php include "../Components/HeadContent.php" ?>
<link rel="stylesheet" href="service.css">

<body>

  <?php include '../Components/NavBar.php' ?>

  <!-- <div class="form-floating mb-3">
  <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
  <label for="floatingInput">*** Text Here ***</label>
  </div> -->

  <main id="main" class="main">


    <form method="">
      <!-- Content Here  -->

      <div class="card">
        <div class="card-body">
          <h1 class="card-title">New Service</h1>
          
          <div class="row">

            <div class="col">
              <div class="form-floating mb-3 ">
                <input type="text" name="ServiceName" class="form-control" id="floatingInput" placeholder="" >
                <label for="floatingInput">Service Name</label>
              </div>
            </div>
            
            <div class="col">
              <div class="form-floating mb-3 ">
                <input type="text" name="category" class="form-control" id="floatingInput" placeholder="">
                <label for="floatingInput">Category</label>
              </div>
            </div>

          </div>

          <div class="row">
            
          <div class="col">
              <div class="form-floating mb-3">
                <input type="text" name="price" class="form-control" id="floatingInput" placeholder="">
                <label for="floatingInput">Price</label>
              </div>
          </div>

            <input type="submit" class="JazzeraBtn col" value="Add">
          </div>
        </div>
      </div>
    </form>


    <div class="card">
      <div class="card-body">
        <h1 class="card-title">New Category</h1>

        <form action="" method="post" class="d-flex flex-row gap-2">
        <div class="form-floating mb-3 flex-grow-1">
            <input type="text" name="CategoryName" class="form-control" id="floatingInput" placeholder="">
            <label for="floatingInput">Category Name</label>
          </div>

          <div class="form-floating mb-3 flex-grow-1">
            <input type="text" name="CommissionRate" class="form-control" id="floatingInput" placeholder="">
            <label for="floatingInput">Commission Rate</label>
          </div>

          <input type="submit" class="JazzeraBtn flex-grow-1" value="Add">
        </form>

      </div>
    </div>

    <div class="row gap-2">
      
      <div class="card col">
            <div class="card-body">
            <h1 class="card-title">All Services</h1>
      
              <table  class=" customTable" >
                    <thead>
                      <tr>
                        <th scope="col">Service Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Category</th>
                      </tr>
                    </thead>
                    <tbody>
      
                      <tr>
                        <td>Raheem </td>
                        <td>20</td>
                        <td>Something</td>
                        <td>buttons</td>
                      </tr>
                      <tr>
                        <td>Raheem </td>
                        <td>20</td>
                        <td>Something</td>
                      </tr>
                      <tr>
                        <td>Raheem </td>
                        <td>20</td>
                        <td>Something</td>
                      </tr>
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
      
                      <tr>
                        <td>Raheem </td>
                        <td>20</td>
                        <td>buttons</td>

                      </tr>
                      <tr>
                        <td>Raheem </td>
                        <td>20</td>

                      </tr>
                      <tr>
                        <td>Raheem </td>
                        <td>20</td>

                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- Table Ends  -->
    </div>



  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>