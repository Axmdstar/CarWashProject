<!doctype html>

<head>
    <html lang="en">
    <?php include "../Components/HeadContent.php" ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<body>

    <?php include '../Components/NavBar.php' ?>

    <main id="main" class="main">

        <form method="POST" action="../User/User.php">
            <!-- Content Here  -->

            <div class="card">
                <?php
                if (isset($_POST['add'])) {
                    include_once "../Components/connection.php";
                    $id = $_POST['UsrId'];
                    $Username = $_POST['username'];
                    
                    $sql = "INSERT INTO `users`(`Username`, `Pwd`, `emid`) VALUES ('$Username', $id)";

                    $result = $conn->query($sql);
                    if ($result) {
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                New record created successfully
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
                    } }
                ?>
                <div class="card-body">
                    <h1 class="card-title">Create New User</h1>

                    <div class="row ">
                        <div class="col">
                            <div class="form-floating mb-3 ">
                                <select class="form-select" name="UsrId" id="floatingSelect" aria-label="Floating label select example">
                                    <?php
                                        include_once "../Components/connection.php";
                                        $sql = "SELECT id, FirstName FROM employee
                                        WHERE EmployeeType = 'User'";
                                        $result = $conn->query($sql);
                                        echo "<option selected>Select Emp Id</option>";
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value=$row[id]>$row[id]-$row[FirstName]</option>";
                                        }
                                    ?>
                                </select>
                                <label for="floatingSelect">EmployeeId</label>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" name="username" class="form-control" id="floatingInput" placeholder="" required>
                                <label for="floatingInput">Username</label>
                            </div>
                        </div>
                            <input type="submit" class="JazzeraBtn col" value="Add" name="add">
                    </div>
                </div>
                </div>
        </form>

        
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">All Users</h1>

                <table class=" customTable">
                    <thead>
                        <tr>
                            <th scope="col">EmployeeId</th>
                            <th scope="col">Username</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include_once "../Components/connection.php";
                            $sql = "SELECT * FROM users";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                
                                echo "
                                <tr>
                                    <td>$row[emid]</td>
                                    <td>$row[Username]</td>
                                    <td class='d-flex gap-4'> 
                                    ";
                                    ?>
                                    <?php 
                                    
                                    echo "
                                        <a style='color: black;' href='../User/ResetPassword.php?id=$row[id]'><i class='bi bi-arrow-repeat'></i></a> 
                                        <a style='color: black;' href='../User/UpdateUser.php?id=$row[id]'><i class='bi bi-pencil-fill'></i></a> 
                                        <a style='color: black;' href='../User/DeleteUser.php?id=$row[id]'><i class='bi bi-trash-fill'></i></a> 
                                    
                                        ";
                                if ($row['Reset'] == 1) {
                                    echo "<i class='bi bi-exclamation-lg' style='color: red;'></i> </td> </tr>";
                                }
                            }
                            ?>
                    </tbody>
                    
                </table>    
            </div>
        </div>
        
    </main>
</body>

</html>
</head>