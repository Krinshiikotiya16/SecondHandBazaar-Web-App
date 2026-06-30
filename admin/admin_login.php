<?php
session_start();
//include "../config/db.php";

// If already logged in, redirect to dashboard
if(isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_dashboard.php");
    exit();
}

// Hardcoded admin credentials (you should update these)
$ADMIN_EMAIL = "krinshii@gmail.com";
$ADMIN_PASSWORD = "k123"; // Change this to a secure password

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if($email === $ADMIN_EMAIL && $password === $ADMIN_PASSWORD) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_email'] = $email;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #BC8F8F;
            --secondary: #DEB887;
            --accent: #ff3f6c;
            --dark: #2f261e;
            --light: #f5f5f5;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1e1e2e 0%, #2d2d3d 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            max-width: 900px;
            width: 100%;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            animation: slideIn 0.6s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* LEFT SIDE - LOGIN FORM */
        .login-section {
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-section h1 {
            font-size: 28px;
            color: var(--dark);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .login-section p {
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: var(--dark);
            font-weight: 600;
            font-size: 14px;
        }

        input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #eee;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
            font-family: inherit;
        }

        input:focus {
            outline: none;
            border-color: var(--primary);
            background: #f9f9f9;
            box-shadow: 0 0 0 3px rgba(188, 143, 143, 0.1);
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
            font-size: 15px;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(188, 143, 143, 0.3);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .error-message {
            background: #fee2e2;
            color: #dc2626;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #dc2626;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: shake 0.5s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .forgot-password {
            text-align: center;
            margin-top: 15px;
        }

        .forgot-password a {
            color: var(--primary);
            text-decoration: none;
            font-size: 13px;
            transition: 0.3s;
        }

        .forgot-password a:hover {
            color: var(--accent);
        }

        /* RIGHT SIDE - INFO */
        .info-section {
            background: linear-gradient(135deg, var(--secondary) 0%, var(--primary) 100%);
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
        }

        .info-icon {
            font-size: 64px;
            margin-bottom: 20px;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .info-section h2 {
            font-size: 24px;
            margin-bottom: 15px;
        }

        .info-section p {
            line-height: 1.6;
            opacity: 0.9;
            margin-bottom: 20px;
        }

        .features {
            text-align: left;
            margin-top: 30px;
        }

        .feature {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            margin-bottom: 15px;
            opacity: 0.9;
        }

        .feature i {
            margin-top: 3px;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
            }

            .info-section {
                display: none;
            }

            .login-section {
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- LOGIN FORM -->
        <div class="login-section">
            <h1><i class="fas fa-lock"></i> Admin Login</h1>
            <p>Access the control panel to manage orders and items</p>

            <?php if(isset($error)): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="Enter your email"
                        required
                        autofocus
                        autocomplete="new-email"
                    >
                </div>

                <div class="form-group">
                    <label for="password"><i class="fas fa-key"></i> Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="Enter your password"
                        autocomplete="new-password"
                        required
                    >
                </div>

                <button type="submit" class="login-btn">
                    <i class="fas fa-sign-in-alt"></i> Login to Dashboard
                </button>
            </form>

            <div class="forgot-password">
                <a href="../index.php"><i class="fas fa-question-circle"></i>USER LOGIN</a>
            </div>
        </div>

        <!-- INFO SECTION -->
        <div class="info-section">
            <div class="info-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <h2>Admin Dashboard</h2>
            <p>Manage your marketplace with powerful insights and analytics</p>

            <div class="features">
                <div class="feature">
                    <i class="fas fa-check-circle"></i>
                    <span>Track all orders in real-time</span>
                </div>
                <div class="feature">
                    <i class="fas fa-check-circle"></i>
                    <span>Monitor sold items statistics</span>
                </div>
                <div class="feature">
                    <i class="fas fa-check-circle"></i>
                    <span>View top sellers performance</span>
                </div>
                <div class="feature">
                    <i class="fas fa-check-circle"></i>
                    <span>Analyze category insights</span>
                </div>
                <div class="feature">
                    <i class="fas fa-check-circle"></i>
                    <span>Revenue analytics & reports</span>
                </div>
            </div>
        </div>
    </div>

</body>
</html>