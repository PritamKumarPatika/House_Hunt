<?php

include './backend/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING); 
   $pass = sha1($_POST['password']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING); 

   $select_users = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? LIMIT 1");
   $select_users->execute([$email, $pass]);
   $row = $select_users->fetch(PDO::FETCH_ASSOC);

   if($select_users->rowCount() > 0){
      setcookie('user_id', $row['id'], time() + 60*60*24*30, '/');
      header('location:index.php');
   }else{
      $warning_msg[] = 'Incorrect username or password!';
   }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>House Hunt - Login_page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="./assets/css/login.css">
</head>
<body>
    <img src="./assets/images/login_hero.png" alt="">
    <div class="container">
        <div id="sign-up">Log In!</div>
        <div id="msg">
            
        </div>
        <form action="" method="post">
            <div class="inputs">
                <div class="group">
                    <svg stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="icon">
                        <path d="M4.5 6.75a2.25 2.25 0 012.25-2.25h10.5a2.25 2.25 0 012.25 2.25v10.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 17.25V6.75z" stroke-linejoin="round" stroke-linecap="round"></path>
                        <path d="M19.5 6.75L12 12 4.5 6.75" stroke-linejoin="round" stroke-linecap="round"></path>
                    </svg>
                    <input class="input" type="email" name="email" placeholder="Email" required maxlength="50">
                </div>
                
                <div class="group">
                    <svg stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="icon">
                        <path d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" stroke-linejoin="round" stroke-linecap="round"></path>
                    </svg>
                    <input class="input" type="password" name="password" placeholder="Password" required maxlength="20">
                </div>
            </div>
            <div id="acc">Don't have an account?
                <a href="forgot_password.php" class="tab-space">Forgot Password</a><br>
                <a href="reg.php" id="clk">Click here</a>
            </div>
            <button type="submit" id="login" class="button" name="submit">Login</button>
        </form>
    </div>
    <script src="./assets/js/script.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.3/dist/boxicons.js"></script>
    
</body>
</html>
