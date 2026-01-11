<<?php
    include "db.php";

    /* CREATE & UPDATE */
    if (isset($_POST['save'])) {
        $name = $_POST['productname'];
        $price = $_POST['productRate'];
        $rating = $_POST['productRatings'];
        $description = $_POST['productDesc'];

        $imgName = $_FILES['productImg']['name'];
        $tmpName = $_FILES['productImg']['tmp_name'];

        $imgPath = "";

        if ($imgName != "") {
            $imgPath = "./images/" . $imgName;
            move_uploaded_file($tmpName, $imgPath);
        }

        if ($_POST['id'] == "") {
            // INSERT
            $sql = "INSERT INTO products 
        (productname, productRate, productRatings, productImg, productDesc)
        VALUES 
        ('$name', '$price', '$rating', '$imgPath', '$description')";
        } else {
            // UPDATE
            $id = $_POST['id'];
            $imgQuery = $imgName != "" ? ", productImg='$imgPath'" : "";

            $sql = "UPDATE products SET
            productname='$name',
            productRate='$price',
            productRatings='$rating',
            productDesc='$description'
            $imgQuery
            WHERE productID=$id";
        }

        mysqli_query($conn, $sql) or die(mysqli_error($conn));
        header("Location: admin.php");
    }


    /* DELETE */
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        mysqli_query($conn, "DELETE FROM products WHERE productID=$id");
        header("Location: admin.php");
    }

    /* EDIT */
    $editData = null;
    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        $res = mysqli_query($conn, "SELECT * FROM products WHERE productID=$id");

        if (!$res) {
            die("Query Failed: " . mysqli_error($conn));
        }

        $editData = mysqli_fetch_assoc($res);
    }
    ?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Admin Panel</title>
        <style>
            body {
                font-family: Arial;
                padding: 20px;
            }

            form,
            table {
                width: 100%;
                margin-bottom: 30px;
            }

            input,
            button {
                padding: 8px;
                margin: 5px 0;
                width: 100%;
            }

            table {
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid #ccc;
                padding: 10px;
                text-align: center;
            }

            img {
                width: 60px;
            }

            .btn {
                padding: 6px 12px;
                text-decoration: none;
            }
        </style>
    </head>

    <body>

        <h2>Admin – Add / Update Product</h2>

        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $editData['productID'] ?? '' ?>">

            <label for="">Product Name</label>
            <input type="text" name="productname" placeholder="Enter the Product Name"
                value="<?= $editData['productname'] ?? '' ?>" required>

            <label for="">Product price</label>
            <input type="number" name="productRate" placeholder="Enter the Price"
                value="<?= $editData['productRate'] ?? '' ?>" required>

            <label for="">Product ratings</label>
            <input type="number" name="productRatings" placeholder="Enter the Rating (1–5)"
                value="<?= $editData['productRatings'] ?? '' ?>" min="1" max="5" required>

            <label for="">Product image</label>
            <input type="file" name="productImg">

            <label for="">Product Description</label>
            <input type="text" name="productDesc" placeholder="Enter the description for the product">

            <button type="submit" name="save">
                <?= isset($editData) ? "Update Product" : "Add Product" ?>
            </button>
        </form>

        <hr>

        <h2>All Products</h2>

        <table>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Rating</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>

            <?php
            $result = mysqli_query($conn, "SELECT * FROM products");

            while ($row = mysqli_fetch_assoc($result)) {
                echo "
  <tr>
    <td><img src='{$row['productImg']}'></td>
    <td>{$row['productname']}</td>
    <td>₹{$row['productRate']}</td>
    <td>{$row['productRatings']}/5</td>
    <td>{$row['productDesc']}</td>
    <td>
      <a class='btn' href='admin.php?edit={$row['productID']}'>Edit</a>
      <a class='btn' href='admin.php?delete={$row['productID']}' onclick='return confirm(\"Delete?\")'>Delete</a>
    </td>
  </tr>";
            }
            ?>
        </table>

    </body>

    </html>