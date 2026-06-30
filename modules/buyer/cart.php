<?php
session_start();
include "../../config/db.php";

if(!isset($_SESSION['sid']))
{
    header("Location:../../index.php");
    exit();
}

$cid = $_SESSION['sid'];

/* USER DETAILS */
$q1 = "SELECT * FROM client WHERE C_ID='$cid'";
$r1 = mysqli_query($con,$q1);
$user = mysqli_fetch_assoc($r1);

/* CART ITEMS */
$q2 = "SELECT cart.CART_ID,
               cart.QTY,
               item.I_CODE,
               item.I_NAME,
               item.I_PRICE,
               item.I_IMAGE
        FROM cart
        INNER JOIN item
        ON cart.I_CODE=item.I_CODE
        WHERE cart.C_ID='$cid'
        AND item.SELL_STATUS='N'";

$r2 = mysqli_query($con,$q2);

$total=0;
?>


<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>My Cart</title>

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

html,body{
    overflow-x:hidden;
}
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:rgba(158, 89, 88, 0.99);
    position:relative;
    min-height:100vh;
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

.post-btn {
    background: #f9d45df7;
    color: black;
}

.register-btn {
    background:  #f9d45df7;
    color: black;
}

.container{
    width:95%;
    max-width:1400px;
    margin:35px auto;
}

.heading{
    text-align:center;
    font-size:42px;
    color:black;
    font-weight:700;
    margin-bottom:30px;
}

.wrapper{
    display:flex;
    flex-wrap:wrap;
    justify-content:space-between;
    gap:25px;
}

.left{
    width:68%;
    min-width:0;
}

.right{
    width:30%;
    position:sticky;
    top:20px;
}

/* USER */

.user{
     width:100%;
    box-sizing:border-box;
    display:flex;
    align-items:center;
    gap:25px;

    background:#fff;
    padding:28px;
    border-radius:18px;
    box-shadow:0 10px 25px rgba(0,0,0,.08);

    margin-bottom:25px;
}

