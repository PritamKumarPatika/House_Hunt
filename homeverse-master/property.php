<?php
include ('./backend/connect.php');

$user_id = isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : '';

include './components/save_send.php';

$search_offer = $_GET['offer'] ?? '';
$search_location = $_GET['location'] ?? '';
$search_min_price = $_GET['min_price'] ?? '';
$search_max_price = $_GET['max_price'] ?? '';
$search_bedrooms = $_GET['bedrooms'] ?? '';
$search_bathrooms = $_GET['bathrooms'] ?? '';

$search_query = isset($_GET['query']) ? $_GET['query'] : '';

$query = "SELECT * FROM `property` WHERE 1";
if (!empty($search_query)) {
    $query .= " AND (title LIKE :query OR description LIKE :query OR address LIKE :query)";
}
$query .= " ORDER BY date_listed DESC";
$select_properties = $conn->prepare($query);
if (!empty($search_query)) {
    $select_properties->bindValue(':query', '%' . $search_query . '%', PDO::PARAM_STR);
}
$select_properties->execute();
$properties = $select_properties->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HouseHunt - Listing Page</title>
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">
  <link rel="stylesheet" href="./assets/css/style_copy.css" class="css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
  <link
    href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&family=Poppins:wght@400;500;600;700&display=swap"
    rel="stylesheet">

    <style>
.search-filter {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    background-color: #f8f8f8;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    max-width: 97%;
    margin: 20px auto;
}

.filter-group {
    display: flex;
    flex-direction: column;
    flex: 1 1 200px;
}

.filter-group label {
    font-size: 14px;
    font-weight: 600;
    color: #333;
    margin-bottom: 6px;
}

.filter-group input[type="text"],
.filter-group input[type="number"],
.filter-group select {
    padding: 8px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
    outline: none;
    transition: border-color 0.3s;
}

.filter-group input[type="text"]:focus,
.filter-group input[type="number"]:focus,
.filter-group select:focus {
    border-color: #007bff;
}

.filter-button {
    background-color: #007bff;
    color: #fff;
    font-size: 16px;
    font-weight: 600;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
    align-self: flex-end;
}

.filter-button:hover {
    background-color: #0056b3;
}

@media (max-width: 600px) {
    .filter-group {
        flex: 1 1 100%;
    }

    .filter-button {
        width: 100%;
    }
}

    </style>
</head>


