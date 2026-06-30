<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sell 2</title>
    <style>
        body {
           background: url("../../assests/img/sell.jpg") no-repeat center center;
    background-size: cover;
    min-height: 100vh;
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 20px;
            
        }

        .container {
            width: 700px;
            margin: 40px auto;
            text-align: center;
        }

        h1 {
            margin-bottom: 5px;
            color: #d0f7ad;
        }

        .subtitle {
            color: gray;
            margin-bottom: 25px;
        }

        .steps {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 30px;
        }

        .circle {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            line-height: 35px;
            text-align: center;
            background: #ddd;
            color: black;
        }

        .active {
            background: linear-gradient(135deg, #ff3f6c, #ff7a7a);
            color: white;
        }

        .line {
            width: 50px;
            height: 3px;
            background: #ccc;
        }

        .line.active {
            background: linear-gradient(135deg, #ff3f6c, #ff7a7a);
        }

        .card {
            width: 60%;
            padding: 40px;
            margin: auto;
            border-radius: 25px;
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 10px 40px rgba(0,0,0,0.4);
            color: white;
        }

        .card h2 {
            margin-bottom: 30px;
        }

        input[type="file"] {
            margin-top: 15px;
            color: white;
        }

        .bottom {
            margin-top: 25px;
        }

        .next-btn {
            background: linear-gradient(135deg, #ff3f6c, #ff7a7a);
            color: white;
            padding: 12px 25px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .next-btn:hover {
            opacity: 0.9;
        }
        @media (max-width:768px){

    .container{
        width: 100%;
        margin: 20px auto;
    }

    .card{
        width: 95%;
        padding: 25px;
        box-sizing: border-box;
    }

    .steps{
        transform: scale(0.9);
    }

    .next-btn{
        width: 100%;
    }

}
    </style>
</head>

<body>

<?php
session_start();
include "../../config/db.php";

$q2 = 'select max(I_CODE) from item';
$rs = mysqli_query($con,$q2);

$xlastid = 0;

if(mysqli_num_rows($rs) > 0)
{
    $row = mysqli_fetch_array($rs);
    $xlastid = $row[0];
}

mysqli_close($con);
?>

<div class="container">

    <h1>Post Your Free Ad</h1>
    <div class="subtitle">Reach thousands of buyers in your area</div>

    <div class="steps">
        <div class="circle active">✓</div>
        <div class="line active"></div>
        <div class="circle active">2</div>
    </div>

    <div class="card">
        <h2>Upload Photos</h2>

        <!-- FORM START -->
        <form action="store_product.php" method="POST" enctype="multipart/form-data">

            <input type="hidden" name="icode" value="<?php echo $xlastid; ?>">

            <label>Select Image</label><br>
            <input type="file" name="f1" id="f1" required>

            <div class="bottom">
                <button class="next-btn" type="submit">Continue</button>
            </div>

        </form>
        <!-- FORM END -->

    </div>

</div>

</body>
</html>