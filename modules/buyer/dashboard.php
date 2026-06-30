<?php
session_start();
include "../../config/db.php";

$qcat = mysqli_query($con,"SELECT * FROM category ORDER BY CAT_NAM ASC");
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SecondHand-Bazaar</title>

<link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;

}

/* PAGE LOAD */
body {
    background-image:url("../../assests/img/back.jpg");
    animation: fadeIn 1s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
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

/* Hero Section */
.hero {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 400px;
    margin: 30px;
    background:linear-gradient(rgba(185, 120, 119, 0.89));
    overflow: cointain;
}

/* SPLIT CONTAINER */
.split-box {
    position: relative;
    width: 1350px;
    height: 350px;
    overflow: hidden;
}

/* IMAGES */
.img {
    position: absolute;
    width: 100%;
    height: 100%;
    object-fit: cover;   /* 🔥 change back */
    object-position: center; 
    object-position: right center;
}


/* NEW IMAGE CLIP */
.new {
    clip-path: inset(0 100% 0 0);
    animation: revealNew 5s infinite;
}


/* DIVIDER LINE */
.divider {
    position: absolute;
    width: 4px;
    height: 100%;
    background: white;
    left: 0;
    animation: moveLine 5s infinite;
}

/* TEXT */
.text {
    position: absolute;
    top: 90%;   /* 🔥 moved down from 40% */
    left: 50%;
    transform: translate(-50%, -50%);

  font-family: 'Anton', sans-serif;
    font-size: 25px;
    font-weight: 700;

    color: #953030; /* solid white */
    letter-spacing: 3px;

    
        text-shadow:
        0 0 10px rgba(255,200,150,0.8),
        0 0 20px rgba(255,150,100,0.6);
}
/* ANIMATIONS */
@keyframes revealNew {
    0%   { clip-path: inset(0 100% 0 0); }
    50%  { clip-path: inset(0 0 0 0); }
    100% { clip-path: inset(0 100% 0 0); }
}

@keyframes moveLine {
    0%   { left: 0%; }
    50%  { left: 100%; }
    100% { left: 0%; }
}

/* OUTER */
.search-box {
    display: flex;
    justify-content: center;
    margin-top: 40px;
    animation: fadeInUp 1s ease;
}

/* FORM CONTAINER */
.search-container {
    display: flex;
    align-items: center;

    width: 600px; /* 🔥 bigger */
    padding: 8px;

    background: rgba(236, 116, 116, 0.83);
    backdrop-filter: blur(12px);
    border-radius: 50px;

    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    transition: 0.4s;
}

/* ICON */
.icon {
    margin-left: 15px;
    font-size: 18px;
    color: white;
}

/* INPUT */
.search-container input {
    flex: 1;
    padding: 15px;
    border: none;
    outline: none;
    background: transparent;

    color: white;
    font-size: 16px;
}

/* PLACEHOLDER */
.search-container input::placeholder {
    color: rgba(255,255,255,0.7);
}

/* BUTTON */
.search-container button {
    padding: 12px 30px;
    border: none;
    border-radius: 40px;

    background: linear-gradient(45deg, #f996d6, #feb47b);
    color: white;
    font-weight: bold;
    cursor: pointer;

    transition: 0.3s;
}

/* HOVER */
.search-container button:hover {
    transform: scale(1.05);
    box-shadow: 0 0 15px rgba(255,150,100,0.8);
}

/* CLICK */
.search-container button:active {
    transform: scale(0.95);
}

/* FOCUS EFFECT */
.search-container:focus-within {
    box-shadow: 0 0 20px rgba(246, 187, 159, 0.84);
}

/* EXPAND INPUT */
.search-container:focus-within input {
    transform: scale(1.05);
}

/* ENTRY ANIMATION */
@keyframes fadeInUp {
    from {
        transform: translateY(30px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}
.topic{
    text-align: center;
    margin: 40px 0 20px;
    
    font-size: 26px;
    font-weight: 700;
    letter-spacing: 2px;
    color: #f5e6dc;

    position: relative;
}

/* Decorative lines left & right */
.topic::before,
.topic::after {
    content: "";
    position: absolute;
    top: 50%;
    width: 80px;
    height: 2px;
    background: linear-gradient(to right, transparent, #f5e6dc);
}

.topic::before {
    left: 25%;
}

.topic::after {
    right: 25%;
    background: linear-gradient(to left, transparent, #f5e6dc);
}

/* Sub text */
.topic span {
    display: block;
    margin-top: 8px;

    font-size: 20px;
    font-weight: 400;
    letter-spacing: 1px;
    color: rgba(255,255,255,0.7);
}

/* Animation */
.topic {
    animation: fadeUp 1s ease;
}

@keyframes fadeUp {
    from {
        transform: translateY(20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }

}
/* Categories */
.categories {
    display: flex;
    justify-content: center;
    gap: 20px;
    padding: 40px;
    flex-wrap: wrap;
    background-image:url("../../assests/img/back.jpg");
    
}

/* CARD */
.card {
    position: relative;
    display: inline-block;
    cursor: pointer;
    text-decoration: none;
    transition: 0.4s;
}

/* IMAGE (NO FIXED SIZE) */
.card img {
    width: 180px; /* you can adjust */
    height: auto;
    display: block;
    transition: 0.4s;
    filter: drop-shadow(0 10px 20px rgba(0,0,0,0.4));
    border-radius: 50% 70% 65% 55% / 65% 50% 70% 60%;
}

/* TEXT */
.card span {

    position: absolute;
    left: 40px;
    font-weight: bold;
    background: rgba(250, 244, 244, 0.5);
    padding: 5px 10px;
    color: purple;
    margin:10px;
    border-radius: 10px;
}

/* HOVER FLOAT */
.card:hover img {
    transform: translateY(-10px) scale(1.08);
}

/* AIR BURST EFFECT */
.card::after {
    content: "";
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    background: rgba(255,200,150,0.8);
    border-radius: 50%;
    transform: translate(-50%, -50%) scale(0);
    opacity: 0;
    pointer-events: none;
}

/* TRIGGER BURST */
.card.burst::after {
    animation: airBurst 0.6s ease-out;
}

@keyframes airBurst {
    0% {
        transform: translate(-50%, -50%) scale(0.2);
        opacity: 1;
        box-shadow: 0 0 0 0 rgba(255,150,0,0.8);
    }
    50% {
        transform: translate(-50%, -50%) scale(2.5);
        opacity: 0.6;
        box-shadow: 0 0 40px 20px rgba(255,150,0,0.5);
    }
    100% {
        transform: translate(-50%, -50%) scale(3);
        opacity: 0;
    }
}

/* ZOOM EFFECT */
.card.zooming img {
    transform: scale(2);
    transition: 0.5s;
    z-index: 999;
}

/* SECTION */
.about {
    padding: 100px 20px;
    background-image:url("../../assests/img/back.jpg");

    text-align: center;
    overflow: hidden;
}

/* CONTENT */
.about-content {
    max-width: 800px;
    margin: auto;
}

/* HEADING */
.about-content h2 {
    font-family: 'Playfair Display', serif;
    font-size: 34px;
    color: #8ac3d9;
    position: relative;
    display: inline-block;
    margin-bottom: 25px;
}

/* UNDERLINE LINE ANIMATION */
.line {
    position: absolute;
    left: 0;
    bottom: -8px;
    width: 0;
    height: 3px;
    background: #569cb8;
    animation: lineGrow 1.5s ease forwards;
}

/* HIGHLIGHT WORD */
.highlight {
    color: #c4a99c;
    position: relative;
}

/* TYPEWRITER EFFECT */
.para {
    font-family: 'Poppins', sans-serif;
    font-size: 15px;
    color: #ade4ee;
    line-height: 1.7;
    margin-bottom: 15px;

    opacity: 0;
    animation: fadeSlide 1s ease forwards;
}

/* DELAY FOR EACH LINE */
.para:nth-child(2) { animation-delay: 0.5s; }
.para:nth-child(3) { animation-delay: 1s; }

/* TAGLINE GLOW */
.tagline {
    margin-top: 25px;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    color: #cde19f;

    animation: glowPulse 2s infinite;
}

/* BACKGROUND FLOATING SHAPES */
.about::before,
.about::after {
    content: "";
    position: absolute;
    width: 200px;
    height: 200px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    filter: blur(40px);
    animation: float 6s infinite alternate;
}

.about::before {
    top: 10%;
    left: 10%;
}

.about::after {
    bottom: 10%;
    right: 10%;
}

/* ANIMATIONS */

@keyframes lineGrow {
    from { width: 0; }
    to { width: 100%; }
}

@keyframes fadeSlide {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes glowPulse {
    0% { text-shadow: 0 0 5px rgba(160,82,45,0.3); }
    50% { text-shadow: 0 0 15px rgba(160,82,45,0.7); }
    100% { text-shadow: 0 0 5px rgba(160,82,45,0.3); }
}

@keyframes float {
    from { transform: translateY(0px); }
    to { transform: translateY(-30px); }
}

.testimonials {
    padding: 90px 30px;
    margin:30px;
    text-align: center;
    background-image:url("../../assests/img/cuss.jpg");
    clip-path: polygon(
        2% 3%, 10% 0%, 20% 2%, 30% 1%, 40% 3%, 50% 0%, 
        60% 2%, 70% 1%, 80% 3%, 90% 0%, 98% 2%, 100% 8%,
        98% 20%, 100% 40%, 97% 60%, 100% 80%, 98% 92%,
        90% 95%, 80% 92%, 70% 96%, 60% 91%, 50% 95%, 
        40% 92%, 30% 96%, 20% 91%, 10% 95%, 2% 92%,
        0% 80%, 2% 60%, 0% 40%, 3% 20%
    );
    overflow: hidden;
}

/* TITLE */
.test-title {
    font-size: 26px;
    margin-bottom: 30px;
    color: ;
    letter-spacing: 2px;
}

/* CONTAINER (SMALL WIDTH) */
.test-container {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;

    max-width: 700px;   /* 🔥 smaller area */
    margin: auto;
}

/* CARD */
.test-card {
    width: 200px;
    padding: 50px;

    background: rgba(234, 177, 177, 0.2);
    backdrop-filter: blur(10px);

    color: white;

    /* 🔥 DIFFERENT CURVES */
    border-radius: 40px 10px 40px 10px;

    border: 1px solid rgba(255,255,255,0.2);

    font-size: 15px;
    transition: 0.4s;

    /* animation */
    opacity: 0;
    transform: translateY(40px);
    animation: fadeUp 0.8s ease forwards;
}

.test-card:nth-child(2){ animation-delay:0.3s; }
.test-card:nth-child(3){ animation-delay:0.6s; }

/* HOVER EFFECT */
.test-card:hover {
    transform: translateY(-10px) scale(1.05);
    background: rgba(255,255,255,0.2);
}

/* TEXT */
.test-card h4 {
    margin-top: 10px;
    font-size: 17px;
    opacity: 0.8;
}

/* ANIMATION */
@keyframes fadeUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
iframe{
        width: 98%;
        height: 300px;
        margin:20px;
        border-radius: 12px;
        
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
/* mobile */

@media (max-width:768px){

/* NAVBAR */
.navbar{
    flex-direction:row;
    justify-content:space-between;
    padding:10px;
    clip-path:none;
}

.logo{
    font-size:18px;
}

.logo-img{
    width:40px;
    height:35px;
}
.nav-links{
    display:flex;
    justify-content:center;
    gap:8px;
    flex-wrap:wrap; /* important */
    width:100%;
}

.nav-links button{
    padding:8px 12px;
    font-size:13px;
}

/* SLIDER */

.hero{
    margin:10px;
    border-radius:15px;
    overflow:hidden;
}

.split-box{
    border-radius:15px;
}

.img{
    object-fit:cover;
    object-position:center;
}

.text{
    font-size:20px;
    width:90%;
    top:85%;
}

/* SEARCH BAR */
.search-box{
    margin-top:15px;
    padding:0 8px;
}

.search-container{
    width:100%;
    padding:6px;
    border-radius:35px;
}

.search-container input{
    padding:10px;
    font-size:14px;
}

.search-container button{
    padding:10px 15px;
    font-size:13px;
}

/* Heading */
.topic{
    font-size:30px;
    padding:0 15px;
}

.topic span{
    font-size:18px;
}

.topic::before,
.topic::after{
    display:none;
}

/* Categories */
.categories{
    padding:20px 10px;
    gap:15px;
}

.card{
    width:45%;
    text-align:center;
}

.card img{
    width:100%;
    max-width:150px;
    margin:auto;
}

.card span{
    position:static;
    display:block;
    margin-top:10px;
}

/* About */
.about{
    padding:50px 15px;
}

.about-content h2{
    font-size:28px;
}

.para{
    font-size:17px;
}

/* Testimonials */
.testimonials{
    margin:10px;
    padding:40px 15px;
    clip-path:none;
}

.test-container{
    flex-direction:column;
    align-items:center;
}

.test-card{
    width:90%;
    padding:25px;
}

/* Map */
iframe{
    width:100%;
    margin:0;
}

/* Footer */
.footer-row{
    flex-direction:column;
    gap:10px;
    text-align:center;
}
}
</style>
</head>

<body>

<!-- <?php
session_start();
?> -->

<!-- Navbar -->

<div class="navbar">
    <div class="logo"><img src="../../assests/img/logo.jpg" alt=""  class="logo-img">SecondHand-Bazaar</div>
    <div class="nav-links">
        <a href="../seller/sell_product.php"><button class="post-btn"><b>+ Sell</b></button></a>
        <a href="../auth/logout.php"><button class="register-btn"><b>Logout</b></button></a>
    </div>
</div>


<!-- Hero Section -->
<div class="hero">

    <div class="split-box">
        <img src="../../assests/img/hand1.jpg" class="img old">
        <img src="../../assests/img/hand2.jpg" class="img new">

        <div class="divider"></div>

        <div class="text">“One person’s waste = another’s value”</div>
    </div>
</div>

<div class="search-box">
    <form action="search_products.php" method="post" class="search-container">
        <span class="icon">🔍</span>
        <input type="text" placeholder="Find hidden gems..." name="search" required>
        <button type="submit">Search</button>
    </form>
</div>

<div class="topic">
    Explore Categories
    <span>Quality items waiting for a new home!</span>
</div>

<!-- Categories -->
<div class="categories">
    
    <div class="categories">

<?php
while($cat = mysqli_fetch_assoc($qcat))
{
?>

<a href="product_details.php?CAT_NAM=<?php echo urlencode($cat['CAT_NAM']); ?>" class="card">

<img src="../../assests/img/<?php echo $cat['CAT_IMAGE']; ?>">

<span><?php echo $cat['CAT_NAM']; ?></span>

</a>

<?php
}
?>

</div>

<section class="about">

    <div class="about-content">

        <h2>
            <span class="line"></span>
            ^^^About <span class="highlight">Our Story^^^</span>
        </h2>

        <p class="para">
At SecondHandBazaar, we don’t just sell used items — we give them a new beginning.
Every phone, every chair, every watch carries a story. A story of use, of memories,
of moments that mattered.
</p>

<p class="para">
But when those items are no longer needed, their journey doesn’t end.
That’s where we come in. We connect people who no longer need something
with those who are searching for it.
</p>

<p class="para">
What feels like “old” to one person becomes a valuable find for another.
A study table becomes someone’s workspace. A phone becomes someone’s first device.
A simple item turns into something meaningful again.
</p>

<p class="para">
We believe in smart choices, sustainable living, and giving value a second life.
Because nothing truly loses its worth — it just finds a new owner.
</p>

        <h3 class="tagline">♻️ Reuse • Resell • Rediscover</h3>
    </div>
</section>

<section class="testimonials">

    <h2 class="test-title">What Our Customers Say...</h2>

    <div class="test-container">

        <div class="test-card">
            <p>"I sold my old phone in minutes. Super easy and fast!"</p>
            <h4>- Riya M.</h4>
        </div>

        <div class="test-card">
            <p>"Found amazing furniture at half price. Totally worth it!"</p>
            <h4>- Arjun K.</h4>
        </div>

        <div class="test-card">
            <p>"This platform makes second-hand shopping feel premium."</p>
            <h4>- Neha S.</h4>
        </div>

    </div>

</section>

<div >
    <iframe 
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3694.3251612710204!2d69.61230677462833!3d21.6351467714225!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bebf6eebaaa7a23%3A0x7b07d7dd1fdfd12a!2sGovernment%20Polytechnic%20Porbandar!5e0!3m2!1sen!2sin!4v1708603509839!5m2!1sen!2sin">
    </iframe>
</div>

<footer class="footer-small">
    <div class="footer-row">
        <span>© 2026 SecondHand-Bazaar</span>
        <span>Privacy • Terms • Help</span>
    </div>
</footer>

 <script>
window.addEventListener("pageshow", function (event) {
    if (event.persisted) {
        document.querySelector(".search-container").reset();
    }
});
</script>

<script>
document.querySelectorAll('.card').forEach(card => {
    card.addEventListener('click', function(e) {
        e.preventDefault();

        const link = this.getAttribute('href');

        this.classList.add('burst');

        setTimeout(() => {
            this.classList.add('zooming');
        }, 150);

        setTimeout(() => {
            window.location.href = link;
        }, 600);
    });
});

/* 🔥 RESET WHEN USER COMES BACK */
window.addEventListener("pageshow", function () {
    document.querySelectorAll('.card').forEach(card => {
        card.classList.remove('zooming');
        card.classList.remove('burst');
    });
});
</script>

</body>
</html>