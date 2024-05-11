<!doctype html>
<head>
<html lang="en">
<?php include "../Components/HeadContent.php" ?> 
<link rel="stylesheet" href="service.css">
<?php include "../Components/connect.php"?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<body>

  <?php include '../Components/NavBar.php' ?>

`

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

            <input type="button" class="JazzeraBtn col" value="Add">
           
            
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
                        <td><i class="fa-solid fa-plus"></i></td>
                        <td><i class="fa-solid fa-trash-can"></i></td>
                        <td><i class="fa-solid fa-pen"></i></td>
                        
                      </tr>
                      <tr>
                        <td>Raheem </td>
                        <td>20</td>
                        <td>Something</td>
                        <td><i class="fa-solid fa-plus"></i></td>
                        <td><i class="fa-solid fa-trash-can"></i></td>
                        <td><i class="fa-solid fa-pen"></i></td>
                      </tr>
                      <tr>
                        <td>Raheem </td>
                        <td>20</td>
                        <td>Something</td>
                        <td><i class="fa-solid fa-plus"></i></td>
                        <td><i class="fa-solid fa-trash-can"></i></td>
                        <td><i class="fa-solid fa-pen"></i></td>
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
                        <td><i class="fa-solid fa-plus"></i></td>
                        <td><i class="fa-solid fa-trash-can"></i></td>
                        <td><i class="fa-solid fa-pen"></i></td>

                      </tr>
                      <tr>
                        <td>Raheem </td>
                        <td>20</td>
                        <td><i class="fa-solid fa-plus"></i></td>
                        <td><i class="fa-solid fa-trash-can"></i></td>
                        <td><i class="fa-solid fa-pen"></i></td>

                      </tr>
                      <tr>
                        <td>Raheem </td>
                        <td>20</td>
                        <td><i class="fa-solid fa-plus"></i></td>
                        <td><i class="fa-solid fa-trash-can"></i></td>
                        <td><i class="fa-solid fa-pen"></i></td>

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

</head>
</html>