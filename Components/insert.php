<?php
    include('connection.php');
    if(isset($_POST['add'])){
        $EmploeeId=$_POST['EmployeeId'];
        $Username=$_POST['Username'];

        $query = mysqli_query($connect, "Insert into services (EmployeeId, Username) Values('$Username, $Username");
        if($query){
            echo"<script>alert(data inserted successfully)</script>";

        } else{
            echo"<script>alert(there is an error)</script>";

        }
    }


    // if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //     $CatName=$_POST['CatName'];
    //     $CommissionRate=$_POST['CommissionRate'];

    //     $connect = new mysqli('localhost','root','','new service');

    //     $sql = "INSERT INTO servicecategory(CatName, CommissionRate)  VALUES ('$CatName','$CommissionRate')";
    //         $result = $connect->query($sql);

        

        
        
    // }

?>