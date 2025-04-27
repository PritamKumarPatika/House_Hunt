<?php

include '../backend/connect.php';

if(isset($_COOKIE['admin_id'])){
   $admin_id = $_COOKIE['admin_id'];
}else{
   $admin_id = '';
   header('location:login.php');
}

if(isset($_GET['get_id'])){
   $get_id = $_GET['get_id'];
}else{
   $get_id = '';
   header('location:dashboard.php');
}

if(isset($_POST['delete'])){

   $delete_id = $_POST['delete_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_delete = $conn->prepare("SELECT * FROM `property` WHERE id = ?");
   $verify_delete->execute([$delete_id]);

   if($verify_delete->rowCount() > 0){
      $select_images = $conn->prepare("SELECT * FROM `property` WHERE id = ?");
      $select_images->execute([$delete_id]);
      while($fetch_images = $select_images->fetch(PDO::FETCH_ASSOC)){
         $image_01 = $fetch_images['image_01'];
         $image_02 = $fetch_images['image_02'];
         $image_03 = $fetch_images['image_03'];
         $image_04 = $fetch_images['image_04'];
         $image_05 = $fetch_images['image_05'];
         unlink('../upload-images/'.$image_01);
         if(!empty($image_02)){
            unlink('../upload-images/'.$image_02);
         }
         if(!empty($image_03)){
            unlink('../upload-images/'.$image_03);
         }
         if(!empty($image_04)){
            unlink('../upload-images/'.$image_04);
         }
         if(!empty($image_05)){
            unlink('../upload-images/'.$image_05);
         }
      }
      $delete_listings = $conn->prepare("DELETE FROM `property` WHERE id = ?");
      $delete_listings->execute([$delete_id]);
      $success_msg[] = 'Listing deleted!';
   }else{
      $warning_msg[] = 'Listing deleted already!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>property details</title>

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../assets/css/admin_style.css">

   <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

</head>
<body>
   
<!-- header section starts  -->
<?php include '../components/admin_header.php'; ?>
<!-- header section ends -->

    <section class="view-property">

        <h1 class="heading">property details</h1>

        <?php
            $select_properties = $conn->prepare("SELECT * FROM `property` WHERE id = ? ORDER BY date_listed DESC LIMIT 1");
            $select_properties->execute([$get_id]);
            if($select_properties->rowCount() > 0){
                while($fetch_property = $select_properties->fetch(PDO::FETCH_ASSOC)){

                $property_id = $fetch_property['id'];

                $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                $select_user->execute([$fetch_property['user_id']]);
                $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

        ?>
        <div class="details">
            <div class="swiper images-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="upload-images/<?= $fetch_property['image_01']; ?>" alt="">
                    </div>
                    <?php if(!empty($fetch_property['image_02'])){ ?>
                    <div class="swiper-slide">
                        <img src="upload-images/<?= $fetch_property['image_02']; ?>" alt="">
                    </div>
                    <?php } ?>
                    <?php if(!empty($fetch_property['image_03'])){ ?>
                    <div class="swiper-slide">
                        <img src="upload-images/<?= $fetch_property['image_03']; ?>" alt="">
                    </div>
                    <?php } ?>
                    <?php if(!empty($fetch_property['image_04'])){ ?>
                    <div class="swiper-slide">
                        <img src="upload-images/<?= $fetch_property['image_04']; ?>" alt="">
                    </div>
                    <?php } ?>
                    <?php if(!empty($fetch_property['image_05'])){ ?>
                    <div class="swiper-slide">
                        <img src="upload-images/<?= $fetch_property['image_05']; ?>" alt="">
                    </div>
                    <?php } ?>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
            <h3 class="name"><?= $fetch_property['title']; ?></h3>
            <p class="location"><i class="fas fa-map-marker-alt"></i><span><?= $fetch_property['address']; ?></span></p>
            <div class="info">
                <p><i class="fas fa-indian-rupee-sign"></i><span><?= $fetch_property['price']; ?></span></p>
                <p><i class="fas fa-user"></i><span><?= $fetch_user['name']; ?></span></p>
                <p><i class="fas fa-phone"></i><a href="tel:1234567890"><?= $fetch_user['number']; ?></a></p>
                <p><i class="fas fa-building"></i><span><?= $fetch_property['property_type']; ?></span></p>
                <p><i class="fas fa-house"></i><span><?= $fetch_property['offer']; ?></span></p>
                <p><i class="fas fa-calendar"></i><span><?= $fetch_property['date_listed']; ?></span></p>
            </div>

            <h3 class="title">Details</h3>
                <div class="flex">
                    <div class="box">
                        <p><i class="fas fa-bed"></i><span class="detail-label">Rooms:</span><span><?= $fetch_property['bhk']; ?> BHK</span></p>
                        <p><i class="fas fa-indian-rupee-sign"></i><span class="detail-label">Deposit Amount:</span><span><?= $fetch_property['price']; ?></span></p>
                        <p><i class="fas fa-info-circle"></i><span class="detail-label">Status:</span><span><?= $fetch_property['status']; ?></span></p>
                        <p><i class="fas fa-bed"></i><span class="detail-label">Bedrooms:</span><span><?= $fetch_property['bedrooms']; ?></span></p>
                        <p><i class="fas fa-bath"></i><span class="detail-label">Bathrooms:</span><span><?= $fetch_property['bathrooms']; ?></span></p>
                        <p><i class="fas fa-warehouse"></i><span class="detail-label">Basement:</span><span><?= $fetch_property['basement']; ?></span></p>
                    </div>
                    <div class="box">
                        <p><i class="fas fa-arrows-alt"></i><span class="detail-label">Carpet Area:</span><span><?= $fetch_property['size']; ?> sqft</span></p>
                        <p><i class="fas fa-calendar-alt"></i><span class="detail-label">Age:</span><span><?= $fetch_property['house_age']; ?> years</span></p>
                        <p><i class="fas fa-building"></i><span class="detail-label">Total Floors:</span><span><?= $fetch_property['floors']; ?></span></p>
                        <p><i class="fas fa-car"></i><span class="detail-label">Garages:</span><span><?= $fetch_property['garages']; ?></span></p>
                        <p><i class="fas fa-home"></i><span class="detail-label">Structure Type:</span><span><?= $fetch_property['structure_type']; ?></span></p>
                        <p><i class="fas fa-tag"></i><span class="detail-label">Custom ID:</span><span><?= $fetch_property['custom_id']; ?></span></p>
                    </div>
                </div>

                <h3 class="title">Amenities</h3>
                <div class="flex">
                    <div class="box">
                        <ul class="amenities-list">
                            <?php 
                                $amenities = json_decode($fetch_property['amenities'], true);
                                if (!empty($amenities)) {
                                    foreach ($amenities as $amenity) {
                                        echo '<li><i class="fas fa-check-circle"></i>' . htmlspecialchars($amenity) . '</li>'; // Adding an icon for each amenity
                                    }
                                } else {
                                    echo '<li>No amenities available</li>';
                                }
                            ?>
                        </ul>
                    </div>
                </div>


                
            </div>
            <h3 class="title">Description</h3>
            <p class="description"><?= nl2br(htmlspecialchars($fetch_property['description'])); ?></p>
        </div>
        <?php
            }
        }else{
            echo '<p class="empty">property not found! <a href="listing.php" style="margin-top:1.5rem;" class="btn">add new</a></p>';
        }
        ?>


</section>


















<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

<?php include '../components/message.php'; ?>

<script>


const swiper = new Swiper('.images-container', {
            slidesPerView: 1,
            spaceBetween: 10,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            loop: true, // Enable looping
            autoplay: {
                delay: 3000, // Autoplay delay
                disableOnInteraction: false, // Keep autoplay even after interaction
            },
        });

</script>

</body>
</html>