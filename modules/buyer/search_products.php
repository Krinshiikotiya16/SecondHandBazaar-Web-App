<?php
session_start();
include "../../config/db.php";


$xcid = $_SESSION['sid'];

$xsearch = $_POST['search'];

$q = "SELECT * FROM item 
      WHERE I_NAME='$xsearch' 
      AND SELL_STATUS='N' 
      AND (NOT C_ID='$xcid')";

$rs = mysqli_query($con,$q);
?>

<!DOCTYPE html>
<html>
<head>
<title>Search</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: #c28e8d;
    position: relative;
    min-height: 100vh;
}

/* FULL BACKGROUND IMAGE */
body::before {
    content: "";
    position: fixed;
    inset: 0;
    background: url("../../assests/img/doodle.png") repeat;
    background-size: 300px;
    opacity: 0.24;
    filter: blur(0.5px);
    z-index: -1;
}

.navbar{
    position:relative;
    display:flex;
    justify-content:space-between;
    align-items:center;

    height:80px;          /* fixed navbar height */
    padding:0 50px;

    background:linear-gradient(
        rgba(164,107,106,0.96),
        rgba(236,197,180,0.96)
    );

    color:white;
    z-index:1;

    clip-path: polygon(
        0 0, 100% 0, 100% 85%,
        95% 90%, 90% 85%, 85% 92%,
        80% 88%, 75% 93%, 70% 87%,
        65% 91%, 60% 86%, 55% 92%,
        50% 88%, 45% 93%, 40% 87%,
        35% 91%, 30% 86%, 25% 92%,
        20% 88%, 15% 93%, 10% 87%,
        5% 91%, 0 85%
    );
}

.logo{
    display:flex;
    align-items:center;
    font-size:25px;
    font-weight:bold;
}

.logo-img{
    width:70px;
    height:50px;

    object-fit:contain;
    margin-right:6px;
    transform:scale(1.5);   /* logo looks bigger */
}


.nav-links {
    display: flex;
    gap: 20px;
    align-items: center;
}

.nav-links button {
    padding: 8px 15px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.3s;
}

.nav-links button:hover {
    transform: scale(1.05);
}
.cart-btn{
    text-decoration:none;
   
    color:#222;
    padding:8px 16px;
    border-radius:25px;
    font-weight:600;
    transition:.3s;
    margin-right:15px;
    border:1px solid #696968;
    display:inline-block;
}

.cart-btn:hover{
    background:#ffce54;
    color:#000;
}

.post-btn,
.register-btn {
    background: #f9d45df7;
    color: black;
}

.header {
    margin: 0;
    padding: 40px 20px;
    text-align: center;
    background: linear-gradient(135deg, #2f261e, #694a3a);
    color: white;
    border-radius: 0 0 30px 30px;
}

.header h1 {
    font-size: 32px;
    letter-spacing: 2px;
    margin: 0;
}

.grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    max-width: 1200px;
    margin: 30px auto;
}

.card {
    background: white;
    border-radius: 15px;
    padding: 10px;
    text-align: center;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 10px;
}

.price {
    color: green;
    font-weight: bold;
}

.btn {
    background: #ff3f6c;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 6px;
    cursor: pointer;
}
</style>
</head>

<body>

<div class="navbar">
    <div class="logo"><img src="../../assests/img/logo.jpg" alt="" class="logo-img">SecondHand-Bazaar</div>

    <div class="nav-links">
        <a href="cart.php" class="cart-btn"><i class="bi bi-cart3"></i> My Cart</a>
        <a href="../seller/sell_product.php">
            <button class="post-btn"><b>+ Sell</b></button>
        </a>

        <a href="../auth/logout.php">
            <button class="register-btn"><b>Logout</b></button>
        </a>
    </div>
</div>

<div class="header">
    <h1>Search Results</h1>
</div>

<div class="grid">

<?php
if(mysqli_num_rows($rs) > 0)
{
    while($row = mysqli_fetch_array($rs))
    {
        $xicode = $row['I_CODE'];

        echo "
        <div class='card'>
            <img src='../../assests/img/{$row['I_IMAGE']}'>
            <div>{$row['I_NAME']}</div>
            <div class='price'>₹ {$row['I_PRICE']}</div>

             <a href='add_to_cart.php?I_CODE=$xicode'>
    <button class='btn cart-btn'>🛒 Add to Cart</button>
</a>
        </div>";
    }
}
else
{
    echo "<h2 style='text-align:center;width:100%;color:white;'>No items found</h2>";
}
?>

</div>

</body>
</html>