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
    $msg = '';
    include_once "../Components/connection.php";

    if ($conn === false) {
        die("Could not connect to the server. Error: " . $conn->connect_error);
    }

    if (isset($_POST['Login'])) {
        $username = $_POST['username'];
        $pwd = $_POST['password'];
        $status = $_POST['Status'];
        $UsrId = $_POST["UsrId"];

        // Check Status 
        if($status == "New"){
            $sql = "UPDATE `users` SET `Pwd`='$pwd' WHERE $UsrId";
            $result = $conn->query( $sql );
            if ($result) {
                $msg = "<div class='alert alert-info alert-dismissible fade show' role='alert'>
                            <i class='bi bi-info-circle me-1'></i>
                            Password Created Successfully.<br>You can Login
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";    
                }
            
        } else {
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
                    header('Location: ../Services/UserServices.php');    
                }
            } else {
                $msg = "<div class='alert alert-danger'>Username does not exist.</div>";
            }
        }
        }}?>

      
      <div class="container d-flex flex-column  w-50 gap-4 " style="margin-top: 140px;">
          <img src="./LOGINCARWASH.png" alt="" width="330" class="mx-auto mb-5">
            
            <?php echo $msg; ?>
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="Username" name="username">
              <label for="floatingInput">Username</label>
            </div>

            <div class="form-floating mb-3">
              <input type="password" 
                     class="form-control" 
                     id="floatingInput" 
                     name="password" 
                     required 
                     autocomplete="off"
                     pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}"
                     >
              <label for="floatingInput">Password</label>
              <span class="text-light " style="cursor: pointer;"  id="Forgot" >Forgot Password</span>
            </div>
            


            <input type="submit" value="LOGIN" id="input" class="Login w-auto" name="Login" >
            <input type="hidden" id="Status" name="Status" value="">
            <input type="hidden" id="UsrId" name="UsrId" value="">
            <div id="alert-container"></div>
            
        </div>
    </form>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

<script>

function getCookie(name) {
  let matches = document.cookie.match(new RegExp(
    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
  ));
  return matches ? decodeURIComponent(matches[1]) : undefined;
}

function CallAlert(msg){
    const alertContainer = document.getElementById('alert-container');
    const alertDiv = document.createElement('div');

    alertDiv.className = 'alert alert-info alert-dismissible fade show';
    alertDiv.role = 'alert';

    const icon = document.createElement('i');
    icon.className = 'bi bi-info-circle me-1';
    alertDiv.appendChild(icon);

    const alertText = document.createTextNode(msg);
    alertDiv.appendChild(alertText);

    const button = document.createElement('button');
    button.type = 'button';
    button.className = 'btn-close';
    button.setAttribute('data-bs-dismiss', 'alert');
    button.setAttribute('aria-label', 'Close');
    alertDiv.appendChild(button);

    alertContainer.appendChild(alertDiv);
}


    document.getElementById("Forgot").addEventListener("click", () => {
        const Username = getCookie("Username");
        const options = {method: 'GET'};
        fetch('http://localhost/CarWashProject/User/ResetRequest.php?=' + Username, options)
        .then(response => response.json())
        .then(response => {
             CallAlert(response.Msg);            
            })
        .catch(err => CallAlert(err));
    })
    
    document.getElementById("Username").addEventListener("change", (e) => {
        let Username = e.target.value;

        // Userstatus
        const options = {method: 'GET'};
        fetch('http://localhost/CarWashProject/User/CheckUser.php?usrname=' + Username, options)
        .then(response => response.json())
        .then(response => {
            if (response.Userstatus == "New") {
                const hideinput = document.getElementById("Status")
                const UsrId = document.getElementById("UsrId");
                hideinput.value = "New";
                UsrId.value = response.Id;
                
                CallAlert('Welcome New User Create your Password');
                
                         
            }
        })
        .catch(err => console.error(err));
})
</script>
</body>
</html>