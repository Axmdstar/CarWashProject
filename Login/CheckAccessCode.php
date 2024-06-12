<?php

include_once "../Components/connection.php";
$AccessCode = $_GET["ascde"];
$username = $_GET["username"];

$sql = "SELECT usr.Username, emp.EmployeeType FROM users as usr 
        INNER JOIN employee as emp on emp.id = usr.emid
        WHERE usr.Username = '$username' AND usr.AccessCode = '$AccessCode';";

$result = $conn->query( $sql );
$row = $result->fetch_assoc();


if($row) {
    // $password = $row["Pwd"];
    $Username = $row["Username"];
    
    if($Username != null) {
        echo json_encode(array("Username"=> $Username));
    }
}
else{
    echo json_encode(Null);
}



