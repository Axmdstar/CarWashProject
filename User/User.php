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

      <div class="card">
        <div class="card-body">
          <h1 class="card-title">Create New User</h1>
          
          <div class="row">

            <div class="col">
              <div class="form-floating mb-3 ">
              <select class="form-select" name="category" id="floatingSelect" aria-label="Floating label select example">
                      <option selected>EmployeeId</option>
                      </select>
                
              </div>
            </div>
            
            <div class="col">
            <div class="form-floating mb-3">
            <input type="text" name="ServiceName" class="form-control" id="floatingInput" placeholder="" autofocus required >
                <label for="floatingInput">Username</label>
              </div>
            </div>

          </div>
          <button type="submit" class="JazzeraBtn col" value="Add" name="addNewService">Add</button>
          </div>
        </div>
      </div>
    </form>

    <div class="row gap-2">
      <div class="card col">
            <div class="card-body">
            <h1 class="card-title">All Users</h1>
      
              <table  class=" customTable" >
                    <thead>
                      <tr>
                        <th scope="col">EmployeeId</th>
                        <th scope="col">Username</th>

                        <tr>
                    <th scope="row">example</th>
                    <td>Brandon Jacob</td>
                    <td><i class="fa-solid fa-pen"></i></td>
                    <td><i class="fa-solid fa-trash-can"></i></td>
                  </tr>
                  <tr>
                    <th scope="row">example</th>
                    <td>Bridie Kessler</td>
                    <td><i class="fa-solid fa-pen"></i></td>
                    <td><i class="fa-solid fa-trash-can"></i></td>

                  </tr>
                        
                      </tr>
                    </thead>
                    <tbody>
                  </table>
                </div>
              </div>
    </div>
  </main>
</body>
</html>
</head>            