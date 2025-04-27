<?php  

include './backend/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
   exit;
}

// Fetch user data
$select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ? LIMIT 1");
$select_user->execute([$user_id]);
$fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['submit'])){

   // Sanitize inputs
   $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
   $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
   $number = filter_var($_POST['number'], FILTER_SANITIZE_STRING);
   $address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);

   // Update name
   if(!empty($name)){
      $update_name = $conn->prepare("UPDATE `users` SET name = ? WHERE id = ?");
      $update_name->execute([$name, $user_id]);
      $success_msg[] = 'Name updated!';
   }

   // Update email with verification
   if(!empty($email)){
      $verify_email = $conn->prepare("SELECT email FROM `users` WHERE email = ? AND id != ?");
      $verify_email->execute([$email, $user_id]);
      if($verify_email->rowCount() > 0){
         $warning_msg[] = 'Email already taken!';
      }else{
         $update_email = $conn->prepare("UPDATE `users` SET email = ? WHERE id = ?");
         $update_email->execute([$email, $user_id]);
         $success_msg[] = 'Email updated!';
      }
   }

   // Update number with verification
   if(!empty($number)){
      $verify_number = $conn->prepare("SELECT number FROM `users` WHERE number = ? AND id != ?");
      $verify_number->execute([$number, $user_id]);
      if($verify_number->rowCount() > 0){
         $warning_msg[] = 'Number already taken!';
      }else{
         $update_number = $conn->prepare("UPDATE `users` SET number = ? WHERE id = ?");
         $update_number->execute([$number, $user_id]);
         $success_msg[] = 'Phone number updated!';
      }
   }

   // Update address
   if(!empty($address)){
      $update_address = $conn->prepare("UPDATE `users` SET address = ? WHERE id = ?");
      $update_address->execute([$address, $user_id]);
      $success_msg[] = 'Address updated!';
   }

   // Password Update
   $empty_pass = sha1('');
   $prev_pass = $fetch_user['password'];
   $old_pass = sha1($_POST['old_password']);
   $new_pass = sha1($_POST['new_password']);
   $c_pass = sha1($_POST['confirm_password']);

   if($old_pass != $empty_pass){
      if($old_pass != $prev_pass){
         $warning_msg[] = 'Old password not matched!';
      } elseif($new_pass != $c_pass){
         $warning_msg[] = 'Confirm password not matched!';
      } else {
         if($new_pass != $empty_pass){
            $update_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
            $update_pass->execute([$new_pass, $user_id]);
            $success_msg[] = 'Password updated successfully!';
         } else {
            $warning_msg[] = 'Please enter a new password!';
         }
      }
   }

   // Handle profile image upload
   if(isset($_FILES['profile_image']['name']) && !empty($_FILES['profile_image']['name'])) {
      $image_name = $_FILES['profile_image']['name'];
      $image_tmp_name = $_FILES['profile_image']['tmp_name'];
      $image_size = $_FILES['profile_image']['size'];
      $image_folder = 'upload-images/profile_pictures'.$image_name;

      // Check if file is an image and within size limit
      $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
      if (!in_array($_FILES['profile_image']['type'], $allowed_types)) {
         $warning_msg[] = 'Invalid file type!';
      } elseif ($image_size > 10000000) { // 2MB limit
         $warning_msg[] = 'Image file is too large!';
      } else {
         // Move the file to the uploads folder
         move_uploaded_file($image_tmp_name, $image_folder);

         // Update profile image path in database
         $update_image_query = $conn->prepare("UPDATE `users` SET profile_image = ? WHERE id = ?");
         $update_image_query->execute([$image_folder, $user_id]);

         $success_msg[] = 'Profile image updated successfully!';
      }
   }
}

