<?php
session_start();
include "../../config/db.php";


$cat_nam = $_GET['CAT_NAM'] ?? '';

$xcid = $_SESSION['sid'];


$q = "SELECT * FROM item WHERE CAT_NAM='$cat_nam' AND SELL_STATUS='N' ORDER BY I_CODE DESC";
$rs = mysqli_query($con,$q);


$rs_new = mysqli_query($con,
"SELECT * FROM item 
WHERE CAT_NAM='$cat_nam' 
AND SELL_STATUS='N' 
ORDER BY I_CODE DESC 
LIMIT 8 OFFSET 8");

$qcart = "SELECT COUNT(*) AS total FROM cart WHERE C_ID='".$_SESSION['sid']."'";
$rcart = mysqli_query($con,$qcart);
$cart = mysqli_fetch_assoc($rcart);

?>

<!DOCTYPE html>
<html>
<head>
<title>SecondHand-Bazaar</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body { margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: #c28e8d;
    position: relative;
    min-height: 100vh;
}

/* FULL BACKGROUND IMAGE */
body::before {
    content: "";
    position: fixed; /* 🔥 important */
    inset: 0;
    background: url("../../assests/img/doodle.png") repeat;
    background-size: 300px; /* pattern size */
    opacity: 0.24;          /* visible but soft */
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


/* NAV LINKS */
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
    position:relative;
    text-decoration:none;
    color:#222;
    padding:8px 16px;
    border-radius:25px;
    font-weight:1000;
    transition:.3s;
    margin-right:15px;
    border:2px solid #696968;
    display:inline-block;
}
.cart-btn:hover{
    background:#ffce54;
    color:#000;
}
.badge{
    position:absolute;
    top:-8px;
    right:-8px;
    background:red;
    color:white;
    width:20px;
    height:20px;
    border-radius:50%;
    text-align:center;
    line-height:20px;
    font-size:11px;
    font-weight:bold;
}

/* BUTTON COLORS */
.post-btn,
.register-btn {
    background: #f9d45df7;
    color: black;
}

/* HEADER */
.header {
    margin: 0; /* no gap */
    padding: 40px 20px;
    text-align: center;
    background: linear-gradient(135deg, #2f261e, #694a3a);
    color: white;
    border-radius: 0 0 30px 30px;
}

/* HEADER TEXT */
.header h1 {
    font-size: 32px;
    letter-spacing: 2px;
    margin: 0;
}

.header p {
    margin-top: 10px;
    font-size: 16px;
}
/* SECTION */
.section {
    padding: 30px 40px;
    animation: fadeUp 1s ease;
}

/* SECTION TITLE */
.section h2 {
    text-align: center;
    color: #a30e53;
    font-size: 26px;
    position: relative;
    display: inline-block;
    left: 50%;
    transform: translateX(-50%);
}

/* UNDERLINE ANIMATION */
.section h2::after {
    content: "";
    display: block;
    width: 0%;
    height: 3px;
    background: #ff3f6c;
    margin: 8px auto 0;
    border-radius: 5px;
    animation: lineGrow 1.5s ease forwards;
}

/* ANIMATIONS */

/* Gradient movement */
@keyframes gradientMove {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* Fade + slide */
@keyframes fadeSlide {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Glow text */
@keyframes glowText {
    from { text-shadow: 0 0 5px rgba(255,255,255,0.3); }
    to { text-shadow: 0 0 15px rgba(255,255,255,0.8); }
}

/* Section fade up */
@keyframes fadeUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Underline grow */
@keyframes lineGrow {
    from { width: 0%; }
    to { width: 60%; }
}


/* BIGGER GRID */
.grid {
   display: grid;
    grid-template-columns: repeat(4, 1fr); /* force 4 */
    gap: 20px;
    width: 100%;              /* full width */
    max-width: 1200px;        /* increase space */
    margin: 0 auto;
}

/* BIGGER CARDS */
.card {
    background: white;
    border-radius: 18px;
    padding: 15px;
    text-align: center;
    box-shadow: 0 6px 18px rgba(0,0,0,0.18);
    transition: 0.3s;
}

.card:hover {
    transform: scale(1.06);
}

/* BIGGER IMAGE */
.card img {
    width: 100%;
    height: 200px; /* increased */
    object-fit: cover;
    border-radius: 12px;
    transform: rotate(-2deg);
    transition: 0.4s;
}
.card:hover img {
    transform: rotate(0deg) scale(1.05);
}
.price {
    color: green;
    font-size: 15px;
    font-weight: bold;
}

.btn {
    background: #ff3f6c;
    color: white;
    border: none;
    padding: 6px 12px;
    font-size: 13px;
    border-radius: 6px;
}

/* MINI IMAGE */
.banner {
    margin:20px;
    height: 200px;
    border-radius: 20px;
    overflow: hidden;
   background: #ff3f6c;
}

.banner img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 20px;
}

/* NEW CARDS STYLE BIGGER */
.new-card {
    background: #fff0f3;
    border-radius: 15px;
    padding: 12px;
    text-align: center;
    animation: zoomIn 0.5s ease;
}

.new-card img {
    width: 100%;
    height: 200px;
    border-radius: 12px;
    transform: rotate(3deg);
    transition: 0.4s;
}

.new-card:hover img {
    transform: rotate(0deg) scale(1.05);
}


/* SLIDER BIG IMAGES */
/* SLIDER */
.slider {
    overflow: hidden;
    width: 100%;
    margin: 40px 0;
}

/* TRACK */
.slide-track {
    display: flex;
    width: max-content;           /* 🔥 important */
    animation: scroll 35s linear infinite;
}

/* IMAGES */
.slide-track img {
    width: 260px;
    height: 160px;
    margin: 10px;
    border-radius: 15px;
    object-fit: cover;
    flex-shrink: 0;              /* 🔥 prevents shrinking */
    transition: 0.3s;
}

/* hover effect (optional) */
.slide-track img:hover {
    transform: scale(1.05);
}
@keyframes scroll {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%);
    }
}

.footer2 {
    margin-top: 80px;
  background: linear-gradient(135deg, #2f261e, #694a3a);
    color: white;
    padding: 60px 20px 20px;
    border-top-left-radius: 40px;
    border-top-right-radius: 40px;
}

/* CTA BOX */
.cta-box {
    background: linear-gradient(135deg, #f54d74, #f47171);
    padding: 30px;
    border-radius: 20px;
    text-align: center;
    margin-bottom: 40px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
}

.cta-box h2 {
    margin-bottom: 10px;
}

.cta-box p {
    font-size: 14px;
    margin-bottom: 20px;
}

/* BUTTONS */
.cta-buttons a {
    text-decoration: none;
    margin: 5px;
    padding: 10px 20px;
    border-radius: 25px;
    display: inline-block;
    transition: 0.3s;
}

.cta-primary {
    background: white;
    color: #ff3f6c;
    font-weight: bold;
}

.cta-secondary {
    border: 2px solid white;
    color: white;
}

.cta-buttons a:hover {
    transform: scale(1.08);
}

/* FOOTER GRID */
.footer-content {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 20px;
}

.footer-links,
.footer-brand,
.footer-social {
    flex: 1;
    min-width: 150px;
}

.footer-links a {
    display: block;
    color: #ccc;
    margin: 5px 0;
    text-decoration: none;
}

.footer-links a:hover {
    color: #ff3f6c;
}

/* SOCIAL */
.icons span {
    font-size: 22px;
    margin-right: 10px;
    cursor: pointer;
}

/* BOTTOM */
.footer-bottom {
    text-align: center;
    margin-top: 30px;
    font-size: 13px;
    color: #aaa;
}

/* MOBILE */
@media (max-width: 768px) {
    .footer-content {
        flex-direction: column;
        text-align: center;
    }
}
/* ================= MOBILE ================= */
@media (max-width:768px){

    html,
    body{
        width:100%;
        overflow-x:hidden;
    }

    /* NAVBAR */
    .navbar{
        display:flex;
        flex-direction:row;
        justify-content:space-between;
        align-items:center;
        padding:10px 15px;
        height:auto;
        clip-path:none;
    }

    .logo{
        display:flex;
        align-items:center;
        font-size:18px;
    }

    .logo-img{
        width:40px;
        height:40px;
        margin-right:5px;
        transform:none;
    }

    .nav-links{
        display:flex;
        gap:8px;
        align-items:center;
    }

    .nav-links button{
        padding:8px 12px;
        font-size:12px;
        white-space:nowrap;
    }


    /* HEADER */
    .header{
        padding:25px 15px;
    }

    .header h1{
        font-size:24px;
    }

    .header p{
        font-size:14px;
    }

    /* SECTION */
    .section{
        padding:20px 10px;
    }

    .section h2{
        font-size:20px;
    }

    /* PRODUCT GRID */
    .grid{
        grid-template-columns:repeat(2,1fr);
        gap:10px;
        width:100%;
    }

    .card{
        padding:10px;
    }

    .card img{
        height:120px;
    }

    .card h3{
        font-size:14px;
    }

    .price{
        font-size:13px;
    }

    .btn{
        padding:6px 10px;
        font-size:12px;
    }

    /* BANNER */
    .banner{
        margin:10px;
        height:120px;
    }

    /* SLIDER */
    .slider{
        width:100%;
        overflow:hidden;
    }

    .slide-track img{
        width:150px;
        height:100px;
        margin:5px;
    }

    /* FOOTER */
    .footer-content{
        flex-direction:column;
        text-align:center;
    }

    .footer2{
        padding:40px 15px 15px;
    }

    .cta-box{
        padding:20px;
    }

    .cta-box h2{
        font-size:20px;
    }

    .cta-box p{
        font-size:13px;
    }
}

</style>
</head>

<body>
    <div class="navbar">
    <div class="logo"> <img src="../../assests/img/logo.jpg" alt="" class="logo-img">SecondHand-Bazaar</div>
    <div class="nav-links">
        <a href="cart.php" class="cart-btn"><i class="bi bi-cart3"></i> My Cart  <span class="badge"><?php echo $cart['total']; ?></span></a>
        <a href="../seller/sell_product.php"><button class="post-btn"><b>+ Sell</b></button></a>
        <a href="../auth/logout.php"><button class="register-btn"><b>Logout</b></button></a>
    </div>
</div>

<div class="header">
    <h1>Buy Smart. Live Better <br> <span>"Explore top deals across all categories” </span></h1>
</div>

<!-- FIRST CARDS -->
<div class="section">
<h2>Top Collections
    <br>Explore the most recent brought items
</h2>
<div class="grid">

<?php
$count = 0;
if(mysqli_num_rows($rs) > 0)
{
    while($row = mysqli_fetch_array($rs))
{
    $xicode = $row['I_CODE'];

    echo "
    <div class='new-card'>

        <img src='../../assests/img/{$row['I_IMAGE']}'>

        <div>{$row['I_NAME']}</div>

        <div class='price'>₹ {$row['I_PRICE']}</div>
        <a href='add_to_cart.php?I_CODE=$xicode&CAT_NAM=".urlencode($cat_nam)."'>
    <button class='btn cart-btn'>🛒 Add to Cart</button>
</a>

    </div>";
}
}
?>

</div>
</div>

<div class="banner"> <img src="../../assests/img/buy.png">Special Collection</div>

<!-- NEW ARRIVALS -->
<div class="section">
<h2>New Arrivals</h2>
<div class="grid">

<?php
mysqli_data_seek($rs,0);
$count = 0;
while($row = mysqli_fetch_array($rs_new))
{
    if($count >= 8) break;
    $count++;
    echo "<div class='new-card'>
    <img src='../../assests/img/{$row['I_IMAGE']}'>
    <div>{$row['I_NAME']}</div>
    <div class='price'>₹ {$row['I_PRICE']}</div>
    <a href='add_to_cart.php?I_CODE=$xicode&CAT_NAM=".urlencode($cat_nam)."'>
    <button class='btn cart-btn'>🛒 Add to Cart</button>
</a>

    </div>";
}
?>

</div>
</div>

<!-- SLIDER -->
<div class="slider">
    <div class="slide-track">

<?php
mysqli_data_seek($rs,0);

while($row = mysqli_fetch_array($rs))
{
    echo "<img src='../../assests/img/{$row['I_IMAGE']}'>";
}
?>

    </div>
</div>

<footer class="footer2">

    <!-- CTA BOX -->
    <div class="cta-box">
        <h2>Ready to Find Your Next Deal?</h2>
        <p>Join thousands of users buying and selling smartly every day.</p>

        <div class="cta-buttons">
            <a href="dashboard.php" class="cta-primary">Browse Now</a>
            <a href="../seller/sell_product.php" class="cta-secondary">Sell Item</a>
        </div>
    </div>

    <!-- FOOTER CONTENT -->
    <div class="footer-content">

        <div class="footer-brand">
            <h3>SecondHand-Bazaar</h3>
            <p>Turning old items into new opportunities.</p>
        </div>


        <div class="footer-social">
            <h4>Follow Us</h4>
            <div class="icons">
                <span>🌐</span>
                <span>📘</span>
                <span>📸</span>
                <span>🐦</span>
            </div>
        </div>

    </div>

    <div class="footer-bottom">
        © 2026 SecondHandBazaar — All rights reserved
    </div>

</footer>


</body>
</html>