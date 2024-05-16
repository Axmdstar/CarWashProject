<!-- <?php
    if($_SERVER['REQUEST_METHOED'] == 'POST'){
        $ServiceName=$_POST['CatName'];
        $category=$_POST['CommissionRate'];

        $connect = new mysqli('localhost','root','root','service');

        $sql = "INSERT INTO servicecategory(CatName, CommissionRate)  VALUES ('$CatName','$CommissionRate')";
            $result = $connect->query($sql);

        $query = mysqli_query($connect, "Insert into servicecategory (CarName, Amount, ServiceCategoryId) Values('$ServiceName, $category, $amount");
        if($query){
            echo"<script>alert(data inserted successfully)</script>";

        }}