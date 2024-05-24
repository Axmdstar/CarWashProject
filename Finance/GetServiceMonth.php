<?php
include "../Components/connection.php";
$month = $_GET["Month"];

$sql = "SELECT `Cartype`, `category`, `Amount`, `CreatedAT`, `CustomerNumber`, usr.Username as Createdby FROM
`dailyservices` as ds INNER JOIN users as usr on ds.UsrId = usr.id
WHERE MONTH(ds.CreatedAT) = $month
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