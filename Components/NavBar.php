<!-- setcookie("Username", $data["Username"] , time() + (86400 * 30), "/");
setcookie("EmployeeType", $data["EmployeeType"] , time() + (86400 * 30), "/"); -->
<?php 
  if(!isset($_COOKIE["Username"]) && !isset($_COOKIE["EmployeeType"]) ){
    header('Location: ../Login/LoginPage.php');
  } 

?>

<!-- ====== NavBar ========-->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-baseline justify-content-between">

        <h4 class="d-none d-lg-block">JAZZERA</h4>
      
      <i class="bi bi-list toggle-sidebar-btn mx-4"></i>
    </div>

  

    <script>
  var toggleButton = document.querySelector('.toggle-sidebar-btn');

  // Check if the element exists
  if (toggleButton) {
      // Add onclick event handler
      toggleButton.onclick = function(e) {
          // Toggle the class on body
          document.body.classList.toggle('toggle-sidebar');
      };
  }

  
</script>



</header><!-- End Header -->

<?php 
if($_COOKIE['EmployeeType'] == "Admin" ){
  include "../Components/SideBar.php";
} elseif ($_COOKIE['EmployeeType'] == "User" ) {
  include "../Components/UserSideBar.php";
} 

?>