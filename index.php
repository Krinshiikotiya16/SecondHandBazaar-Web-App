<?php
session_start();


$showSignup = false;

if(isset($_SESSION['show_signup']))
{
    $showSignup = true;
    unset($_SESSION['show_signup']);
}

/* LOGIN ERRORS */
$emailErr = $_SESSION['emailErr'] ?? "";
$passErr  = $_SESSION['passErr'] ?? "";
$xemail    = $_SESSION['xemail'] ?? "";

/* SIGNUP ERRORS */
$nmErr         = $_SESSION['nmErr'] ?? "";
$semailErr= $_SESSION['semailErr'] ?? "";
$mobErr        = $_SESSION['mobErr'] ?? "";
$spassErr = $_SESSION['spassErr'] ?? "";
$cpassErr      = $_SESSION['cpassErr'] ?? "";

/* SIGNUP VALUES */
$name   = $_SESSION['name'] ?? "";
$email  = $_SESSION['email'] ?? "";
$mobile = $_SESSION['mobile'] ?? "";
$password = $_SESSION['password'] ?? "";
$cpassword = $_SESSION['confirm_password'] ?? "";
$captchaErr = $_SESSION['captchaErr'] ?? "";

unset($_SESSION['captchaErr']);
unset($_SESSION['emailErr']);
unset($_SESSION['passErr']);
unset($_SESSION['xemail']);

unset($_SESSION['nmErr']);
unset($_SESSION['semailErr']);
unset($_SESSION['mobErr']);
unset($_SESSION['spassErr']);
unset($_SESSION['cpassErr']);

unset($_SESSION['name']);
unset($_SESSION['email']);
unset($_SESSION['mobile']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Second hand login form</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-plum: #BC8F8F; 
            --light-plum: #DEB887;
            --dark-bg: #BC8F8F;
        }
        
        body {
            background-color: var(--dark-bg);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden;
        }
        *{
    box-sizing:border-box;
}

        .container {
            background-color: #fcdede;
            border-radius: 20px;
            box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
            position: relative;
            overflow: hidden;
            width: 95%;
            max-width: 900px;
            min-height: 650px;
        }

         /* Left Decorative Panel */
    .left-panel {
    background: linear-gradient(135deg, var(--light-plum) 0%, var(--primary-plum) 100%);
    position: relative;
    z-index: 1;
    }

    /* Creating the diagonal geometric look */
    /* Creating the diagonal geometric look */
.overlay-shapes {
    position: absolute;
    top: 0; 
    left: 0; 
    width: 100%; 
    height: 100%;
    /* This creates the transparent grid/diagonal effect */
    background: linear-gradient(45deg, rgba(255,255,255,0.1) 25%, transparent 25%) -50px 0,
                linear-gradient(-45deg, rgba(255,255,255,0.1) 25%, transparent 25%) -50px 0;
    background-size: 100px 100px;
    z-index: 0; /* Sits behind the text but on the blue background */
    opacity: 0.3;
    pointer-events: none; /* Makes sure it doesn't block button clicks */
}

        /* --- FORM CONTAINERS --- */
        .form-container {
            position: absolute;
            top: 0;
            height: 100%;
            transition: all 0.6s ease-in-out;
        }

        .sign-in-container {
            left: 0;
            width: 50%;
            z-index: 2;
        }

        .sign-up-container {
            left: 0;
            width: 50%;
            opacity: 0;
            z-index: 1;
        }

        /* Movement Logic */
        .container.right-panel-active .sign-in-container {
            transform: translateX(100%);
        }

        .container.right-panel-active .sign-up-container {
            transform: translateX(100%);
            opacity: 1;
            z-index: 5;
            animation: show 0.6s;
        }

        @keyframes show {
            0%, 49.99% { opacity: 0; z-index: 1; }
            50%, 100% { opacity: 1; z-index: 5; }
        }

        /* --- OVERLAY SECTION (The Blue Box) --- */
        .overlay-container {
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition: transform 0.6s ease-in-out;
            z-index: 100;
        }

        .container.right-panel-active .overlay-container {
            transform: translateX(-100%);
        }

        .overlay {
            background: linear-gradient(135deg, var(--light-plum) 0%, var(--primary-plum) 100%);
            color: #f8dfdf;
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
        }

        .container.right-panel-active .overlay {
            transform: translateX(50%);
        }

        .overlay-panel {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 40px;
            text-align: center;
            top: 0;
            height: 100%;
            width: 50%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
        }

        .overlay-left { transform: translateX(-20%); }
        .container.right-panel-active .overlay-left { transform: translateX(0); }

        .overlay-right { right: 0; transform: translateX(0); }
        .container.right-panel-active .overlay-right { transform: translateX(20%); }

        /* --- STYLES FOR FORMS --- */
        form {
            background-color: #f7d8d8;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 50px;
            height: 100%;
            text-align: center;
        }

        .avatar-btn {
            width: 80px; height: 80px; border-radius: 50%;
            background: #eee; border: 4px solid var(--primary-plum);
            cursor: pointer; overflow: hidden; margin-bottom: 10px;
            transition: all 0.3s ease;

        }

        .avatar-btn:hover {
    transform: scale(1.08);
    box-shadow: 0 0 15px rgba(188, 143, 143, 0.6);
    border-color: #a06c6c;
}
        .avatar-btn img { width: 100%; height: auto; object-fit: cover; }

        input {
            background-color: #eee; border: none;
            padding: 10px 15px; margin: 8px 0; width: 100%;
            border-radius: 5px;
        }

        button {
            border-radius: 20px; border: 1px solid var(--primary-plum);
            background-color: var(--primary-plum); color: #FFFFFF;
            font-size: 12px; font-weight: bold; padding: 12px 45px;
            text-transform: uppercase; cursor: pointer; margin-top: 10px;
            transition: all 0.3s ease;
        }

        button:hover {
             background-color: #a06c6c; /* darker plum */
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
        }

        button.ghost { background-color: transparent; border-color: #FFFFFF;    transition: all 0.3s ease;
 }

 button.ghost:hover {
    background-color: #fff;
    color: var(--primary-plum);
}
        /* Modal Styles */
        .modal {
            display: none; position: fixed; z-index: 1000;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5); justify-content: center; align-items: center;
        }
        .modal-content { background: white; padding: 20px; border-radius: 15px; text-align: center; width: 320px; }
        .avatar-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-top: 10px; }
        .avatar-option { width: 70px; height: 70px; border-radius: 50%; cursor: pointer;     transition: all 0.3s ease;
 }
        .avatar-option:hover {
    transform: scale(1.15);
    border: 3px solid var(--primary-plum);
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
}
/* ================= MOBILE RESPONSIVE ================= */
    
