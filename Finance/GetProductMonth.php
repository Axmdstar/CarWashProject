<?php
include "../Components/connection.php";
$month = $_GET["Month"];

$sql = "SELECT `ProductName`, `Quantity`, `Amount`, `CustomerNumber`, `Solddate`, usr.Username as Createdby FROM `soldproducts` as sp
INNER JOIN users as usr on sp.UsrId = usr.id 
WHERE MONTH(sp.Solddate) = $month
";

$result = $conn->query($sql);
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
if (count($data) > 0) {
    echo json_encode($data);
} else {
    echo json_encode(0);
}