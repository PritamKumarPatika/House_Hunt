<?php
include './backend/connect.php';

session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('location:login.php');  
    exit();
}

$user_id = $_SESSION['user_id'];  

// Fetch the user from the database
$select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ? LIMIT 1");
$select_user->execute([$user_id]);
$fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

// Handle form submission for password update
if (isset($_POST['submit'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $new_pass = filter_var($_POST['new_pass'], FILTER_SANITIZE_STRING);
    $c_pass = filter_var($_POST['c_pass'], FILTER_SANITIZE_STRING);

    // Validate if the entered email exists
    $verify_email = $conn->prepare("SELECT email FROM `users` WHERE email = ?");
    $verify_email->execute([$email]);
    
    if ($verify_email->rowCount() == 0) {
        $warning_msg[] = 'This email is not registered!';
    } else {
        // Email is valid, now check password fields
        if (!empty($new_pass) && !empty($c_pass)) {
            if ($new_pass != $c_pass) {
                $warning_msg[] = 'Passwords do not match!';
            } else {
                $hashed_pass = password_hash($new_pass, PASSWORD_BCRYPT);
                $update_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE email = ?");
                $update_pass->execute([$hashed_pass, $email]);
                $success_msg[] = 'Password updated successfully!';
            }
        } else {
            $warning_msg[] = 'Please enter both new password and confirmation password!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>House Hunt - Forgot Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="./assets/css/login.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background: #fff;
            padding: 40px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .form-container h3 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }
        .form-container input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }
        .form-container input:focus {
            outline: none;
            border-color: #007BFF;
        }
        .form-container .btn {
            background-color: #007BFF;
            color: white;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .form-container .btn:hover {
            background-color: #0056b3;
        }
        .form-container .msg {
            font-size: 14px;
            color: #555;
            margin-top: 20px;
        }
        .form-container .msg a {
            color: #007BFF;
            text-decoration: none;
        }
        .form-container .msg a:hover {
            text-decoration: underline;
        }
        .form-container a {
            display: inline-block;
            margin-top: 15px;
            font-size: 14px;
            color: #007BFF;
            text-decoration: none;
            transition: color 0.3s;
        }
        .form-container a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>

<section class="form-container">
    <form action="" method="post">
        <h3>Forgot Password!</h3>

        <!-- Email input to validate if the email exists -->
        <input type="email" name="email" maxlength="50" placeholder="Enter your registered email" class="box" required>

        <!-- New password input -->
        <input type="password" name="new_pass" maxlength="20" placeholder="Enter your new password" class="box" required>

        <!-- Confirm new password input -->
        <input type="password" name="c_pass" maxlength="20" placeholder="Confirm your new password" class="box" required>

        <!-- Submit button -->
        <input type="submit" value="Update Now" name="submit" class="btn">

        <a href="login.php">click here to login</a>
    </form>
</section>


<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="./assets/js/script.js"></script>
<script src="https://unpkg.com/boxicons@2.1.3/dist/boxicons.js"></script>
<?php 
      include './components/message.php';
    ?>

</body>
</html>
