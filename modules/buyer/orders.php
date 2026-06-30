<?php
session_start();
include "../../config/db.php";

$xbcid = $_SESSION['sid'];//buyerid
$xbcid = $_SESSION['sid'];
$dt = date('d-m-Y');

$totalAmount = 0;
$itemDetails = "";

/* ALL CART ITEMS */
$q = "SELECT cart.QTY,
             item.*
      FROM cart
      INNER JOIN item
      ON cart.I_CODE=item.I_CODE
      WHERE cart.C_ID='$xbcid'
      AND item.SELL_STATUS='N'";

$rs = mysqli_query($con,$q);

while($row=mysqli_fetch_assoc($rs))
{

    $xicode = $row['I_CODE'];
    $xscid = $row['C_ID'];
    $xprice = $row['I_PRICE'];

    $totalAmount += $xprice;

    $itemDetails .= $row['I_NAME']." - ₹".$xprice."<br>";

    $q1 = "INSERT INTO orders
    VALUES(NULL,'$dt','$xbcid','$xscid','$xicode','$xprice','Razorpay')";

    mysqli_query($con,$q1);

    mysqli_query($con,
    "UPDATE item
    SET SELL_STATUS='Y'
    WHERE I_CODE='$xicode'");

}
if(mysqli_affected_rows($con)>0)
    {
        $q3="UPDATE item SET SELL_STATUS='Y' WHERE I_CODE='$xicode'";
        $rs=mysqli_query($con,$q3);
        if(mysqli_affected_rows($con)>0){
              $qmail = "SELECT * FROM client WHERE C_ID='$xbcid'";
        
        $rmail = mysqli_query($con,$qmail);

        $mailrow = mysqli_fetch_array($rmail);

        $name = $mailrow['C_NAME'];
        $email = $mailrow['C_EMAIL'];

        /* EMAIL SEND */
        $_POST['send'] = true;

        $_POST['fname'] = $name;

        $_POST['toemail'] = $email;

        $_POST['subject'] = "Order Successful";

        $_POST['message'] = "
            Dear $name,<br><br>

            Your transaction was completed successfully 🎉<br><br>

            <b>Order Details:</b><br><br>

            Purchased Items :

            $itemDetails
            <br>
            Total Amount :
            ₹ $totalAmount
            Payment Method : Razorpay <br>
            Order Date : $dt <br><br>

            Thank you for shopping with us ❤️
        ";

        include "../../includes/mail.php";

            echo "<script>alert('TRANSACTION SUCESSFULLY'); window.location='dashboard.php';</script>";
        }
        else
            {
                echo "<script>alert('OPPS! TRANSACTION FAILED'); window.location='product_details.php';</script>";
            }
        
    }
else 
    {
        echo "sorry";
    }
mysqli_close($con);
//incomplete
?>
