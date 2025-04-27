<?php  

include './backend/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
}

include './components/save_send.php';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>House_Hunt - Saved Page</title>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">

  <!-- 
    - custom css link
  -->
  <link rel="stylesheet" href="./assets/css/style_copy.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

  <!-- 
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&family=Poppins:wght@400;500;600;700&display=swap"
    rel="stylesheet">
  <!-- animation cdn aos -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body>

<? include('./components/user_header.php')  ?>
        <h2>Saved Properties</h2>
        <section class="listings">
            <div class="product-grid">
                <?php
                        $select_saved_property = $conn->prepare("SELECT * FROM `saved` WHERE user_id = ?");
                        $select_saved_property->execute([$user_id]);
                        
                        if ($select_saved_property->rowCount() > 0) {
                            while ($fetch_saved = $select_saved_property->fetch(PDO::FETCH_ASSOC)) {
                                // Fetch the saved property details
                                $select_properties = $conn->prepare("SELECT * FROM `property` WHERE id = ? ORDER BY date_listed DESC");
                                $select_properties->execute([$fetch_saved['property_id']]);
                                
                                if ($select_properties->rowCount() > 0) {
                                    while ($fetch_property = $select_properties->fetch(PDO::FETCH_ASSOC)) {
                                        // Fetch the property owner details
                                        $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                                        $select_user->execute([$fetch_property['user_id']]);
                                        $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

                                        // Count total images
                                        $total_images = 1 + (int)!empty($fetch_property['image_02']) + (int)!empty($fetch_property['image_03']) + 
                                        (int)!empty($fetch_property['image_04']) + (int)!empty($fetch_property['image_05']);

                                        // Check if the property is saved by the user
                                        $select_saved = $conn->prepare("SELECT * FROM `saved` WHERE property_id = ? AND user_id = ?");
                                        $select_saved->execute([$fetch_property['id'], $user_id]);
                                        ?>
                        <div class="product-card">
                            <form action="" method="POST">
                                <input type="hidden" name="property_id" value="<?= $fetch_property['id']; ?>">
                                <div class="property-box">
                                    <figure class="property-card-banner">
                                        <a href="#">
                                            <img src="upload-images/<?= $fetch_property['image_01']; ?>" alt="Property Image" class="property-image">
                                        </a>
                                        <div class="property-card-badge green">For <?= $fetch_property['offer']; ?></div>
                                        <div class="property-banner-actions">
                                            <button type="button" class="property-action-btn">
                                                <ion-icon name="location"></ion-icon>
                                                <address><?= $fetch_property['address']; ?></address>
                                            </button>
                                            <button type="button" class="property-action-btn">
                                                <ion-icon name="camera"></ion-icon>
                                                <span><?= $total_images; ?></span>
                                            </button>
                                        </div>
                                    </figure>

                                    <div class="property-card-content">
                                        <div class="property-card-price">
                                            <strong><i class="fas fa-indian-rupee-sign"></i> <?= $fetch_property['price']; ?></strong>/Month
                                        </div>
                                        
                                        <h3 class="property-card-title">
                                            <a href="#"><?= $fetch_property['title']; ?></a>
                                        </h3>

                                        <p class="property-card-description">
                                            <?= substr($fetch_property['description'], 0, 100); ?>...
                                            <a href="view-property.php?get_id=<?= $fetch_property['id']; ?>" class="more-link">more</a>
                                        </p>

                                        <ul class="property-card-list">
                                            <li class="property-card-item">
                                                <strong><?= $fetch_property['bedrooms']; ?></strong>
                                                <ion-icon name="bed-outline"></ion-icon>
                                                <span>Bedrooms</span>
                                            </li>
                                            <div class="divider"></div>

                                            <li class="property-card-item">
                                                <strong><?= $fetch_property['bathrooms']; ?></strong>
                                                <ion-icon name="man-outline"></ion-icon>
                                                <span>Bathrooms</span>
                                            </li>
                                            <div class="divider"></div>
                                            
                                            <li class="property-card-item">
                                                <strong><?= $fetch_property['size']; ?></strong>
                                                <ion-icon name="square-outline"></ion-icon>
                                                <span>Square Ft</span>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="property-card-footer">
                                        <div class="property-card-author">
                                            <figure class="author-avatar">
                                                <span><?= strtoupper($fetch_user['name'][0]); ?></span>
                                            </figure>
                                            <div>
                                                <p class="author-name">
                                                    <a href="#"><?= $fetch_user['name']; ?></a>
                                                </p>
                                                <p class="author-title">Owner</p>
                                            </div>
                                        </div>

                                        <div class="property-footer-actions">
                                            <button type="button" class="property-action-btn">
                                                <ion-icon name="resize-outline"></ion-icon>
                                            </button>

                                            <?php if ($select_saved->rowCount() > 0) { ?>
                                                <!-- If the property is already saved -->
                                                <button type="submit" class="property-action-btn" name="remove_save" title="Remove from saved">
                                                    <ion-icon name="heart"></ion-icon> <!-- Filled heart icon for already saved -->
                                                </button>
                                            <?php } else { ?>
                                                <!-- If the property is not saved -->
                                                <button type="submit" class="property-action-btn" name="save" title="Save property">
                                                    <ion-icon name="heart-outline"></ion-icon> <!-- Outline heart icon for not saved -->
                                                </button>
                                                <?php } ?>
                                            
                                            <button type="button" class="property-action-btn">
                                                <ion-icon name="add-circle-outline"></ion-icon>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="property-button-group">
                                        <a href="view-property.php?get_id=<?= $fetch_property['id']; ?>" class="property-view-btn">View Property</a>
                                        <button type="submit" name="send" class="property-enquiry-btn">Send Enquiry</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <?php
                                    }
                                }
                            }
                        } else {
                            echo '<p class="empty">No saved properties yet! <a href="listing.php" class="btn">Add New</a></p>';
                        }
                        ?>
                    </div>
                </section>

            <? include ('./components/footer.php') ?>
            <? include ('./components/message.php') ?>

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

        document.querySelectorAll('.dashboard-container .sidebar ul li a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

        // Hide all sections
        document.querySelectorAll(' .dashboard-container .content-section').forEach(section => {
            section.classList.remove('active');
        });

        // Show the selected section
        const sectionId = this.getAttribute('data-section');
        document.getElementById(sectionId).classList.add('active');
    });
    });

        // Show default section (Profiles) on page load
        document.getElementById('profiles').classList.add('active');

        function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('profilePic');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);

        // Auto-submit the form after preview
        document.getElementById('uploadBtn').click();
        }

        function SavedPage(){
        window.location.href = 'saved.php','_blank'
        }

  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
</body>
</html>