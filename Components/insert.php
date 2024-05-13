<?php
    // include('connection.php');
    // if(isset($_POST['add'])){
    //     $CarType=$_POST['Cartype'];
    //     $category=$_POST['category'];
    //     $amount=$_POST['amount'];

    //     $query = mysqli_query($connect, "Insert into services (Cartype, Amount, ServiceCategoryId) Values('$CarType, $category, $amount");
    //     if($query){
    //         echo"<script>alert(data inserted successfully)</script>";

    //     } else{
    //         echo"<script>alert(there is an error)</script>";

    //     }
    // }

    include('connection.php');
    if(isset($_POST['add1'])){
        $CatName=$_POST['CatName'];
        $CommissionRate=$_POST['CommissionRate'];

        $query = mysqli_query($connect, "Insert into servicecategory (CatName, CommissinRate) Values('$CatName, $CommissionRate");
        if($query){
            echo"<script>alert(data inserted successfully)</script>";

        } else{
            echo"<script>alert(there is an error)</script>";

        }
    }





?>