@media (max-width:768px){

    body{
        height:auto;
        min-height:100vh;
        overflow-y:auto;
        padding:15px 0;
    }

    .container{
        width:95%;
        max-width:400px;
        min-height:auto;
    }

    .overlay-container{
        display:none;
    }

    .sign-in-container{
        position:relative;
        width:100%;
        opacity:1;
        z-index:5;
        transform:none !important;
    }

    .sign-up-container{
        display:none;
        position:relative;
        width:100%;
        opacity:1;
        z-index:5;
        transform:none !important;
    }

    .container.right-panel-active .sign-in-container{
        display:none;
    }

    .container.right-panel-active .sign-up-container{
        display:block;
    }

    form{
        padding:25px 20px;
    }

    button{
        width:100%;
    }
    
}
/* Your existing CSS */

/* Your mobile responsive CSS */
@media (max-width:768px){
   ...
}

/* ADD THIS BELOW EVERYTHING */

#mobileSignupBtn,
#mobileLoginBtn{
    display:none;
}

@media (max-width:768px){

    #mobileSignupBtn,
    #mobileLoginBtn{
        display:block;
        width:100%;
        margin-top:10px;
    }

}


    </style>
</head>
<body>

<div class="container <?php echo $showSignup ? 'right-panel-active' : ''; ?>" id="container">
    <div class="form-container sign-up-container">
        <form action="modules/auth/register.php" method="post">
            <div class="avatar-btn" onclick="openModal()">
            <input type="hidden" name="avatar" id="avatarInput">
                <img id="signup-pfp" src="assests/img/bit.webp">
            </div>
             <h1>Create Account</h1>

            <input type="text" name="name" placeholder="Name" value="<?php echo $name ?? ""; ?>" >
            <span style="color:red"><?php echo $nmErr ?? ""; ?></span>

                <input type="hidden" name="avatar" id="avatarInput">
    		    <input type="email" name="email" placeholder="Email" value="<?php echo $email ?? ""; ?>" autocomplete="new-email">
                <span style="color:red"><?php echo $semailErr ?? ""; ?></span>

    		    <input type="text" name="mobile" placeholder="Mobile no."  value="<?php echo $mobile ?? ""; ?>">
                <span style="color:red"><?php echo $mobErr ?? ""; ?></span>

    		    <input type="password" name="password" placeholder="Password"  autocomplete="new-password">
                <span style="color:red"><?php echo $spassErr ?? ""; ?></span>

    		    <input type="password" name="confirm_password" placeholder="Confirm Password" >
                <span style="color:red"><?php echo $cpassErr ?? ""; ?></span>
			
            <button>Sign Up</button>
            <button type="button" id="mobileLoginBtn">Back to Login
            </button>
            
        </form>
    </div>

    <div class="form-container sign-in-container">
        <form action="modules/auth/login.php" id="loginForm" method="POST" autocomplete="off"  >
            <h1 style="font-family: 'Orbitron', sans-serif;font-size:50px;font-weight:1000; margin-top :10px;">Login</h1>
            <span style="font-size: Comic Sans MS, cursive;">Good to see you. Let’s continue</span><br>

            <label></label>
            <input type="email" placeholder="Email" name="email"  value="<?php echo $xemail ?? ""; ?>"   autocomplete="new-email" required>
            <span style="color:red"><?php echo $emailErr ?? ""; ?></span>
            </label>

            <label ></label>
            <input type="password" placeholder="Password" name="pass" autocomplete="new-password">
            <span style="color:red"><?php echo $passErr ?? ""; ?></span>
            </label>
            <!--recaptcha -->
             <div class="g-recaptcha" data-sitekey="6LflnT8tAAAAAK71JEfUdiEDXiAzV162FxucU4Jz"></div>
            <span style="color:red"><?php echo $captchaErr ?? ""; ?></span>

            <a href="modules/auth/reset_password.html" style="text-decoration: none; margin-right: 170px; color: #BC8F8F;">Forgot your password?</a>
             <a href="admin/admin_login.php" style="text-decoration: none; margin-right: 230px; color: #BC8F8F;">ADMIN LOGIN</a>
            <button>Login</button>
            <button type="button" id="mobileSignupBtn">Create Account</button>
            
        </form>
    </div>

  <div class="overlay-container">
    <div class="overlay">
        <div class="overlay-shapes"></div> 

        <div class="overlay-panel overlay-left">
            <h1 style="font-family: Comic Sans MS, cursive;">Welcome Back!</h1>
            <p style="font-family: Comic Sans MS, cursive;">To keep connected with us please login with your personal info</p>
            <button class="ghost" id="signIn">Sign Up</button>
        </div>
        <div class="overlay-panel overlay-right">
            <h2 style="position: absolute; top: 20px; right: 20px; margin: 0;">Bazaar</h2>
            <h2 style="font-family: Comic Sans MS, cursive; margin-right: 130px;">Hello, fam!</h2>
            <img src="assests/img/login.png" style="height: 230px; width: 100%;">
            <p style="font-family: Comic Sans MS, cursive;">Enter your details to discover great deals on pre-loved items</p>
            <button class="ghost" id="signUp">Sign In</button>
        </div>
    </div>  
