<?php
include ('./backend/connect.php');

if(isset($_COOKIE['user_id'])){
  $user_id = $_COOKIE['user_id'];
}else{
  $user_id = '';
}

if(isset($_POST['send'])){

  $msg_id = create_unique_id();
  $name = $_POST['name'];
  $name = filter_var($name, FILTER_SANITIZE_STRING);
  $email = $_POST['email'];
  $email = filter_var($email, FILTER_SANITIZE_STRING);
  $number = $_POST['number'];
  $number = filter_var($number, FILTER_SANITIZE_STRING);
  $message = $_POST['message'];
  $message = filter_var($message, FILTER_SANITIZE_STRING);

  $verify_contact = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
  $verify_contact->execute([$name, $email, $number, $message]);

  if($verify_contact->rowCount() > 0){
     $warning_msg[] = 'message sent already!';
  }else{
     $send_message = $conn->prepare("INSERT INTO `messages`(id, name, email, number, message) VALUES(?,?,?,?,?)");
     $send_message->execute([$msg_id, $name, $email, $number, $message]);
     $success_msg[] = 'message send successfully!';
  }

}

include './components/save_send.php';

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HouseHunt - Contact Page</title>
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">
  <link rel="stylesheet" href="./assets/css/style_copy.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&family=Poppins:wght@400;500;600;700&display=swap"
    rel="stylesheet">

    <style>
      /* Container styling */
      .message-container {
        padding: 40px 20px;
        color: #333;
        display: flex;
        justify-content: center;
        align-items: center;
      }

      .message-container .row {
        display: flex;
        flex-direction: row;
        gap: 30px;
        width: 90%;
        background-color: #f9f9f9;
        border-radius: 10px;
        padding: 20px;
      }

      .message-container .image img {
        max-width: 100%;
        border-radius: 8px;
        transition: transform 0.2s ease;
      }

      .message-container .image:hover img {
        transform: scale(1.02);
      }

      /* Form styling */
      .message-container form {
        flex: 1;
        padding: 20px;
      }

      .message-container form h3 {
        font-size: 24px;
        color: #333;
        margin-bottom: 15px;
        text-align: left;
        font-weight: 600;
      }

      .message-container form .box {
        width: 100%;
        margin-bottom: 12px;
        padding: 12px 16px;
        border-radius: 5px;
        border: 1px solid #ddd;
        font-size: 14px;
        color: #555;
        background-color: #fff;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
      }

      .message-container form .box:focus {
        border-color: #4a90e2;
        outline: none;
        box-shadow: 0 0 4px rgba(74, 144, 226, 0.2);
      }

      .message-container form .btn {
        width: 100%;
        padding: 12px 16px;
        background-color: #4a90e2;
        color: #fff;
        font-size: 16px;
        font-weight: 500;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.2s ease;
      }

      .message-container form .btn:hover {
        background-color: #3a78c0;
      }

      @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
      }

    </style>
</head>

<body>

  <?php include('./components/user_header.php') ?>

  <main>
    <div class="contact-hero-content"
      style="background-image: url('./assets/images/Bg-image.jpg'); height: 20em; background-repeat: no-repeat;">
      <div id="contact-hero-container">
        <h2>Contact Us</h2>
        <p class="contact-hero-subtitle">
          <ion-icon name="home"></ion-icon>
          <span><a href="index.html">Home</a></span>
          <ion-icon name="chevron-forward-outline"></ion-icon>
          <span>Contact Us</span>
        </p>
      </div>
    </div>

    <section class="message-container">

      <div class="row">
          
          <form action="" method="post">
            <h3>Get in touch!</h3>
            <input type="text" name="name" required maxlength="50" placeholder="enter your name" class="box">
            <input type="email" name="email" required maxlength="50" placeholder="enter your email" class="box">
            <input type="number" name="number" required maxlength="10" max="9999999999" min="0" placeholder="enter your number" class="box">
            <textarea name="message" placeholder="enter your message" required maxlength="1000" cols="30" rows="10" class="box"></textarea>
            <input type="submit" value="send message" name="send" class="btn">
          </form>
      </div>

    </section>


    <div class="contact-container">
      <div class="contact-card">
        <img src="./assets/images/mail.jpg" alt="Email Icon">
        <h3>Email Address</h3>
        <p><a href="mailto:info@househunt.com">info@househunt.com</a></p>
        <p><a href="mailto:help@househunt.com">help@househunt.com</a></p>
      </div>
      <div class="contact-card">
        <img src="./assets/images/call.png" alt="Phone Icon">
        <h3>Phone Number</h3>
        <p href="tel:+91 0123-456789">+91 0123-456789</p>
        <p>+91 987-6543210</p>
      </div>
      <div class="contact-card">
        <img src="./assets/images/whatsapp.png" alt="Address Icon">
        <h3>Whatsapp</h3>
        <p>+91 9438448522</p>
        <p>+91 9348661022</p>
      </div>
    </div>

  </main>

  <?php include('./components/footer.php') ?>
  
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const profileBtn = document.getElementById("profile-btn");
      const dropdownMenu = document.getElementById("profile-dropdown");

      // Toggle dropdown menu on button click
      profileBtn.addEventListener("click", function () {
        dropdownMenu.classList.toggle("active");
      });

      // Close dropdown if clicked outside
      document.addEventListener("click", function (e) {
        if (!profileBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
          dropdownMenu.classList.remove("active");
        }
      });
    });

    // search icon

    // Toggle search bar
    const searchBtn = document.getElementById('searchBtn');
    const searchBar = document.getElementById('searchBar');

    searchBtn.addEventListener('click', () => {
      searchBar.classList.toggle('active');
    });

    document.getElementById("signInBtn").addEventListener("click", function (event) {
      event.preventDefault(); // Prevent default anchor click behavior
      var dropdown = document.getElementById("dropdownMenu");
      dropdown.classList.toggle("show"); // Toggle the 'show' class
    });

    // Close the dropdown if clicked outside
    window.onclick = function (event) {
      if (!event.target.matches('#signInBtn')) {
        var dropdown = document.getElementById("dropdownMenu");
        if (dropdown.classList.contains('show')) {
          dropdown.classList.remove('show');
        }
      }
    }

  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <script src="./assets/js/script.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <?php include('./components/message.php') ?>
</body>

</html>