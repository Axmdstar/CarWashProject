<?php
    include('connection.php');
    if(isset($_POST['add1'])){
        $CatName=$_POST['CatName'];
        $CommissionRate=$_POST['CommissionRate'];

        $query = mysqli_query($connect, "Insert into CatName (CatName, CommissinRate) Values('$CatName, $CommissionRate");
        if($query){
            echo"<script>alert(data inserted successfully)</script>";

        } else{
            echo"<script>alert(there is an error)</script>";

        }
    }




?>