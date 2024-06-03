<?php
$id = $_GET["id"];
echo $id;
include_once "../Components/connection.php";

$sql = "DELETE FROM `employee` WHERE id = $id";

$result = $conn->query($sql);
echo $result;

if ($result) {
    header('Location: ../Employee/Employee.php');
}
else {
    
}