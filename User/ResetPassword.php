<!-- Endpoint for user Password Reset Request -->
<?php
$id = $_GET["id"];
$Ascde = $_GET["ascde"];
include_once "../Components/connection.php";



$sql = "UPDATE `users` SET `Pwd`= NULL , `AccessCode`='$Ascde', `Reset`= false WHERE id = $id";

$result = $conn->query($sql);
echo json_encode($sql);

if ($result) {
    header('Location: ../User/User.php');
}