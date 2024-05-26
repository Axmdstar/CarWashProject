<?php 
include_once "../Components/connection.php";

$usrname = $_GET["usrname"];
$sql = "SELECT * from users
WHERE Username = '$usrname';";

$result = $conn->query( $sql );
$row = $result->fetch_assoc();



if($row) {
    $password = $row["Pwd"];
    if($password == null) {
        echo json_encode(array("Userstatus"=> "New","Id"=> $row['id']));
    }
}
else{
    echo json_encode( array("error"=> "Not Found") );
}


