<?php
session_start();
include "../../config/db.php";

if(!isset($_SESSION['sid']))
{
    header("Location:../../index.php");
    exit();
}

$cid = $_SESSION['sid'];
$icode = $_GET['I_CODE'];
$cat = $_GET['CAT_NAM'] ?? '';

if($icode=="")
{
    die("Item Code Missing");
}

/* Check if item already exists in cart */

$q = "SELECT * FROM cart WHERE C_ID='$cid' AND I_CODE='$icode'";
$rs = mysqli_query($con,$q);

if(mysqli_num_rows($rs)>0)
{
    mysqli_query($con,"UPDATE cart SET QTY=QTY+1 WHERE C_ID='$cid' AND I_CODE='$icode'");
}
else
{
    mysqli_query($con,"INSERT INTO cart(C_ID,I_CODE,QTY) VALUES('$cid','$icode',1)");
}


header("Location:product_details.php?CAT_NAM=".urlencode($cat));
exit();
?>