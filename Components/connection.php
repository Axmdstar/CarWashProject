<?php
$conn = new mysqli('localhost', 'root', 'root', 'carwash');
if ($conn->connect_error) {
    die(''. $conn->connect_error);
}
