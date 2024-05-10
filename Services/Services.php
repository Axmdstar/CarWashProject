<!doctype html>
<html lang="en">
  <?php include "../Components/HeadContent.php" ?>
  <link rel="stylesheet" href="service.css">
  
  <body>
    
  <?php include '../Components/NavBar.php' ?>

  
  <form id="main" class="main">
        <!-- Content Here  -->
        <h2>New Service</h2>
        <label for="">Service Name :</label><br>
        <input type="text" name="service name" id=""> 
        <label for="">Category :</label>
        <input type="text" name="category" id=""><br>
        <label for="">Price :</label> <br>
        <input type="text" name="" id="price"> 
        <button class="add" type="submit">Add service</button>



        <h2>New Category</h2>
        <label for="">Category Name :</label><br>
        <input type="text" name="category name" id=""> 
        <label for="">Commission Rate :</label>
        <input type="text" name="commission rate" id=""> 

</form>
      
    
    <!-- <h2>hello</h2> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>