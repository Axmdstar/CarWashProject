<?php
$id = $_GET["id"];
echo $id;
include_once "../Components/connection.php";

$sql = "UPDATE `users` SET `Pwd`=NULL , `Reset`= false WHERE id = $id";

$result = $conn->query($sql);
echo $result;

if ($result) {
    header('Location: ../User/User.php');
}