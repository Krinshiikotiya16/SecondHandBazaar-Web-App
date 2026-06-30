<?php
include "../../config/db.php";


// Get form data
$email = $_POST['email'];
$newpass = $_POST['newpass'];


// Check if email exists
$q1 = "SELECT * FROM client WHERE C_EMAIL='$email'";
$r1 = mysqli_query($con,$q1);

if(mysqli_num_rows($r1) > 0)
{
    // Update password
    $hash = password_hash($newpass, PASSWORD_DEFAULT);

$q2 = "UPDATE client SET C_PASS='$hash' WHERE C_EMAIL='$email'";
    $r2 = mysqli_query($con,$q2);
    if(mysqli_affected_rows($con) > 0)
    {
        echo "<script>alert('Password Updated Successfully'); window.location='../../index.php';</script>";
    }
    else
    {
        echo "<script>alert('Error updating password'); </script>";
    }
}
else
{
    echo "<script>alert('Email not found');window.location='../../index.php';</script>";
}

mysqli_close($con);
?>