<?php
$id = $_GET["id"];
echo $id;
include_once "../Components/connection.php";

$sql = "DELETE FROM `ServiceCategory` WHERE id = $id";

$result = $conn->query($sql);
echo $result;

if ($result) {
    header('Location: ../Services/Services.php');
}
else {
    
}