.avatar-circle{
    width:90px;
    height:90px;
    border-radius:50%;
    background:linear-gradient(135deg,#ff7b54,#ff3f6c);
    color:#fff;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:38px;
    font-weight:bold;
}

.user-details h2{
    margin:0;
    color:#6d2e2e;
}

.user-details p{
    margin:8px 0;
    color:#555;
    font-size:16px;
}

/* PRODUCT CARD */

.card{
    display:flex;
    align-items:center;
    gap:20px;
    background:#fff8f8;
    padding:18px;
    margin-bottom:18px;
    border-radius:20px;
    box-shadow:0 12px 30px rgba(91,40,40,.12);
    transition:.35s;
    position:relative;
}

.card:hover{
    transform:translateY(-5px);
}

.card img{
    width:140px;
    height:130px;
    object-fit:cover;
    border-radius:15px;
}

.info{
    flex:1;
}

.info h3{
    margin:0;
    color:#6d2e2e;
    font-size:25px;
}

.info p{
    margin:8px 0;
    color:#555;
}

.price{
    color:#169c45;
    font-size:24px;
    font-weight:bold;
}

.remove-icon{
    position:absolute;
    top:18px;
    right:22px;
    text-decoration:none;
    font-size:30px;
    color:#999;
    transition:.3s;
}

.remove-icon:hover{
    color:#ff3f6c;
    transform:rotate(90deg);
}

/* SUMMARY */

.summary{
    background:#fff8f8;
    border-radius:22px;
    padding:28px;
    box-shadow:0 12px 30px rgba(91,40,40,.12);
}

.summary h2{
    margin-top:0;
    text-align:center;
    color:#6d2e2e;
}

.row{
    display:flex;
    justify-content:space-between;
    margin:18px 0;
    color:#444;
    font-size:17px;
}

.total{
    font-size:24px;
    font-weight:bold;
    color:#000;
}

.buy{
    width:100%;
    padding:16px;
    border:none;
    border-radius:40px;
    cursor:pointer;
    margin-top:20px;

    background:linear-gradient(135deg,#ff3f6c,#ff6b6b);

    color:#fff;
    font-size:18px;
    font-weight:600;
    transition:.35s;
}

.buy:hover{
    transform:translateY(-3px);
    box-shadow:0 12px 25px rgba(255,63,108,.35);
}

.empty{
    background:#fff;
    border-radius:20px;
    text-align:center;
    padding:80px;
    font-size:24px;
}
.footer-small {
    position: relative;
    background:linear-gradient(rgba(164, 107, 106, 0.96),rgba(236, 197, 180, 0.96));
    color: white;

    padding: 20px 20px 10px; /* 🔥 very small height */
    font-size: 20px;
}

/* 🔥 SMALL TORN TOP */
.footer-small::before {
    content: "";
    position: absolute;
    top: -20px;
    left: 0;
    width: 100%;
    height: 30px;
    background: #b68a82;

    clip-path: polygon(
        0 70%, 5% 50%, 10% 70%, 15% 55%, 20% 75%,
        25% 60%, 30% 80%, 35% 65%, 40% 75%, 45% 60%,
        50% 80%, 55% 65%, 60% 75%, 65% 60%, 70% 80%,
        75% 65%, 80% 75%, 85% 60%, 90% 80%, 95% 65%, 100% 70%
    );
}

/* ROW CONTENT */
.footer-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 900px;
    margin: auto;
    flex-wrap: wrap;
}

/* TEXT */
.footer-row span {
    opacity: 0.9;
}


/* ================= MOBILE ================= */

@media screen and (max-width:768px){

.navbar{
    padding:15px;
    height:auto;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    gap:15px;
    clip-path:none;
}

.logo{
    font-size:20px;
}

.logo-img{
    width:50px;
    height:40px;
    transform:none;
}

.nav-links{
    width:100%;
    display:flex;
    justify-content:center;
    gap:12px;
    flex-wrap:wrap;
}

.nav-links button{
    font-size:14px;
    padding:8px 15px;
}

.container{
    width:95%;
    margin:20px auto;
}

.heading{
    font-size:28px;
}

.wrapper{
    display:block;
}

.left,
.right{
    width:100%;
}

.right{
    position:static;
    margin-top:20px;
}

.user{
    width:100%;
    padding:18px;
    gap:15px;
    flex-wrap:wrap;
}

.avatar-circle{
    width:65px;
    height:65px;
    font-size:28px;
}

.user-details{
    flex:1;
}

.user-details h2{
    font-size:20px;
}

.user-details p{
    font-size:14px;
}

.card{
    width:100%;
    padding:15px;
    gap:12px;
}

.card img{
    width:90px;
    height:90px;
}

.info h3{
    font-size:18px;
}

.info p{
    font-size:14px;
}

.price{
    font-size:18px;
}

.remove-icon{
    font-size:22px;
    right:12px;
    top:10px;
}

.summary{
    width:100%;
    padding:20px;
}

.row{
    font-size:15px;
}

.total{
    font-size:20px;
}

.buy{
    font-size:16px;
    padding:14px;
}

.footer-small{
    padding:18px 10px;
}

.footer-row{
    flex-direction:column;
    gap:10px;
    text-align:center;
}

}


</style>

</head>


<body>
    <!-- Navbar -->
<div class="navbar">
    <div class="logo"><img src="../../assests/img/logo.jpg" alt=""  class="logo-img">SecondHand-Bazaar</div>
    <div class="nav-links">
        <a href="../seller/sell_product.php"><button class="post-btn"><b>+ Sell</b></button></a>
        <a href="../auth/logout.php"><button class="register-btn"><b>Logout</b></button></a>
    </div>
</div>

<div class="container">

<div class="heading">
🛒 My Shopping Cart
</div>

    <!-- USER CARD -->
    <?php
$initial = strtoupper(substr($user['C_NAME'],0,1));
?>

<div class="user">

<div class="avatar-circle">
<?php echo $initial; ?>
</div>

<div class="user-details">

<h2><?php echo $user['C_NAME']; ?></h2>

<p><i class="bi bi-envelope"></i> <?php echo $user['C_EMAIL']; ?></p>

<p><i class="bi bi-telephone"></i> <?php echo $user['C_MOB']; ?></p>

</div>

</div>

<div class="wrapper">

<!-- LEFT SIDE -->
<div class="left">
<?php

$count=0;

while($row=mysqli_fetch_assoc($r2))
{

$count++;

$subtotal=$row['I_PRICE']*$row['QTY'];

$total += $subtotal;

?>

<div class="card">

<img src="../../assests/img/<?php echo $row['I_IMAGE']; ?>">

<div class="info">

<h3><?php echo $row['I_NAME']; ?></h3>

<p>Price : ₹ <?php echo $row['I_PRICE']; ?></p>

<p>Quantity : <?php echo $row['QTY']; ?></p>

<p class="price">₹ <?php echo $subtotal; ?></p>

</div>

<a class="remove-icon"
href="remove_cart.php?id=<?php echo $row['CART_ID']; ?>">
✖
</a>

</div>


<?php

}

if($count==0)
{
echo "<div class='empty'>Your Cart is Empty 🛒</div>";
}

?>

</div>


<!-- RIGHT SIDE -->

<div class="right">

<div class="summary">

<h2>Order Summary</h2>

<div class="row">

<span>Total Items</span>

<span><?php echo $count; ?></span>

</div>

<div class="row">

<span>Subtotal</span>

<span>₹ <?php echo $total; ?></span>

</div>

<div class="row">

<span>Delivery</span>

<span>FREE</span>

</div>

<hr>

<div class="row total">

<span>Total</span>

<span>₹ <?php echo $total; ?></span>

</div>

<?php
if($total>0)
{
?>

<a href="payment.php">

<button class="buy">

Checkout

</button>

</a>

<?php
}
?>

</div>

</div>
</div>
</div>

<footer class="footer-small">
    <div class="footer-row">
        <span>© 2026 SecondHand-Bazaar</span>
        <span>Privacy • Terms • Help</span>
    </div>
</footer>

</body>
</html>