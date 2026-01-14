<?php
// DATABASE CONNECTION (PROCEDURAL)
$conn = mysqli_connect("localhost", "root", "", "ecommerce");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// CREATE OR UPDATE PRODUCT
if (isset($_POST['save'])) {
    $product_id  = $_POST['product_id'];
    $category_id = $_POST['category_id'];
    $name        = $_POST['product_name'];
    $price       = $_POST['price'];
    $stock       = $_POST['stock'];
    $description = $_POST['description'];
    $image       = $_POST['image']; // (for now text/image path)

    if ($product_id == "") {
        $query = "INSERT INTO productstable 
        (`category_id`, `product name`, `price`, `stock`, `description`, `image`)
        VALUES ('$category_id', '$name', '$price', '$stock', '$description', '$image')";
    } else {
        $query = "UPDATE productstable SET
        `category_id`='$category_id',
        `product name`='$name',
        `price`='$price',
        `stock`='$stock',
        `description`='$description',
        `image`='$image'
        WHERE product_id='$product_id'";
    }

    mysqli_query($conn, $query);
    header("Location: admin.php");
}

// DELETE PRODUCT
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM productstable WHERE product_id='$id'");
    header("Location: admin.php");
}

// EDIT PRODUCT
$edit = false;
$product = [
    "product_id" => "",
    "category_id" => "",
    "product name" => "",
    "price" => "",
    "stock" => "",
    "description" => "",
    "image" => ""
];

if (isset($_GET['edit'])) {
    $edit = true;
    $id = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM productstable WHERE product_id='$id'");
    $product = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <style>
        body { font-family: Arial; padding: 30px; }
        input, textarea { width: 100%; padding: 8px; margin: 5px 0; }
        button { padding: 10px 15px; }
        table { width: 100%; border-collapse: collapse; margin-top: 30px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background: #f4f4f4; }
        a { text-decoration: none; color: red; }
    </style>
</head>
<body>

<h2><?php echo $edit ? "Edit Product" : "Add Product"; ?></h2>

<form method="post">
    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">

    <label>Category ID</label>
    <input type="number" name="category_id" required value="<?php echo $product['category_id']; ?>">

    <label>Product Name</label>
    <input type="text" name="product_name" required value="<?php echo $product['product name']; ?>">

    <label>Price</label>
    <input type="number" step="0.01" name="price" required value="<?php echo $product['price']; ?>">

    <label>Stock</label>
    <input type="number" name="stock" required value="<?php echo $product['stock']; ?>">

    <label>Description</label>
    <textarea name="description"><?php echo $product['description']; ?></textarea>

    <label>Image (URL or filename)</label>
    <input type="text" name="image" value="<?php echo $product['image']; ?>">

    <button type="submit" name="save">Save Product</button>
</form>

<h2>Products</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Category</th>
        <th>Name</th>
        <th>Price</th>
        <th>Stock</th>
        <th>Image</th>
        <th>Actions</th>
    </tr>

<?php
$result = mysqli_query($conn, "SELECT * FROM productstable ORDER BY product_id DESC");
while ($row = mysqli_fetch_assoc($result)):
?>
    <tr>
        <td><?php echo $row['product_id']; ?></td>
        <td><?php echo $row['category_id']; ?></td>
        <td><?php echo $row['product name']; ?></td>
        <td>$<?php echo $row['price']; ?></td>
        <td><?php echo $row['stock']; ?></td>
        <td><?php echo $row['image']; ?></td>
        <td>
            <a href="admin.php?edit=<?php echo $row['product_id']; ?>">Edit</a> |
            <a href="admin.php?delete=<?php echo $row['product_id']; ?>" onclick="return confirm('Delete this product?')">Delete</a>
        </td>
    </tr>
<?php endwhile; ?>

</table>

</body>
</html>
