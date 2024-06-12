<?php 
include_once "../Components/connection.php";

// Check if the product parameter is set
if(isset($_GET['product'])) {
    // Sanitize the input to prevent SQL injection
    $selectedProduct = mysqli_real_escape_string($conn, $_GET['product']);
    
    // Query to retrieve available quantity from the database
    $sql = "SELECT * FROM `product` Where  `ProductName` = '$selectedProduct'";
    
    // Execute the query
    $result = mysqli_query($conn, $sql);
    
    // Check if query was successful
    if($result) {
        // Fetch the result
        $row = mysqli_fetch_assoc($result);
        // Return the available quantity as JSON
        echo json_encode(
            ['data' => array('available_quantity' => $row['Available'], 'price' => $row['Amount'], 'PurchaseAmount' => $row['PurchaseAmount']) ]
             );
    } else {
        // Return an error message if query fails
        echo json_encode(['error' => mysqli_error($conn)]);
    }
} else {
    // Return an error message if product parameter is not set
    echo json_encode(['error' => 'Product parameter is missing.']);
}

// Close the database connection
mysqli_close($conn);

?>