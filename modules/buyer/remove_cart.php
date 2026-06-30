<?php
session_start();
include "../../config/db.php";

$id = $_GET['id'];

mysqli_query($con,"DELETE FROM cart WHERE CART_ID='$id'");

header("Location: cart.php");
exit();
?>