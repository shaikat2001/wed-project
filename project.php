<?php include("db.php"); ?>

<?php
// Auto-create required tables if not exist
$conn->query("CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255) NOT NULL,
    availability VARCHAR(50) DEFAULT 'Available'
)");

$conn->query("CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    status VARCHAR(50) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
)");

$conn->query("CREATE TABLE IF NOT EXISTS shop (
    id INT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    logo VARCHAR(255)
)");

// Insert a default shop row if not exists
$conn->query("INSERT IGNORE INTO shop (id, name, description, logo) VALUES (1, 'My Shop', 'Shop description', NULL)");

?>

<?php
// Ensure $conn is set and valid
if (!isset($conn) || !$conn) {
    die("<p style='color:red;'>Database connection failed. Please check db.php.</p>");
}
// Prevent redeclaration error
if (!function_exists('validateInput')) {
    function validateInput($data) {
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Seller Dashboard</title>
<style>
    body {
        font-family: 'Segoe UI', Arial, sans-serif;
        background: #f4f6fb;
        margin: 0;
        padding: 0;
    }
    h1 {
        background: #2d3e50;
        color: #fff;
        margin: 0;
        padding: 30px 0 20px 0;
        text-align: center;
        letter-spacing: 2px;
        font-size: 2.2em;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .menu {
        background: #fff;
        padding: 20px 0;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        margin-bottom: 30px;
    }
    .menu a {
        margin: 0 18px;
        text-decoration: none;
        font-weight: 600;
        color: #2d3e50;
        font-size: 1.1em;
        padding: 8px 18px;
        border-radius: 4px;
        transition: background 0.2s, color 0.2s;
    }
    .menu a:hover, .menu a:focus {
        background: #2d3e50;
        color: #fff;
    }
    .box {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.07);
        padding: 30px 32px 24px 32px;
        margin: 30px auto;
        max-width: 700px;
    }
    h2 {
        color: #2d3e50;
        margin-top: 0;
        font-size: 1.5em;
        border-bottom: 1px solid #eaeaea;
        padding-bottom: 10px;
        margin-bottom: 25px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        background: #fafbfc;
        border-radius: 6px;
        overflow: hidden;
    }
    th, td {
        padding: 12px 10px;
        text-align: left;
    }
    th {
        background: #2d3e50;
        color: #fff;
        font-weight: 600;
    }
    tr:nth-child(even) {
        background: #f4f6fb;
    }
    tr:hover {
        background: #e3eaf2;
    }
    input[type="text"], textarea {
        width: 95%;
        padding: 8px;
        border: 1px solid #cfd8dc;
        border-radius: 4px;
        margin-bottom: 8px;
        font-size: 1em;
        background: #f9fafb;
        transition: border 0.2s;
    }
    input[type="text"]:focus, textarea:focus {
        border: 1.5px solid #2d3e50;
        outline: none;
    }
    input[type="file"] {
        margin-top: 6px;
        margin-bottom: 12px;
    }
    button, input[type="submit"] {
        background: #2d3e50;
        color: #fff;
        border: none;
        padding: 9px 22px;
        border-radius: 4px;
        font-size: 1em;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
        margin-top: 5px;
    }
    button:hover, input[type="submit"]:hover {
        background: #1a2533;
    }
    select {
        padding: 7px 10px;
        border-radius: 4px;
        border: 1px solid #cfd8dc;
        background: #f9fafb;
        font-size: 1em;
    }
    p {
        font-size: 1.08em;
    }
    @media (max-width: 800px) {
        .box {
            max-width: 98vw;
            padding: 16px 6vw 16px 6vw;
        }
        table, th, td {
            font-size: 0.98em;
        }
    }
</style>
</head>
<body>
<h1>Seller Dashboard</h1>
<div class="menu">
<a href="?page=add">Add Product</a>
<a href="?page=manage">Edit/Delete Product</a>
<a href="?page=availability">Set Availability</a>
<a href="?page=orders">View Orders</a>
<a href="?page=sales">Sales Summary</a>
<a href="?page=shop">Shop Profile</a>
</div>
<?php

$page = $_GET['page'] ?? 'add';



// Add Product
if ($page=="add") {
    if (isset($_POST['add'])) {
        $name  = validateInput($_POST['name']);
        $price = validateInput($_POST['price']);
        $image = $_FILES['image']['name'];
        if (empty($name) || empty($price) || empty($image)) {
            echo "<p style='color:red;'>All fields are required!</p>";
        } elseif (!is_numeric($price)) {
            echo "<p style='color:red;'>Price must be numeric!</p>";
        } elseif (!in_array(strtolower(pathinfo($image, PATHINFO_EXTENSION)), ['jpg','jpeg','png'])) {
            echo "<p style='color:red;'>Only JPG, JPEG, PNG allowed!</p>";
        } else {
            // Ensure uploads directory exists
            if (!is_dir("uploads")) mkdir("uploads");
            move_uploaded_file($_FILES['image']['tmp_name'], "uploads/".$image);
            $sql = "INSERT INTO products (name, price, image) VALUES ('$name','$price','$image')";
            echo ($conn->query($sql)) ? "<p style='color:green;'>Product added!</p>" : "<p style='color:red;'>Error: ".$conn->error."</p>";
        }
    }
?>
<div class="box">
<h2>Add Product</h2>
<form method="post" enctype="multipart/form-data">
Name: <input type="text" name="name"><br><br>
Price: <input type="text" name="price"><br><br>
Image: <input type="file" name="image"><br><br>
<button type="submit" name="add">Add Product</button>
</form>
</div>
<?php }



   // Edit/Delete Product
if ($page=="manage") {
    if (isset($_GET['delete'])) {
        $id=intval($_GET['delete']);
        $conn->query("DELETE FROM products WHERE id=$id");
        echo "<p style='color:green;'>Product deleted!</p>";
    }
    if (isset($_POST['update'])) {
        $id=intval($_POST['id']);
        $name=validateInput($_POST['name']);
        $price=validateInput($_POST['price']);
        if(empty($name)||empty($price)) echo "<p style='color:red;'>All fields required!</p>";
        elseif(!is_numeric($price)) echo "<p style='color:red;'>Price must be numeric!</p>";
        else { $conn->query("UPDATE products SET name='$name',price='$price' WHERE id=$id"); echo "<p style='color:green;'>Updated!</p>"; }
    }
    $res=$conn->query("SELECT * FROM products");
?>
<div class="box">
<h2>Edit/Delete Products</h2>
<table border="1" cellpadding="8">
<tr><th>ID</th><th>Name</th><th>Price</th><th>Action</th></tr>
<?php while($r=$res->fetch_assoc()){ ?>
<tr>
<form method="post">
<td><?php echo $r['id']; ?></td>
<td><input type="text" name="name" value="<?php echo $r['name']; ?>"></td>
<td><input type="text" name="price" value="<?php echo $r['price']; ?>"></td>
<td>
<input type="hidden" name="id" value="<?php echo $r['id']; ?>">
<button name="update">Update</button>
<a href="?page=manage&delete=<?php echo $r['id']; ?>" onclick="return confirm('Delete this product?')">Delete</a>
</td>
</form>
</tr>
<?php } ?>
</table>
</div>
<?php }



   // Set Availability
if ($page=="availability") {
    if (isset($_POST['avail'])) {
        $id=intval($_POST['id']);
        $status=$_POST['status'];
        if($status!=="Available" && $status!=="Out of Stock") echo "<p style='color:red;'>Invalid status!</p>";
        else { $conn->query("UPDATE products SET availability='$status' WHERE id=$id"); echo "<p style='color:green;'>Availability updated!</p>"; }
    }
    $res=$conn->query("SELECT * FROM products");
?>
<div class="box">
<h2>Set Product Availability</h2>
<table border="1" cellpadding="8">
<tr><th>ID</th><th>Name</th><th>Status</th><th>Action</th></tr>
<?php while($r=$res->fetch_assoc()){ ?>
<tr>
<form method="post">
<td><?php echo $r['id']; ?></td>
<td><?php echo $r['name']; ?></td>
<td>
<select name="status">
<option <?php if($r['availability']=="Available") echo "selected"; ?>>Available</option>
<option <?php if($r['availability']=="Out of Stock") echo "selected"; ?>>Out of Stock</option>
</select>
</td>
<td>
<input type="hidden" name="id" value="<?php echo $r['id']; ?>">
<button name="avail">Update</button>
</td>
</form>
</tr>
<?php } ?>
</table>
</div>
<?php }



   // View Orders
if ($page=="orders") {
    $res=$conn->query("SELECT * FROM orders");
?>
<div class="box">
<h2>All Orders</h2>
<table border="1" cellpadding="8">
<tr><th>Order ID</th><th>Product ID</th><th>Quantity</th><th>Total Price</th><th>Status</th></tr>
<?php while($o=$res->fetch_assoc()){ ?>
<tr>
<td><?php echo $o['id']; ?></td>
<td><?php echo $o['product_id']; ?></td>
<td><?php echo $o['quantity']; ?></td>
<td><?php echo $o['total_price']; ?></td>
<td><?php echo $o['status']; ?></td>
</tr>
<?php } ?>
</table>
</div>
<?php }



   // Sales Summary
if ($page=="sales") {
    $r=$conn->query("SELECT SUM(quantity) as sold, SUM(total_price) as revenue FROM orders WHERE status='Completed'")->fetch_assoc();
?>
<div class="box">
<h2>Sales Summary</h2>
<p>Total Products Sold: <?php echo $r['sold'] ?? 0; ?></p>
<p>Total Revenue: $<?php echo $r['revenue'] ?? 0; ?></p>
</div>
<?php }



   // Shop Profile
if ($page=="shop") {
    if (isset($_POST['save'])) {
        $shop=validateInput($_POST['shop_name']);
        $desc=validateInput($_POST['description']);
        $logo=$_FILES['logo']['name'];
        if(!empty($logo)){
            if(in_array(strtolower(pathinfo($logo,PATHINFO_EXTENSION)),['jpg','jpeg','png'])){
                // Ensure uploads directory exists
                if (!is_dir("uploads")) mkdir("uploads");
                move_uploaded_file($_FILES['logo']['tmp_name'], "uploads/".$logo);
                $conn->query("UPDATE shop SET name='$shop',description='$desc',logo='$logo' WHERE id=1");
            } else echo "<p style='color:red;'>Invalid logo format!</p>";
        } else {
            $conn->query("UPDATE shop SET name='$shop',description='$desc' WHERE id=1");
        }
        echo "<p style='color:green;'>Shop profile updated!</p>";
    }
    $s=$conn->query("SELECT * FROM shop WHERE id=1")->fetch_assoc();
?>
<div class="box">
<h2>Shop Profile</h2>
<form method="post" enctype="multipart/form-data">
Name: <input type="text" name="shop_name" value="<?php echo $s['name']; ?>"><br><br>
Description:<br>
<textarea name="description"><?php echo $s['description']; ?></textarea><br><br>
Logo: <input type="file" name="logo"><br><br>
<button name="save">Save</button>
</form>
</div>
<?php }

?>
</body>
</html>
