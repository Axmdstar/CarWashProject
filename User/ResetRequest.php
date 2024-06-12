<?php 
include_once "../Components/connection.php";

$usrname = $_GET["usrname"];
$sql = "UPDATE `users` SET Reset = True WHERE Username = '$usrname';";

$result = $conn->query( $sql );
// $row = $result->fetch_assoc();



if($result) {
    echo json_encode(array("Msg" => "Please Wait Admin Approval"));
}
else{
    echo json_encode( array("error" => "Not Found") );
}


