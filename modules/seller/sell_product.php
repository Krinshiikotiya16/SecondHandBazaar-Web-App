<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>sell part 1</title>
<style>
/* BODY */
body {
background: url("../../assests/img/sell.jpg") no-repeat center center;
    background-size: cover;
    min-height: 100vh;
    font-family: 'Poppins', sans-serif;
    margin: 0;
    
}

/* HEADER */
.header {
    text-align: center;
    margin-top: 40px;
    animation: fadeDown 0.8s ease;
}

.header h1 {
    margin: 0;
    font-size: 32px;
    color: #d0f7ad;
}

.header p {
    color: #e9dcdcb5;
    font-size: 14px;
}

/* STEPS */
.steps {
    display: flex;
    justify-content: center;
    margin: 25px 0;
    gap: 15px;
}

.step {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #e0e0e0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    transition: 0.3s;
}

.step.active {
    background: linear-gradient(135deg, #ff3f6c, #ff7a7a);
    color: white;
    box-shadow: 0 4px 10px rgba(255,63,108,0.4);
}

/* CARD */

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

    animation: fadeUp 0.8s ease;
}

/* FORM */
.form-group {
    margin-bottom: 20px;
}

label {
    font-weight: 600;
    color: #333;
}

/* INPUTS */
input, select, textarea {
    width: 100%;
    padding: 12px;
    margin-top: 8px;

    border-radius: 10px;
    border: 1px solid #ddd;
    font-size: 14px;

    transition: all 0.3s ease;
    outline: none;
    background: #fafafa;
}

/* FOCUS EFFECT */
input:focus, select:focus, textarea:focus {
    border-color: #ff3f6c;
    background: white;
    box-shadow: 0 0 8px rgba(255,63,108,0.2);
}

/* TEXTAREA */
textarea {
    height: 110px;
    resize: none;
}

/* ROW */
.row {
    display: flex;
    gap: 30px;
}

.row .form-group {
    flex: 1;
}

/* BUTTON */
.btn {
    background: linear-gradient(135deg, #ff3f6c, #ff7a7a);
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 12px;

    cursor: pointer;
    float: right;

    transition: 0.3s;
    font-weight: bold;
}

/* BUTTON HOVER */
.btn:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 20px rgba(255,63,108,0.3);
}

/* ANIMATIONS */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fadeDown {
    from { opacity: 0; transform: translateY(-30px); }
    to { opacity: 1; transform: translateY(0); }
}

/* MOBILE */
@media (max-width: 768px) {
    .card {
        width: 90%;
        padding: 25px;
    }

    .row {
        flex-direction: column;
    }
}
@media (max-width: 768px) {

    .card{
        width: 92%;
        padding: 20px;
        box-sizing: border-box;
    }

    .row{
        flex-direction: column;
        gap: 0;
    }

    input,
    select,
    textarea{
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    .btn{
        float: none;
        width: 100%;
        margin-top: 10px;
        display: block;
    }
}

</style>
</head>
<body>
<div class="header">
    <h1>Got stuff? Sell it here!</h1>

    <p>“Out with the old, in with the cash".</p>
</div>

<div class="steps">
    <div class="step active">1</div>
    <div class="step">2</div>
</div>

<div class="card">
    <h2>What are you selling?</h2>

    <form method="POST" action="create_product.php">

        <div class="form-group">
            <label>Item Name*</label>
            <input type="text" name="iname" placeholder="e.g., iPhone 15 Pro Max 256GB - Like New" required>
        </div>

        <div class="form-group">
            <label>Category *</label>
            <select name="category"  required>
            <option  value="" selected disabled>Select main category</option>
            <?php
            include "../../config/db.php";
            
            $q="select * from category order by CAT_NAM";
            $rs=mysqli_query($con,$q);
             while($row=mysqli_fetch_array($rs))
                {
                    echo "<option>".$row[0]."</option>";
                }
            mysqli_close($con);
            ?>
            </select>
        </div>

        <div class="form-group">
            <label>Description *</label>
            <textarea name="description" placeholder="Describe your item in detail..."  required></textarea>
        </div>

        <div class="row">
            <div class="form-group" required>
                <label>Price</label>
                <input type="number" name="price" min="1" required>
            </div>

            <div class="form-group">
                <label>Currency</label>
                <select name="currency"  required>
                    <option>INR (₹)</option>
                    <option>USD ($)</option>
                </select>
            </div>
        </div>

        <button class="btn">Continue</button>

    </form>
</div>

</body>
</html>