<?php
$id = $_GET["id"];

include_once "../Components/connection.php";

$sql = "DELETE FROM `soldproducts` WHERE id = $id";

$result = $conn->query($sql);


if ($result) {
    header('Location: ../Products/UserProduct.php');
}
