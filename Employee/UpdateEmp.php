<!doctype html>
<html lang="en">
<?php include "../Components/HeadContent.php" ?>
<link rel="stylesheet" href="service.css">

<body>

    <?php include '../Components/NavBar.php' ?>

    <main id="main" class="main" >

        <form method="POST"  >
           <!-- Content Here  -->
           <div class="card">
                <div class="card-body">
                    <h1 class="card-title">New Employee</h1> 

                    <?php 

                        include_once "../Components/connection.php";
                        $id = $_GET['id'];
                        $sql = "SELECT * FROM `employee` WHERE id = $id";
                        $result = $conn->query($sql);
                        $UpdateData = $result->fetch_assoc();



                        if (isset($_POST['submit'])){
                        $firstname = $_POST['FirstName'];
                        $middlename = $_POST['MiddleName'];
                        $lastname = $_POST['LastName'];
                        $district = $_POST['District'];
                        $sex = $_POST['Sex'];
                        $usertype = $_POST['UserType'];
                        $tel = $_POST['Tel'];
                        $magacamasuulka = $_POST['MagacaMasuulka'];
                        $telmasuulka = $_POST['TelMasuulka'];


                        $sql = "UPDATE `employee` SET `FirstName`='$firstname',`MiddleName`='$middlename',`LastName`='$lastname',`sex`='$sex',
                                `Number`=$tel,`District`='$district',`magcaMasuulka`='$magacamasuulka',
                                `NumberkaMassulka`=$tel,`EmployeeType`='$usertype' WHERE id = $id";
                        $result = $conn->query($sql);
                        if ($result) {
                            echo '<script type="text/javascript">
                                    window.location = "../Employee/Employee.php";
                                    </script>  ';
                        }}
                    ?>
            
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3 ">
                                <input value="<?php echo$UpdateData["FirstName"];?>" type="text" name="FirstName" class="form-control" id="floatingInput" placeholder="" required>
                                <label for="floatingInput">FirstName</label>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-floating mb-3 ">
                                <input value="<?php echo$UpdateData["MiddleName"];?>" type="text" name="MiddleName" class="form-control" id="floatingInput" placeholder="" required>
                                <label for="floatingInput">MiddleName</label>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-floating mb-3 ">
                                <input value="<?php echo$UpdateData["LastName"];?>" type="text" name="LastName" class="form-control" id="floatingInput" placeholder="" required>
                                <label for="floatingInput">LastName</label>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                    <!-- Wadajir, Dharkenley, Daynile, Wardigley, H/Wadaag, Waberi, H/Jijab, H/Weyne, Bondere, Karaan,
                     Yaqshid, Huriwaa, Kahda, Hodan, Shibis, Abdiaziz, Shangani. -->
                        <div class="col">
                            <div class="form-floating mb-3">
                                <select class="form-select" name="District" id="floatingSelect" aria-label="Floating label select example" required>
                                    <option selected>Select District</option>
                                    <option value="Wadajir" <?php if($UpdateData["District"] ==  "Wadajir"){
                                        echo "Selected";
                                    }  ?> >Wadajir</option>
                                    <option <?php if($UpdateData["District"] ==  "Dharkenley"){
                                        echo "Selected";
                                    }  ?> value="Dharkenley">Dharkenley</option>
                                    <option <?php if($UpdateData["District"] ==  "Daynile"){
                                        echo "Selected";
                                    }  ?> value="Daynile">Daynile</option>
                                    <option <?php if($UpdateData["District"] ==  "Kahda"){
                                        echo "Selected";
                                    }  ?> value="Kahda">Kahda</option>
                                    <option <?php if($UpdateData["District"] ==  "Karaan"){
                                        echo "Selected";
                                    }  ?> value="Karaan">Karaan</option>
                                    <option <?php if($UpdateData["District"] ==  "Hodan"){
                                        echo "Selected";
                                    }  ?> value="Hodan">Hodan</option>
                                </select>
                                <label for="floatingSelect">District</label>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-floating mb-3">
                                <select class="form-select" name="Sex" id="floatingSelect" aria-label="Floating label select example" required>
                                    <option selected>Select Sex</option>
                                    <option <?php if($UpdateData["sex"] ==  "Male"){
                                        echo "Selected";
                                    }  ?> value="Male">Male</option>
                                    <option <?php if($UpdateData["sex"] ==  "Female"){
                                        echo "Selected";
                                    }  ?> value="Female">Female</option>
                                </select>
                                <label for="floatingSelect">Sex</label>
                            </div>
                        </div>

                        
                        <div class="col">
                            <div class="form-floating mb-3">
                                <select class="form-select" name="UserType" id="floatingSelect" aria-label="Floating label select example" required>
                                    <option selected>Select User Type</option>
                                    <option <?php if($UpdateData["EmployeeType"] ==  "Admin"){
                                        echo "Selected";
                                    }  ?> value="Admin">Admin</option>
                                    <option <?php if($UpdateData["EmployeeType"] ==  "User"){
                                        echo "Selected";
                                    }  ?> value="User">User</option>
                                    <option <?php if($UpdateData["EmployeeType"] ==  "Worker"){
                                        echo "Selected";
                                    }  ?> value="Worker">Worker</option>
                                </select>
                                <label for="floatingSelect">User Type</label>
                            </div>
                        </div>

                    </div>



                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3 ">
                                <input value="<?php echo$UpdateData["Number"];?>" type="text" name="Tel" class="form-control" id="floatingInput" placeholder="" required>
                                <label for="floatingInput">Tel</label>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-floating mb-3 ">
                                <input value="<?php echo$UpdateData["magcaMasuulka"];?>" type="text" name="MagacaMasuulka" class="form-control" id="floatingInput" placeholder="" required>
                                <label for="floatingInput">Magaca Masuulka</label>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-floating mb-3 ">
                                <input value="<?php echo$UpdateData["NumberkaMassulka"];?>" type="text" name="TelMasuulka" class="form-control" id="floatingInput" placeholder="" required>
                                <label for="floatingInput">Tel Masuulka</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <input type="submit" name="submit" class="JazzeraBtn col" value="Submit">
                    </div>

                </div>
            </div>
        </form>


        
        <div class="card">
          <div class="card-body">
          <h1 class="card-title">All Employees</h1>
        
            <table  class=" customTable" >
                  <thead>
                    <tr>
                      <th scope="col">FullName</th>
                      <th scope="col">Tel</th>
                      <th scope="col">Sex</th>
                      <th scope="col">District</th>
                      <th scope="col">Masuulka</th>
                      <th scope="col">Tel Masuulka</th>
                      <th scope="col">User Type</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    include_once "../Components/connection.php";
                    $sql = "SELECT id, CONCAT(emp.FirstName,' ', emp.MiddleName,' ', emp.LastName) as FullName, `Number`,
                     sex, `District`, `magcaMasuulka`, `NumberkaMassulka`, `EmployeeType` FROM employee as emp";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "
                        <tr>
                        <td>$row[FullName]</td>
                        <td>$row[Number]</td>
                        <td>$row[sex]</td>
                        <td>$row[District]</td>
                        <td>$row[magcaMasuulka]</td>
                        <td>$row[NumberkaMassulka]</td>
                        <td>$row[EmployeeType]</td>
                        <td class='d-flex gap-4'><a style='color: black;' href='../Employee/UpdateEmp.php?id=$row[id]'><i class='bi bi-pencil-fill'></i></a>
                        <a style='color: black;' href='../Employee/DeleteEmp.php?id=$row[id]'><i class='bi bi-trash-fill'></i></a> </td>
                        </tr>
                        ";
                    }
                    
                    ?>


                  </tbody>
                </table>
                <!-- Table Ends  -->
      </div>
    </div>



    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>