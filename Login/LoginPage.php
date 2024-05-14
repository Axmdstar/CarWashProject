<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include "../Components/HeadContent.php" ?>

</head>
<body style="background-color: #A635FF;">
<main>
    <form method="POST" >

    <?php
    $msg = "";
    include_once "../Components/connection.php";

    if ($conn === false) {
        die("Could not connect to the server. Error: " . $conn->connect_error);
    }

    if (isset($_POST['Login'])) {
        $username = $_POST['username'];
        $pwd = $_POST['password'];

        $sql = "SELECT usr.Username, emp.EmployeeType FROM users as usr 
        INNER JOIN employee as emp on emp.id = usr.emid
        WHERE usr.Username = '$username' AND usr.Pwd = '$pwd';
        ";

        if ($username === "" || $pwd === "") {
            $msg = "<div class='alert alert-danger'>Username or password does not match.</div>";
        } else {
            $result = $conn->query($sql);
            $data = $result->fetch_assoc();
            if ($data) {
                
                setcookie("Username", $data["Username"] , time() + (86400 * 30), "/");
                setcookie("EmployeeType", $data["EmployeeType"] , time() + (86400 * 30), "/");

                if ($data["EmployeeType"] == "Admin") {
                    header('Location: ../Dashboard/Dashboard.php');    
                } else {
                    header('Location: ../Dashboard/Dashboard.php');    
                }
                

            } else {
                $msg = "<div class='alert alert-danger'>Username does not exist.</div>";
                
            }
        }
    }
    ?>

      
      <div class="container d-flex flex-column  w-50 gap-4 " style="margin-top: 140px;">
          <img src="./LOGINCARWASH.png" alt="" width="330" class="mx-auto mb-5">
            
            <?php echo $msg; ?>
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="floatingInput" name="username">
              <label for="floatingInput">Username</label>
            </div>

            <!-- <label for="password">PASSWORD</label>
            <input type="password" class="insert" name="password" placeholder="Insert password"> -->
            <div class="form-floating mb-3">
              <input type="password" class="form-control" id="floatingInput" name="password">
              <label for="floatingInput">Password</label>
            </div>
            

            <input type="submit" value="LOGIN" id="input" class="Login w-auto  " name="Login" >
        </div>
    </form>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>