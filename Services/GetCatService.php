<?php 
include_once "../Components/connection.php";

if (isset($_GET["Category"])) {
    
    $sql = "SELECT * FROM services as s 
    INNER JOIN servicecategory as sc on sc.id = s.ServiceCategoryId
    WHERE sc.CatName = '$_GET[Category]';";

    $result = $conn->query($sql);
    $ServiceNames = array();
    while($row = $result->fetch_assoc()) {
        $ServiceNames[] = array("ServiceName" => $row["CarName"], "Amount" => $row["Amount"]);
    }

    echo json_encode(
        ['data' => $ServiceNames ]
         );

    }
