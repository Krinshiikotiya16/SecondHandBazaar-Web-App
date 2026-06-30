<?php
session_start();
include "../../config/db.php";

require_once '../../razorpay-php-master/Razorpay.php';
use Razorpay\Api\Api;

$key_id = "rzp_live_T0E03YO2u78Pfu";
$key_secret = "IxFXhxbSWSxuk11XiV1eBUoX";

if(!isset($_SESSION['sid']))
{
    die("Please Login First");
}

$xbcid = $_SESSION['sid'];

/* USER DETAILS */
$q1 = "SELECT * FROM client WHERE C_ID='$xbcid'";
$r1 = mysqli_query($con,$q1);
$user = mysqli_fetch_assoc($r1);

if(!$user)
{
    die("Client Not Found");
}

/* CART ITEMS */
$q2 = "SELECT cart.QTY,
               item.I_CODE,
               item.I_NAME,
               item.I_PRICE
        FROM cart
        INNER JOIN item
        ON cart.I_CODE=item.I_CODE
        WHERE cart.C_ID='$xbcid'
        AND item.SELL_STATUS='N'";

$r2 = mysqli_query($con,$q2);

$total = 0;
$totalItems = 0;
$itemList = "";

while($row=mysqli_fetch_assoc($r2))
{
    $subtotal = $row['I_PRICE'] * $row['QTY'];

    $total += $subtotal;

    $totalItems += $row['QTY'];

    $itemList .=
    $row['I_NAME'].
    " (Qty : ".$row['QTY'].")<br>";
}

if($total==0)
{
    die("Your Cart is Empty");
}

$name  = $user['C_NAME'];
$email = $user['C_EMAIL'];

$amount = $total;

$api = new Api($key_id,$key_secret);

$order = $api->order->create([
    'receipt' => 'ORD_CART_'.time(),
    'amount' => $amount * 100,
    'currency' => 'INR'
]);

$order_id = $order['id'];
?>

<!DOCTYPE html>

<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Payment by stud</title>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<style>

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
.payment-container{
    min-height:calc(100vh - 140px); /* navbar + footer */

    display:flex;
    justify-content:center;
    align-items:center;

    padding:40px 20px;
}

.card{

    width:500px;

    background:rgba(255, 255, 255, 0.15);

    backdrop-filter:blur(15px);

    border:1px solid rgba(255,255,255,0.2);

    border-radius:25px;

    padding:35px;

    color:white;

    box-shadow:0 15px 35px rgba(0,0,0,0.3);

    animation:fadeIn 0.8s ease;
}

h2{
    text-align:center;
    margin-bottom:30px;
    font-size:32px;
    color:#fff;
}

.info{
    background:rgba(255,255,255,0.1);

    padding:15px;

    margin-bottom:15px;

    border-radius:12px;

    font-size:18px;
}

.info b{
    color:#ffd700;
}

button{
    width:100%;

    padding:15px;

    border:none;

    border-radius:12px;

    background:linear-gradient(135deg,#00c6ff,#0072ff);

    color:white;

    font-size:18px;

    font-weight:bold;

    cursor:pointer;

    transition:0.3s;
}

button:hover{
    transform:translateY(-3px);

    box-shadow:0 10px 20px rgba(0,114,255,0.4);
}

@keyframes fadeIn{
    from{
        opacity:0;
        transform:translateY(40px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }
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

<div class="payment-container">

<div class="card">

<h2>💳 Payment Details</h2>

<div class="info">
<b>Name :</b> <?php echo $name; ?>
</div>

<div class="info">
<b>Email :</b> <?php echo $email; ?>
</div>

<div class="info">
<b>Item :</b><?php echo $itemList; ?>
</div>

<div class="info">
<b>Total Items :</b>
<?php echo $totalItems; ?>
</div>

<div class="info">
<b>Total Amount :</b>₹<?php echo $amount; ?>
</div>

<button id="rzp-button">
🔒 Pay Securely with Razorpay
</button>

</div>
</div>

<footer class="footer-small">
    <div class="footer-row">
        <span>© 2026 SecondHand-Bazaar</span>
        <span>Privacy • Terms • Help</span>
    </div>
</footer>

<script>
var options = {

"key":"<?php echo $key_id; ?>",

"amount":"<?php echo $amount*100; ?>",

"currency":"INR",

"name":"SecondHand-Bazaar",

"description":"Item Purchase",

"order_id":"<?php echo $order_id; ?>",

"handler":function(response)
{
var form=document.createElement("form");

form.method="POST";

form.action="payment_verification.php";

form.innerHTML=
'<input type="hidden" name="payment_id" value="'+response.razorpay_payment_id+'">'+
'<input type="hidden" name="order_id" value="'+response.razorpay_order_id+'">'+
'<input type="hidden" name="signature" value="'+response.razorpay_signature+'">'+
'<input type="hidden" name="cart_payment" value="1">';

document.body.appendChild(form);

form.submit();
}

};

var rzp1 = new Razorpay(options);

document.getElementById('rzp-button').onclick = function(e)
{
rzp1.open();
e.preventDefault();
};

</script>

</body>
</html>