// Delete request or property
if (isset($_POST['delete'])) {
   if (isset($_POST['request_id'])) {
      // Delete request
      $delete_id = filter_var($_POST['request_id'], FILTER_SANITIZE_STRING);
      $verify_delete = $conn->prepare("SELECT * FROM `requests` WHERE id = ?");
      $verify_delete->execute([$delete_id]);

      if ($verify_delete->rowCount() > 0) {
         $delete_request = $conn->prepare("DELETE FROM `requests` WHERE id = ?");
         $delete_request->execute([$delete_id]);
         $success_msg[] = 'Request deleted successfully!';
      } else {
         $warning_msg[] = 'Request already deleted!';
      }
   }

   if (isset($_POST['property_id'])) {
      // Delete property
      $delete_id = filter_var($_POST['property_id'], FILTER_SANITIZE_STRING);
      $verify_delete = $conn->prepare("SELECT * FROM `property` WHERE id = ?");
      $verify_delete->execute([$delete_id]);

      if ($verify_delete->rowCount() > 0) {
         $select_images = $conn->prepare("SELECT * FROM `property` WHERE id = ?");
         $select_images->execute([$delete_id]);

         // Remove property images
         while ($fetch_images = $select_images->fetch(PDO::FETCH_ASSOC)) {
            for ($i = 1; $i <= 5; $i++) {
               $image_field = 'image_0' . $i;
               if (!empty($fetch_images[$image_field])) {
                  unlink('upload-images/' . $fetch_images[$image_field]);
               }
            }
         }

         // Delete related data
         $delete_saved = $conn->prepare("DELETE FROM `saved` WHERE property_id = ?");
         $delete_saved->execute([$delete_id]);
         $delete_requests = $conn->prepare("DELETE FROM `requests` WHERE property_id = ?");
         $delete_requests->execute([$delete_id]);
         $delete_listing = $conn->prepare("DELETE FROM `property` WHERE id = ?");
         $delete_listing->execute([$delete_id]);

         $success_msg[] = 'Property listing deleted successfully!';
      } else {
         $warning_msg[] = 'Property already deleted!';
      }
   }
}

// Count user-related properties and requests
$count_properties = $conn->prepare("SELECT * FROM `property` WHERE user_id = ?");
$count_properties->execute([$user_id]);
$total_properties = $count_properties->rowCount();

$count_requests_received = $conn->prepare("SELECT * FROM `requests` WHERE receiver = ?");
$count_requests_received->execute([$user_id]);
$total_requests_received = $count_requests_received->rowCount();

$count_requests_sent = $conn->prepare("SELECT * FROM `requests` WHERE sender = ?");
$count_requests_sent->execute([$user_id]);
$total_requests_sent = $count_requests_sent->rowCount();

$count_saved_properties = $conn->prepare("SELECT * FROM `saved` WHERE user_id = ?");
$count_saved_properties->execute([$user_id]);
$total_saved_properties = $count_saved_properties->rowCount();

