<?php
$errors = [];
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   // Sanitize and validate the product name
   $productName = trim($_POST['product_name']);
   if (empty($productName)) {
       $errors[] = 'Product name is required.';
   } elseif (strlen($productName) < 3) {
       $errors[] = 'Product name must be at least 3 characters long.';
   }
   // Sanitize and validate the price
   $productPrice = filter_var($_POST['product_price'], FILTER_VALIDATE_FLOAT);
   if ($productPrice === false || $productPrice <= 0) {
       $errors[] = 'Product price must be a valid number greater than zero.';
   }
   // Validate the uploaded image
   if (empty($_FILES['product_picture']['name'])) {
       $errors[] = 'Product picture is required.';
   } else {
       $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
       $fileType = mime_content_type($_FILES['product_picture']['tmp_name']);
       // Check file type and size
       if (!in_array($fileType, $allowedTypes)) {
           $errors[] = 'Invalid file type. Only JPEG, PNG, and GIF are allowed.';
       }
       if ($_FILES['product_picture']['size'] > 5000000) { // 5MB
           $errors[] = 'File is too large. Maximum size is 5MB.';
       }
   }
   // If there are no errors, proceed with adding the product
   if (empty($errors)) {
       // Here you would process the data, e.g., save to a database and move the uploaded file.
       // echo "Product added successfully!";
   } else {
       // Display validation errors to the user
       echo "<h3>Validation Errors:</h3>";
       echo "<ul>";
       foreach ($errors as $error) {
           echo "<li>" . htmlspecialchars($error) . "</li>";
       }
       echo "</ul>";
   }
}
?>
<form method="POST" enctype="multipart/form-data">
<label for="product_name">Product Name:</label>
<input type="text" name="product_name"><br><br>
<label for="product_price">Price:</label>
<input type="text" name="product_price"><br><br>
<label for="product_picture">Picture:</label>
<input type="file" name="product_picture"><br><br>
<button type="submit">Add Product</button>
</form>