<?php
session_start();
include "../../config/db.php";

$xcid=$_POST['icode'];
//echo $xcid;
print_r($_FILES);
$fname=$_FILES['f1']['name'];
$tmp_nam=$_FILES['f1']['tmp_name'];
if(move_uploaded_file($tmp_nam,$fname))
    {
        $q3="UPDATE item SET I_IMAGE='$fname' WHERE I_CODE='$xcid'";
        $r = mysqli_query($con,$q3);

        $x = mysqli_affected_rows($con);

        if($x > 0)
         echo "<script>alert('ITEM INSERTED SUCCESFULLY'); window.location='../buyer/dashboard.php';</script>";
        else
            echo "<script>alert('OPPS! ITEM NOT INSERTED'); window.location='../buyer/dashboard.php';</script>";
    }
else
    {
        echo "sorry";
    }

mysqli_close($con);


?>
