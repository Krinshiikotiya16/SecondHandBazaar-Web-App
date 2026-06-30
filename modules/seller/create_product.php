<?php
session_start();
include "../../config/db.php";

$xiname=$_POST['iname'];
$xcat=$_POST['category'];
$xdes=$_POST['description'];
$xprice=$_POST['price'];
$xcid=$_SESSION['sid'];
$xdate=date('d-m-Y');
//echo $xcid;
//echo $xdate;
//echo $xiname;


$Q = "INSERT INTO item VALUES(NULL,$xcid,'$xcat','$xiname','-','$xdate',$xprice,'N','$xdes')";

$r = mysqli_query($con,$Q);


$x = mysqli_affected_rows($con);

if($x > 0)
{
     header("Location:upload_product.php");
}
else
{
    echo "<script>alert('OPPS! ITEM NOT INSERTED'); window.location='../auth/login.php';</script>";
}
?>
