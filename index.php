<?php include "./db.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
  <title>Ecommerce</title>
  <link rel="stylesheet" href="index.css" />
</head>

<body>
  <nav>
    <div id="logo">
      <h1 id="logo">Blush</h1>
    </div>
    <div id="menus">
      <ul>
        <li><a href="">Home</a></li>
        <li><a href="">About Us</a></li>
        <li><a href="">Shop</a></li>
        <li><a href="">Categories</a></li>
        <li><a href="">Order</a></li>
      </ul>
    </div>
    <div id="icons">
      <img src="./icons/shopping-cart.png" alt="Add to cart" width="25px" />
      <img src="./icons/user.png" alt="Profile" width="25px" />
    </div>
  </nav>
  <main>
    <img src="./images/img_15.jpg" alt="hero banner" />
    <div class="heroText">
      <h2>Explore the latest trend</h2>
    </div>
    <section class="latest">
      <h1>Latest Releases</h1>
    </section>
    <div class="productList">
      <?php
      $sql = "select * from products";
      $result = mysqli_query($conn, $sql);
      $rate = 5;

      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          $rating = (int)$row['productRatings']; // rating from DB
          $maxStars = 5;
          $stars = "";

          // Full stars
          for ($i = 1; $i <= $rating; $i++) {
            $stars .= "⭐";
          }

          // Empty stars
          for ($i = $rating + 1; $i <= $maxStars; $i++) {
            $stars .= "☆";
          }
          $markPrice = $row['productRate'] + ($row['productRate'] * 0.15);
          echo "
             <div class='product'>
             <img src='{$row["productImg"]}' alt='facewash' />
             <div>
               <div class='prdctHeading'>
                 <div class='productTitle'>
                   <h2>{$row['productname']}</h2>
                   <p>{$rating}/5 {$stars}</p>
                 </div>
                 <div class='price'>
                   <p>In stock</p>
                   <h3>₹{$row['productRate']} <span>(₹{$markPrice})</span></h3>                   
                 </div>
                 <button>Add to Cart</button>
               </div>
             </div>
            </div> ";
        }
      } else {
        echo "
        <h1>No data found</h1>
        ";
      } ?>
    </div>
  </main>
</body>

</html>