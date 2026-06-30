<?php
session_start();
include "../config/db.php";

/* ================= ADD CATEGORY ================= */

if(isset($_POST['add_category']))
{
    $cat = strtoupper(trim($_POST['cat_name']));

    $image = $_FILES['cat_image']['name'];
    $tmp   = $_FILES['cat_image']['tmp_name'];

    move_uploaded_file($tmp,"../assests/img/".$image);

    mysqli_query($con,"INSERT INTO category(CAT_NAM,CAT_IMAGE)
    VALUES('$cat','$image')");

    header("Location:admin_dashboard.php");
    exit();
}

/* ================= DELETE CATEGORY ================= */

if(isset($_GET['delete']))
{
    $id=$_GET['delete'];

    mysqli_query($con,"DELETE FROM category WHERE CAT_ID='$id'");

    header("Location:admin_dashboard.php");
    exit();
}

/* ================= UPDATE CATEGORY ================= */

if(isset($_POST['update_category']))
{
    $id=$_POST['id'];

    $cat=strtoupper(trim($_POST['cat_name']));

    if($_FILES['cat_image']['name']!="")
    {
        $image=$_FILES['cat_image']['name'];

        move_uploaded_file($_FILES['cat_image']['tmp_name'],
        "../assests/img/".$image);

        mysqli_query($con,"
        UPDATE category
        SET CAT_NAM='$cat',
            CAT_IMAGE='$image'
        WHERE CAT_ID='$id'");
    }
    else
    {
        mysqli_query($con,"
        UPDATE category
        SET CAT_NAM='$cat'
        WHERE CAT_ID='$id'");
    }

    header("Location:admin_dashboard.php");
    exit();
}
?>