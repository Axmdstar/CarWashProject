<?php
include "../Components/connection.php";
$month = $_GET["Month"];

$sql = "SELECT `id`, `CreatedAt`, `ServiceRevenue`, `ProductSoldAmount`, `CommisionAmount`, `DailyIncome` FROM `dailyaudit`
WHERE MONTH(CreatedAt) = $month";

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