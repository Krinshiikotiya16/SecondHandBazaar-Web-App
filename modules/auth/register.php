<?php
session_start();
include "../../config/db.php";

error_reporting(E_ALL);
ini_set('display_errors',1);


$name= $email= $mobile=$password=$cpassword="";
$nmErr= $semailErr= $mobErr=$spassErr=$cpassErr="" ;
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    
$hasError = false;

$name = trim($_POST['name'] ?? "");
$email = trim($_POST['email'] ?? "");
$mobile = trim($_POST['mobile'] ?? "");
$password = $_POST['password'] ?? "";
$cpassword = $_POST['confirm_password'] ?? "";


/* NAME */
if(empty($name))
{
    $_SESSION['nmErr'] = "Name is required!";
    $hasError = true;
}
elseif(!preg_match("/^[A-Za-z]+\s+[A-Za-z]+\s+[A-Za-z]+$/", $name))
{
    $_SESSION['nmErr'] = "Enter first middle and last name!";
    $hasError = true;
}

/* EMAIL */
if(empty($email))
{
    $_SESSION['semailErr'] = "Email is required!";
    $hasError = true;
}
elseif(!preg_match("/^[\w\.-]+@[\w\.-]+\.\w+$/", $email))
{
    $_SESSION['semailErr'] = "Invalid Email format!";
    $hasError = true;
}

/* MOBILE */
if(empty($mobile))
{
    $_SESSION['mobErr'] = "Mobile Number is required!";
    $hasError = true;
}
elseif(!preg_match("/^[6-9]\d{9}$/", $mobile))
{
    $_SESSION['mobErr'] = "Invalid Phone Number!";
    $hasError = true;
}

/* PASSWORD */
if(empty($password))
{
    $_SESSION['spassErr'] = "Password is required!";
    $hasError = true;
}
elseif(!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/", $password))
{
    $_SESSION['spassErr'] = "Strong password needed!";
    $hasError = true;
}

/* CONFIRM PASSWORD */
if(empty($cpassword))
{
    $_SESSION['cpassErr'] = "Confirm Password is required!";
    $hasError = true;
}
elseif($password != $cpassword)
{
    $_SESSION['cpassErr'] = "Passwords do not match!";
    $hasError = true;
}

if($hasError)
{
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
    $_SESSION['mobile'] = $mobile;

    $_SESSION['show_signup'] = true;

    header("Location: ../../index.php");
    exit();
}

}
  

/* CHECK SAME EMAIL */
$check = "SELECT * FROM client WHERE C_EMAIL='$email'";
$result = mysqli_query($con,$check);

if(mysqli_num_rows($result) > 0)
{
    echo "<script>alert('Email already exists'); window.location='../../index.php';</script>";
}
else
{
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $Q = "INSERT INTO client (C_ID,C_NAME,C_PASS,C_EMAIL,C_MOB)VALUES(NULL,'$name','$hashedPassword','$email','$mobile')";

    $r = mysqli_query($con,$Q);

    $x = mysqli_affected_rows($con);

    if($x > 0)
    {
        $_POST['send'] = true;
    $_POST['fname'] = $name;
    $_POST['toemail'] = $email;
    $_POST['subject'] = "Registration Successful";
    $_POST['message'] = "
        Dear $name,<br><br>
        Your registration is successful 🎉<br>
        Welcome to our website.<br><br>
        Thank you!
    ";

    
    include '../../includes/mail.php';
    header("Location: registration_success.html");
    }
    else
    {
        echo "<script>alert('OPPS! REGISTRATION FAILED'); window.location='../../index.php';</script>";
    }
}

mysqli_close($con);
?>