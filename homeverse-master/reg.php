<?php

include './backend/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

if(isset($_POST['submit'])){

   $id = create_unique_id();
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING); 
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['password']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING); 
   $c_pass = sha1($_POST['confirm_password']);
   $c_pass = filter_var($c_pass, FILTER_SANITIZE_STRING);   

   $select_users = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_users->execute([$email]);

   if($select_users->rowCount() > 0){
      $warning_msg[] = 'email already taken!';
   }else{
      if($pass != $c_pass){
         $warning_msg[] = 'Password not matched!';
      }else{
         $insert_user = $conn->prepare("INSERT INTO `users`(id, name, number, email, address, password) VALUES(?,?,?,?,?,?)");
         $insert_user->execute([$id, $name, $number, $email,$address, $c_pass]);
         
         if($insert_user){
            $verify_users = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? LIMIT 1");
            $verify_users->execute([$email, $pass]);
            $row = $verify_users->fetch(PDO::FETCH_ASSOC);
         
            if($verify_users->rowCount() > 0){
               setcookie('user_id', $row['id'], time() + 60*60*24*30, '/');
               header('location:login.php');
            }else{
               $error_msg[] = 'something went wrong!';
            }
         }

      }
   }

}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>House_Hunt - Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="./assets/css/reg.css">
</head>

<body>
    <div class="container">
        <form action="" method="post">
            <div id="reg">Register</div>
            <div>
                <input type="text" name="name" placeholder="Username" required maxlength="50">
                <i class='bx bxs-user'></i>
            </div>
            <div>
                <input type="number" name="number" placeholder="Phone" max="9999999999" maxlength="10">
                <i class='bx bxs-phone'></i>
            </div>
            <div>
                <input type="email" name="email" placeholder="Mail" required maxlength="50">
                <i class='bx bxl-gmail'></i>
            </div>
            <div>
                <input type="text" name="address" placeholder="Address" required maxlength="100">
                <i class='bx bxs-map'></i>
            </div>
            <div>
                <input type="password" name="password" placeholder="Password" required maxlength="50">
                <i class='bx bxs-lock-open-alt'></i>
            </div>
            <div>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required maxlength="50">
                <i class='bx bxs-lock-alt'></i>
            </div>
            <button type="submit" name="submit">Create Account</button>
            <div id="msg">Already have an account? <a href="login.php">Sign in</a></div>
        </form>
        
    </div>
</body>

<script src="./assets/js/script.js"></script>

</html>