include('./components/save_send.php')

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>House_Hunt - My account page</title>
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
</head>
<body class="properties-page">

    <?php include ('./components/user_header.php') ?>

    <div class="dashboard-container">
        <!-- Sidebar -->
        <nav class="sidebar">
            <ul>
                <li><a href="#" data-section="profiles"><i class='bx bx-user'></i> Profiles</a></li>
                <li><a href="#update-profile" data-section="update-profile"><i class='bx bx-edit'></i> Update Profile</a></li>
                <li><a href="#properties-listed" data-section="properties-listed"><i class='bx bx-list-ul'></i> Properties Listed</a></li>
                <li><a href="#saved-properties" data-section="saved-properties"><i class='bx bx-heart'></i> Saved Properties</a></li>
                <li><a href="#sent-requests" data-section="sent-requests"><i class='bx bx-send'></i> Sent Requests</a></li>
                <li><a href="#received-requests" data-section="received-requests"><i class='bx bx-receipt'></i> Received Requests</a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Profiles Section -->
            <div id="profiles" class="content-section active">
                <h2>Profile Details</h2>

                <!-- Profile Image Section with Edit Button -->
                <div class="profile-image">
                    <?php if (!empty($fetch_user['profile_image'])): ?>
                        <div class="image-wrapper">
                            <img id="profilePic" src="<?= $fetch_user['profile_image']; ?>" alt="Profile Picture">
                            <label for="profileImage" class="edit-icon">
                                <i class="fa fa-camera"></i>
                            </label>
                        </div>
                    <?php else: ?>
                        <div class="profile-placeholder image-wrapper">
                            <?= strtoupper($fetch_user['name'][0]); ?>
                            <label for="profileImage" class="edit-icon">
                                <i class="fa fa-camera"></i>
                            </label>
                        </div>
                    <?php endif; ?>

                    <form id="imageUploadForm" action="" method="POST" enctype="multipart/form-data">
                        <input type="file" id="profileImage" name="profile_image" accept="image/*" style="display: none;" onchange="previewImage(event)">
                        <button type="submit" style="display: none;" id="uploadBtn">Upload</button>
                    </form>
                </div>

                <div class="profile-info">
                    <p><strong>Name:</strong> <span><?= $fetch_user['name']; ?></span></p>
                    <p><strong>Email:</strong> <span><?= $fetch_user['email']; ?></span></p>
                    <p><strong>Phone Number:</strong> <span><?= $fetch_user['number']; ?></span></p>
                    <p><strong>Address:</strong> <span><?= $fetch_user['address']; ?></span></p>
                    <p><strong>Properties Listed:</strong> <span><?= $total_properties; ?></span></p>
                    <p><strong>Saved Properties:</strong> <span><?= $total_saved_properties; ?></span></p>
                    <p><strong>Requests Sent:</strong> <span><?= $total_requests_sent; ?></span></p>
                    <p><strong>Requests Received:</strong> <span><?= $total_requests_received; ?></span></p>
                </div>
            </div>

            <!-- Update Profile Section -->
            <div id="update-profile" class="content-section">
                <h2>Update Profile</h2>
                <form action="#" method="POST">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" placeholder="<?= $fetch_user['name']; ?>" maxlength="50">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" maxlength="50" placeholder="<?= $fetch_user['email']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number:</label>
                        <input type="tel" id="phone" name="number"   min="0" max="9999999999" maxlength="10" placeholder="<?= $fetch_user['number']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address"   maxlength="100" placeholder="<?= $fetch_user['address']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">New Password:</label>
                        <input type="password" id="password" name="old_password">
                    </div>
                    <div class="form-group">
                        <label for="password">New Password:</label>
                        <input type="password" id="password" name="new_password">
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirm Password:</label>
                        <input type="password" id="confirm-password" name="confirm_password">
                    </div>
                    <button type="submit" name="submit" class="btn">
                        <i class="bx bx-save"></i> Update Profile
                    </button>
                </form>
            </div>

            <!-- Properties Listed Section -->
            <div id="properties-listed" class="content-section">
                <section class="my-listings">
                    <h1 class="heading">My Listings</h1>
                    <div class="product-grid">

                        <?php
                        // Prepare the query to fetch properties listed by the logged-in user
                        $select_properties = $conn->prepare("SELECT * FROM `property` WHERE user_id = ? ORDER BY date_listed DESC");
                        $select_properties->execute([$user_id]);

                        if ($select_properties->rowCount() > 0) {
                            while ($fetch_property = $select_properties->fetch(PDO::FETCH_ASSOC)) {
                                // Get the property ID
                                $property_id = $fetch_property['id'];

                                // Count the total images of the property
                                $total_images = 1 + (int)!empty($fetch_property['image_02']) + (int)!empty($fetch_property['image_03']) + 
                                    (int)!empty($fetch_property['image_04']) + (int)!empty($fetch_property['image_05']);
                        ?>
                        <div class="product-card">
                            <form action="" method="POST">
                                <input type="hidden" name="property_id" value="<?= $fetch_property['id']; ?>">
                                <div class="property-box"> 
                                    <figure class="property-card-banner">
                                        <a href="#">
                                            <img src="upload-images/<?= $fetch_property['image_01']; ?>" alt="" class="property-image">
                                        </a>

                                        <div class="property-card-badge green">For <?= $fetch_property['offer']; ?></div>
                                        <div class="property-banner-actions">
                                            <button class="property-action-btn">
                                                <ion-icon name="location"></ion-icon>
                                                <address><?= $fetch_property['address']; ?></address>           
                                            </button>
                                            <button class="property-action-btn">
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
                                                <span><?= strtoupper($fetch_property['user_id'][0]); ?></span> <!-- The avatar will display the first letter of the user's name -->
                                            </figure>
                                            <div>
                                                <p class="author-name">
                                                    <a href="#">You</a> <!-- Since it's the user's own listing, the author is "You" -->
                                                </p>
                                                <p class="author-title">Owner</p>
                                            </div>
                                        </div>

                                        <div class="property-footer-actions">
                                            <button class="property-action-btn">
                                                <ion-icon name="resize-outline"></ion-icon>
                                            </button>
                                            <button class="property-action-btn">
                                                <ion-icon name="heart-outline"></ion-icon> <!-- Can be used for saving the property -->
                                            </button>
                                            <button class="property-action-btn">
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
                        } else {
                            echo '<p class="empty">No properties added yet! <a href="listing.php" class="btn">Add New</a></p>';
                        }
                        ?>
                    </div>
                </section>
            </div>

            <!-- Saved Properties Section -->
            <div id="saved-properties" class="content-section">
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
                            echo '<p class="empty">No saved properties yet! <a href="property.php" class="btn">Add New</a></p>';
                        }
                        ?>
                    </div>
                </section>
            </div>


            <!-- Sent Requests Section (Leave blank for now) -->
            <div id="sent-requests" class="content-section">
            <section class="requests">
                <h1 class="heading">All Requests</h1>

                <div class="box-container">
                    <?php
                    $select_requests = $conn->prepare("SELECT * FROM `requests` WHERE sender = ?");
                    $select_requests->execute([$user_id]);
                    if($select_requests->rowCount() > 0){
                        while($fetch_request = $select_requests->fetch(PDO::FETCH_ASSOC)){

                            $select_sender = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                            $select_sender->execute([$fetch_request['receiver']]);
                            $fetch_sender = $select_sender->fetch(PDO::FETCH_ASSOC);

                            $select_property = $conn->prepare("SELECT * FROM `property` WHERE id = ?");
                            $select_property->execute([$fetch_request['property_id']]);
                            $fetch_property = $select_property->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <div class="box">
                        <p class="request-detail"><strong>Name:</strong> <span><?= $fetch_sender['name']; ?></span></p>
                        <p class="request-detail"><strong>Number:</strong> <a href="tel:<?= $fetch_sender['number']; ?>"><?= $fetch_sender['number']; ?></a></p>
                        <p class="request-detail"><strong>Email:</strong> <a href="mailto:<?= $fetch_sender['email']; ?>"><?= $fetch_sender['email']; ?></a></p>
                        <p class="request-detail"><strong>Enquiry for:</strong> <span><?= $fetch_property['title']; ?></span></p>

                        <form action="" method="POST">
                            <input type="hidden" name="request_id" value="<?= $fetch_request['id']; ?>">
                            <div class="button-container">
                                <button type="submit" class="btn delete-btn" onclick="return confirm('Remove this request?');" name="delete">Delete Request</button>
                                <a href="view-property.php?get_id=<?= $fetch_property['id']; ?>" class="btn view-btn">View Property</a>
                            </div>
                        </form>
                    </div>
                    <?php
                        }
                    }else{
                        echo '<p class="empty">You have no sent requests!</p>';
                    }
                    ?>
                </div>
            </section>

            </div>

            <!-- Received Requests Section (Leave blank for now) -->
            <div id="received-requests" class="content-section">
            <section class="requests">

                <h1 class="heading">All Requests</h1>

                <div class="box-container">

                <?php
                    $select_requests = $conn->prepare("SELECT * FROM `requests` WHERE receiver = ?");
                    $select_requests->execute([$user_id]);
                    if($select_requests->rowCount() > 0){
                        while($fetch_request = $select_requests->fetch(PDO::FETCH_ASSOC)){

                        $select_sender = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                        $select_sender->execute([$fetch_request['sender']]);
                        $fetch_sender = $select_sender->fetch(PDO::FETCH_ASSOC);

                        $select_property = $conn->prepare("SELECT * FROM `property` WHERE id = ?");
                        $select_property->execute([$fetch_request['property_id']]);
                        $fetch_property = $select_property->fetch(PDO::FETCH_ASSOC);
                    
                ?>
                <div class="box">
                <p>name : <span><?= $fetch_sender['name']; ?></span></p>
                <p>number : <a href="tel:<?= $fetch_sender['number']; ?>"><?= $fetch_sender['number']; ?></a></p>
                <p>email : <a href="mailto:<?= $fetch_sender['email']; ?>"><?= $fetch_sender['email']; ?></a></p>
                <p>enquiry for : <span><?= $fetch_property['title']; ?></span></p>
                <form action="" method="POST">
                    <input type="hidden" name="request_id" value="<?= $fetch_request['id']; ?>">
                    <div class="button-container">
                        <button type="submit" class="btn" onclick="return confirm('remove this request?');" name="delete" style="margin-top: 1.5rem;">delete request</button>
                        <a href="view-property.php?get_id=<?= $fetch_property['id']; ?>" class="btn" style="margin-top: 1.5rem;">view property</a>
                    </div>

                </form>
                </div>
                <?php
                }
                }else{
                echo '<p class="empty">You have no requests!</p>';
                }
                ?>

                </div>

                </section>
            </div>
        </div>
    </div>

    <?php include ('./components/footer.php') ?>

    <?php include './components/message.php'; ?>

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

  <!-- 
    - custom js link
  -->
  <script src="./assets/js/script.js"></script>


  <!-- 
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>
</html>