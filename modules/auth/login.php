<?php
session_start();
include "../../config/db.php";

$xemail = $_POST['email'] ?? "";
$xpass  = $_POST['pass'] ?? "";


/* EMPTY CHECK */
if(empty($xemail))
{
    $_SESSION['emailErr'] = "Email is required!";
    header("Location: ../../index.php");
    exit();
}

if(empty($xpass))
{
    $_SESSION['passErr'] = "Password is required!";
    header("Location: ../../index.php");
    exit();
}

/* EMAIL FORMAT CHECK */
if(!preg_match("/^[\w\.-]+@[\w\.-]+\.\w+$/", $xemail))
{
    $_SESSION['emailErr'] = "Invalid Email format!";
    header("Location: ../../index.php");
    exit();
}
$captcha = $_POST['g-recaptcha-response'] ?? '';

if(empty($captcha))
{
    $_SESSION['captchaErr'] = "Please verify reCAPTCHA!";
    header("Location:../../index.php");
    exit();
}



$q = "SELECT * FROM client WHERE C_EMAIL='$xemail'";
$rs = mysqli_query($con,$q);

if(mysqli_num_rows($rs) > 0)
{
    $row = mysqli_fetch_array($rs);

    if(password_verify($xpass, $row['C_PASS']))
    {
        $_SESSION["semail"] = $xemail;
        $_SESSION["sname"]  = $row['C_NAME'];
        $_SESSION["sid"]    = $row['C_ID'];

        header("Location: ../buyer/dashboard.php");
        exit();
    }
    else
    {
        $_SESSION['passErr'] = "Invalid Email or Password!";
        header("Location: ../../index.php");
        exit();
    }
}
else
{
    $_SESSION['passErr'] = "Invalid Email or Password!";
    header("Location: ../../index.php");
    exit();
}
mysqli_close($con);
?>