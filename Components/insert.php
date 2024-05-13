<?php
    include('connection.php');
    if(isset($_POST['add'])){
        $ServiceName=$_POST['ServiceName'];
        $category=$_POST['category'];
        $amount=$_POST['amount'];

        $query = mysqli_query($connect, "Insert into services (CarName, Amount, ServiceCategoryId) Values('$ServiceName, $category, $amount");
        if($query){
            echo"<script>alert(data inserted successfully)</script>";

        } else{
            echo"<script>alert(there is an error)</script>";

        }
    }




?>