</div>
</div>

<div class="modal" id="avatarModal">
    <div class="modal-content">
        <h5>Select Avatar</h5>
        <div class="avatar-grid">
            <img class="avatar-option" src="assests/img/procreate cartoon character $ Generated by Bing Image Creator.jpeg" onclick="selectAvatar('assests/img/procreate cartoon character $ Generated by Bing Image Creator.jpeg')">
            <img class="avatar-option" src="assests/img/Avatar.jpeg" onclick="selectAvatar('assests/img/Avatar.jpeg')">
            <img class="avatar-option" src="assests/img/Glasses.jpeg" onclick="selectAvatar('assests/img/Glasses.jpeg')">
            <img class="avatar-option" src="assests/img/Custom Avatar Photo to Cartoon Portrait Custom Profile Picture Drawing Social Media Icon Illustration Hand Drawn Portrait Commission Art - Etsy.jpeg" onclick="selectAvatar('assests/img/Custom Avatar Photo to Cartoon Portrait Custom Profile Picture Drawing Social Media Icon Illustration Hand Drawn Portrait Commission Art - Etsy.jpeg')">
            <img class="avatar-option" src="assests/img/Animal Illustration - Cheng Peng 彭卡爆.jpeg" onclick="selectAvatar('assests/img/Animal Illustration - Cheng Peng 彭卡爆.jpeg')">
            <img class="avatar-option" src="assests/img/suita.jpeg" onclick="selectAvatar('assests/img/suita.jpeg')">
            <img class="avatar-option" src="assests/img/download (2).jpeg" onclick="selectAvatar('assests/img/download (2).jpeg')">
            <img class="avatar-option" src="assests/img/octopuss.png" onclick="selectAvatarselectAvatar('assests/img/octopuss.png')">
        </div>
        <button class="btn btn-sm btn-dark mt-3" onclick="closeModal()">Close</button>
    </div>
</div>

<script>
    const container = document.getElementById('container');
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const modal = document.getElementById('avatarModal');

    // Transitions
    signUpButton.addEventListener('click', () => {
        container.classList.add("right-panel-active");
    });

    signInButton.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
    });
//
    document.getElementById('mobileSignupBtn')?.addEventListener('click', () => {
    container.classList.add("right-panel-active");
});

document.getElementById('mobileLoginBtn')?.addEventListener('click', () => {
    container.classList.remove("right-panel-active");
});

    // Avatar Logic
    function openModal() { modal.style.display = 'flex'; }
    function closeModal() { modal.style.display = 'none'; }
    function selectAvatar(src) {
    document.getElementById('signup-pfp').src = src;

    // store in hidden input to send to PHP
    document.getElementById('avatarInput').value = src;

    closeModal();
}
</script>
 
<?php
if(isset($_SESSION['show_signup']))
{
    unset($_SESSION['show_signup']);
?>
<script>
window.onload = function() {
    document.getElementById('container').classList.add('right-panel-active');
};
</script>
<?php
}
?>
</body>
</html>