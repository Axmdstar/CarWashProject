<?php
$id = $_GET["id"];

include_once "../Components/connection.php";

$sql = "DELETE FROM `dailyservices` WHERE id = $id";

$result = $conn->query($sql);
echo $result;

if ($result) {
    header('Location: ../Services/UserServices.php');
}