<body>
  <?php include('./components/user_header.php') ?>

  <form method="GET" class="search-filter">
        <div class="filter-group">
            <label for="offer">Offer:</label>
            <select name="offer" id="offer">
                <option value="">All</option>
                <option value="sales" <?= $search_offer === 'sales' ? 'selected' : '' ?>>For Sales</option>
                <option value="rental" <?= $search_offer === 'rental' ? 'selected' : '' ?>>For Rental</option>
            </select>
        </div>
        <div class="filter-group">
            <label for="location">Location:</label>
            <input type="text" name="location" id="location" value="<?= htmlspecialchars($search_location); ?>" placeholder="Enter location">
        </div>
        <div class="filter-group">
            <label for="min_price">Min Price:</label>
            <input type="number" name="min_price" id="min_price" value="<?= htmlspecialchars($search_min_price); ?>">
        </div>
        <div class="filter-group">
            <label for="max_price">Max Price:</label>
            <input type="number" name="max_price" id="max_price" value="<?= htmlspecialchars($search_max_price); ?>">
        </div>
        <div class="filter-group">
            <label for="bedrooms">Bedrooms:</label>
            <input type="number" name="bedrooms" id="bedrooms" value="<?= htmlspecialchars($search_bedrooms); ?>">
        </div>
        <div class="filter-group">
            <label for="bathrooms">Bathrooms:</label>
            <input type="number" name="bathrooms" id="bathrooms" value="<?= htmlspecialchars($search_bathrooms); ?>">
        </div>
        <button type="submit" class="filter-button">Search</button>
    </form>

    <main class="product-grid">
    <?php

        $query = "SELECT * FROM `property` WHERE 1";

        if (!empty($search_offer)) {
            $query .= " AND offer = :offer";
        }
        if (!empty($search_location)) {
            $query .= " AND address LIKE :location COLLATE utf8mb4_general_ci";
        }
        if (!empty($search_min_price)) {
            $query .= " AND price >= :min_price";
        }
        if (!empty($search_max_price)) {
            $query .= " AND price <= :max_price";
        }
        if (!empty($search_bedrooms)) {
            $query .= " AND bedrooms = :bedrooms";
        }
        if (!empty($search_bathrooms)) {
            $query .= " AND bathrooms = :bathrooms";
        }
        $query .= " ORDER BY date_listed DESC";
        
        $select_properties = $conn->prepare($query);
        
        if (!empty($search_offer)) $select_properties->bindParam(':offer', $search_offer);
        if (!empty($search_location)) {
            $select_properties->bindValue(':location', '%' . $search_location . '%', PDO::PARAM_STR);
        }
        if (!empty($search_min_price)) $select_properties->bindParam(':min_price', $search_min_price);
        if (!empty($search_max_price)) $select_properties->bindParam(':max_price', $search_max_price);
        if (!empty($search_bedrooms)) $select_properties->bindParam(':bedrooms', $search_bedrooms);
        if (!empty($search_bathrooms)) $select_properties->bindParam(':bathrooms', $search_bathrooms);
        
        $select_properties->execute();
        
        if(isset($_POST['search_box']) OR isset($_POST['search_btn'])){
            $search_box = $_POST['search_box'];
            $search_box = filter_var($search_box, FILTER_SANITIZE_STRING);
            $select_listings = $conn->prepare("SELECT * FROM `property` WHERE title LIKE '%{$search_box}%' OR address LIKE '%{$search_box}%' ORDER BY date_listed DESC");
            $select_listings->execute();
        }else{
            $select_listings = $conn->prepare("SELECT * FROM `property` ORDER BY date_listed DESC");
            $select_listings->execute();
        } 
            if ($select_properties->rowCount() > 0) {
                while ($fetch_property = $select_properties->fetch(PDO::FETCH_ASSOC)) {
                    $select_reviews = $conn->prepare("SELECT AVG(rating) as avg_rating, COUNT(rating) as rating_count FROM reviews WHERE property_id = :property_id");
                    $select_reviews->bindParam(':property_id', $fetch_property['id']);
                    $select_reviews->execute();
                    $reviews = $select_reviews->fetch(PDO::FETCH_ASSOC);
                    $avg_rating = $reviews['avg_rating'] ? round($reviews['avg_rating'], 1) : '0';
                    $rating_count = $reviews['rating_count'] ? $reviews['rating_count'] : 0;
                    $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                    $select_user->execute([$fetch_property['user_id']]);
                    $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

                    $image_count_02 = !empty($fetch_property['image_02']) ? 1 : 0;
                    $image_count_03 = !empty($fetch_property['image_03']) ? 1 : 0;
                    $image_count_04 = !empty($fetch_property['image_04']) ? 1 : 0;
                    $image_count_05 = !empty($fetch_property['image_05']) ? 1 : 0;
                    $total_images = 1 + $image_count_02 + $image_count_03 + $image_count_04 + $image_count_05;


                    // Check if saved
                    $select_saved = $conn->prepare("SELECT * FROM `saved` WHERE property_id = ? and user_id = ?");
                    $select_saved->execute([$fetch_property['id'], $user_id]);
                    ?>

                    <div class="product-card">
                        <form action="" method="POST">
                            <input type="hidden" name="property_id" value="<?= $fetch_property['id']; ?>">
                            <div class="property-box"> 
                                <figure class="property-card-banner">
                                    <a href="#">
                                        <img src="upload-images/<?= $fetch_property['image_01']; ?>" alt="Luxury villa in Rego Park" class="property-image">
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
                                        <a href="view-property" class="more-link">more</a>
                                    </p>
                                    <ul class="property-card-list">
                                        <li class="property-card-item">
                                            <strong><?= $fetch_property['bedrooms']; ?></strong>
                                            <ion-icon name="bed-outline"></ion-icon>
                                            <span>Bedrooms</span>
                                        </li>
                                        <div class="divider"></div> <!-- Divider -->
                                        <li class="property-card-item">
                                            <strong><?= $fetch_property['bathrooms']; ?></strong>
                                            <ion-icon name="man-outline"></ion-icon>
                                            <span>Bathrooms</span>
                                        </li>
                                        <div class="divider"></div> <!-- Divider -->
                                        <li class="property-card-item">
                                            <strong><?= $fetch_property['size']; ?></strong>
                                            <ion-icon name="square-outline"></ion-icon>
                                            <span>Square Ft</span>
                                        </li>
                                    </ul>

                                </div>
                                <div class="property-rating" style="display: flex; align-items: center; gap: 10px; margin-top: 10px; font-size: 16px; color: #2c3e50; padding: 8px 12px;">
                                    <span class="rating-text" style="font-weight: 700; color: #000000; display: flex; align-items: center; gap: 5px; font-size: 18px;">
                                        <ion-icon name="star" style="color: #ffd700; font-size: 20px;"></ion-icon>
                                        <?= $avg_rating; ?> / 5
                                    </span>
                                    <span class="rating-count" style="color: #000000; font-size: 14px; font-style: italic;">
                                        (<?= $rating_count; ?> Ratings)
                                    </span>
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
                                        <button class="property-action-btn">
                                            <ion-icon name="resize-outline"></ion-icon>
                                        </button>
                                        <?php if ($select_saved->rowCount() > 0) { ?>
                                            <button class="property-action-btn">
                                                <ion-icon name="heart"></ion-icon>
                                            </button>
                                        <?php } else { ?>
                                            <button class="property-action-btn">
                                                <ion-icon name="heart-outline"></ion-icon>
                                            </button>
                                        <?php } ?>
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
        </main>






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

      function redirectToProperties() {
        const searchQuery = document.getElementById("searchInput").value.trim();
        if (searchQuery) {
            window.location.href = `property.php?query=${encodeURIComponent(searchQuery)}`;
        } else {
            window.location.href = "property.php";
        }
        }

        document.getElementById("searchInput").addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            redirectToProperties();
        }
        });

        function SavedPage(){
        window.location.href = 'user_dashboard.php','_blank'
        }

  </script>

  
  <?php include('./components/footer.php') ?>
  <script src="./assets/js/script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
</body>

</html>