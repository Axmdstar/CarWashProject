<!-- <?php
$msg = "";
$mysqli = mysqli_connect("localhost", "root", "", "carwash");
if ($mysqli === false) {
    // die("Could not connect to the server. Error: " . $mysqli->connect_error);
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $pwd = $_POST['password'];

    // Properly escape user input to prevent SQL injection
    $username = mysqli_real_escape_string($mysqli, $username);
    $pwd = mysqli_real_escape_string($mysqli, $pwd);

    $sql = "SELECT `Username`, `Pwd` FROM `users` WHERE Username = '$username' AND Pwd = '$pwd'";
    if ($username === "" || $pwd === "") {
        $msg = "<div class='alert alert-danger'>Username or password does not match.</div>";
    } else {
        $result = mysqli_query($mysqli, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $msg = "<div class='alert alert-success'>Login successfully.</div>";
        } else {
            $msg = "<div class='alert alert-danger'>Username does not exist.</div>";
        }
    }
}
?> -->




<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
          crossorigin="anonymous">
    <link rel="stylesheet" href="form.css">

</head>
<body>
<main>
    <form method="POST" action="">
        <h1>CAR WASH</h1>
        <br><br><br>
        <?php echo $msg; ?>
        <div class="div">
            <label for="username">USERNAME</label>
            <input type="text" class="insert" name="username" placeholder="Insert username"><br><br>
            <label for="password">PASSWORD</label>
            <input type="password" class="insert" name="password" placeholder="Insert password">
            <br><br><br><br>
            <input type="submit" id="input" name="submit" value="LOG IN">
        </div>
    </form>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
