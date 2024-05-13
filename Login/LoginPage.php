



<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="Logincss.css">
    <?php include "../Components/HeadContent.php" ?>

</head>
<body style="background-color: #A635FF;">
<main>
    <form method="POST" action="">

    <?php
$msg = "";
include_once "../Components/connection.php";

if ($conn === false) {
    die("Could not connect to the server. Error: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $pwd = $_POST['password'];

    

    $sql = "SELECT `Username`, `Pwd` FROM `users` WHERE Username = '$username' AND Pwd = '$pwd'";

    if ($username === "" || $pwd === "") {
        $msg = "<div class='alert alert-danger'>Username or password does not match.</div>";
    } else {
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $msg = "<div class='alert alert-success'>Login successfully.</div>";
        } else {
            $msg = "<div class='alert alert-danger'>Username does not exist.</div>";
        }
    }
}
?>

      
      <?php echo $msg; ?>
      <div class="container d-flex flex-column  w-50 gap-4 " style="margin-top: 140px;">
          <img src="./LOGINCARWASH.png" alt="" width="330" class="mx-auto mb-5">
            <!-- <label for="username">USERNAME</label>
            <input type="text" class="insert" name="username" placeholder="Insert username"><br><br> -->
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