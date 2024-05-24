<?php

setcookie("Username", "", time()-3600 ,"/");
setcookie("EmployeeType", "", time()-3600 ,"/");

header('Location: ../Login/LoginPage.php');
  