<?php

include '../backend/connect.php';

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING); 
   $pass = sha1($_POST['password']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING); 

   $select_admins = $conn->prepare("SELECT * FROM `admins` WHERE name = ? AND password = ? LIMIT 1");
   $select_admins->execute([$name, $pass]);
   $row = $select_admins->fetch(PDO::FETCH_ASSOC);

   if($select_admins->rowCount() > 0){
      setcookie('admin_id', $row['id'], time() + 60*60*24*30, '/');
      header('location:dashboard.php');
   }else{
      $warning_msg[] = 'Incorrect username or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>

<style>
/* General Body Styling */
body {
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
    box-sizing: border-box;
}

/* Form Container */
.form-container {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
    width: 100%;
}

/* Form Styling */
form {
    background: #fff;
    padding: 50px 40px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 450px;
    text-align: center;
    transition: all 0.3s ease-in-out;
    margin: 0 20px; /* Margin for responsiveness */
}

form:hover {
    transform: translateY(-10px);
}

/* Heading Styling */
form h3 {
    font-size: 32px;
    color: #444;
    margin-bottom: 30px;
    font-weight: 700;
}

/* Paragraph and Span Styling */
form p {
    font-size: 15px;
    color: #666;
    margin-bottom: 20px;
    line-height: 1.5;
}

form span {
    font-weight: bold;
    color: #ff6f61;
}

/* Input Field Styling */
.box {
    width: 100%;
    padding: 15px;
    margin-bottom: 25px; /* Increased margin for more spacing */
    border-radius: 30px;
    border: 1px solid #ddd;
    background: #f9f9f9;
    font-size: 16px;
    color: #333;
    transition: border-color 0.3s, box-shadow 0.3s;
}

.box:focus {
    outline: none;
    border-color: #ff6f61;
    box-shadow: 0 0 8px rgba(255, 111, 97, 0.5);
}

/* Button Styling */
.btn {
    width: 100%;
    padding: 15px;
    margin-top: 10px; /* Added spacing above the button */
    border-radius: 30px;
    background: linear-gradient(135deg, #ff6f61, #ff9a9e);
    color: #fff;
    border: none;
    font-size: 18px;
    cursor: pointer;
    transition: background 0.3s ease-in-out;
}

.btn:hover {
    background: linear-gradient(135deg, #ff9a9e, #ff6f61);
}

/* Link Styling */
form a {
    color: #ff6f61;
    text-decoration: none;
    font-weight: 600;
}

form a:hover {
    text-decoration: underline;
}

/* Extra Paragraph Styling */
form p:last-of-type {
    margin-top: 20px;
    color: #666;
}

/* Responsive Design Adjustments */
@media (max-width: 768px) {
    form {
        padding: 30px;
        margin: 0 10px;
    }
    
    form h3 {
        font-size: 28px;
    }
    
    .box, .btn {
        padding: 12px;
        font-size: 15px;
    }
    
    .btn {
        font-size: 16px;
    }
}

@media (max-width: 480px) {
    form {
        padding: 20px;
    }
    
    form h3 {
        font-size: 24px;
    }
    
    .box, .btn {
        padding: 10px;
        font-size: 14px;
    }
}

</style>
<body>

<!-- login section starts  -->
<section class="form-container">
   <form action="" method="POST">
      <h3>Welcome Back!</h3>
      <p>Default name = <span>admin</span> & password = <span>111</span></p>
      
      <input type="text" name="name" placeholder="Enter username" maxlength="20" class="box" required oninput="this.value = this.value.replace(/\s/g, '')">
      
      <input type="password" name="password" placeholder="Enter password" maxlength="20" class="box" required oninput="this.value = this.value.replace(/\s/g, '')">
      
      <input type="submit" value="Login Now" name="submit" class="btn">
      
      <p>Don't have an account? <a href="#">Sign up</a></p>
   </form>
</section>

</body>


<!-- login section ends -->


















<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include '../components/message.php'; ?>

</body>
</html>