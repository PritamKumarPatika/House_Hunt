<?php
include ('./backend/connect.php');

if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
 }else{
    $user_id = '';
 }
 
 if(isset($_GET['get_id'])){
    $get_id = $_GET['get_id'];
 }else{
    $get_id = '';
    header('location:home.php');
 }
 

 // Handle review submission
if (isset($_POST['submit_review'])) {
    $property_id = $_POST['property_id'];
    $user_id = $_POST['user_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    // Prepare the SQL statement to insert the review
    $insert_review = $conn->prepare("INSERT INTO reviews (property_id, user_id, rating, comment) VALUES (?, ?, ?, ?)");
    
    // Execute the statement
    if ($insert_review->execute([$property_id, $user_id, $rating, $comment])) {
        echo '<script>alert("Review submitted successfully!");</script>';
    } else {
        echo '<script>alert("Failed to submit review.");</script>';
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
    <title>HouseHunt - View property page</title>
    <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" href="./assets/css/style_copy.css" class="css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>


    <style>

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn:hover {
    background-color: #0056b3;
}

.review-form {
    margin: 20px 0;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.review-form label {
    display: block;
    margin-bottom: 10px;
    color: #555;
}

.review-form input[type="hidden"],
.review-form textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.review-form textarea {
    resize: vertical;
}

.star-rating {
    direction: rtl;
    display: flex;
    justify-content: flex-start;
}

.star-rating input {
    display: none;
}

.star {
    font-size: 24px;
    color: #ccc;
    cursor: pointer;
    transition: color 0.3s;
}

.star-rating input:checked ~ .star {
    color: #FFA500; /* Gold color for filled stars */
}

.star-rating input:hover ~ .star,
.star-rating input:hover + .star {
    color: #FFA500; 
}

.reviews {
    margin-top: 20px;
}

.review {
    background-color: #ffffff;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 15px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.review-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.review-header strong {
    color: #333;
}

.rating {
    font-weight: bold;
    font-size: 18px;
    color:  #FFA500;
}
.rating input:checked ~ .star {
   
    color:  #FFA500;
}

.comment {
    margin: 10px 0;
    color: #666;
}

.review-date {
    font-size: 12px;
    color: #999;
}


</style>
</head>

<body>
    <?php include('./components/user_header.php') ?>

    <main>
        <!-- view property section starts -->

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

                $select_saved = $conn->prepare("SELECT * FROM `saved` WHERE property_id = ? and user_id = ?");
                $select_saved->execute([$fetch_property['id'], $user_id]);
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

            <h3 class="title">Submit Your Review</h3>
            <form action="" method="post" class="review-form">
                <input type="hidden" name="property_id" value="<?= $property_id; ?>">
                <input type="hidden" name="user_id" value="<?= $user_id; ?>">
                
                <label for="rating">Rating:</label>
                <div class="star-rating">
                    <input type="radio" id="star5" name="rating" value="5" required><label for="star5" class="star">★</label>
                    <input type="radio" id="star4" name="rating" value="4"><label for="star4" class="star">★</label>
                    <input type="radio" id="star3" name="rating" value="3"><label for="star3" class="star">★</label>
                    <input type="radio" id="star2" name="rating" value="2"><label for="star2" class="star">★</label>
                    <input type="radio" id="star1" name="rating" value="1"><label for="star1" class="star">★</label>
                </div>
                
                <label for="comment">Comment:</label>
                <textarea name="comment" id="comment" rows="4" placeholder="Share your thoughts..." required></textarea>
                
                <button type="submit" name="submit_review" class="btn">Submit Review</button>
            </form>


            <h3 class="title">Reviews</h3>
            <div class="reviews">
                <?php
                    $select_reviews = $conn->prepare("SELECT r.*, u.name FROM reviews r JOIN users u ON r.user_id = u.id WHERE r.property_id = ? ORDER BY r.created_at DESC");
                    $select_reviews->execute([$property_id]);
                    
                    if ($select_reviews->rowCount() > 0) {
                        while ($fetch_review = $select_reviews->fetch(PDO::FETCH_ASSOC)) {
                            echo '<div class="review">';
                            echo '<div class="review-header">';
                            echo '<strong>' . htmlspecialchars($fetch_review['name']) . '</strong> <span class="rating">';
                            for ($i = 1; $i <= 5; $i++) {
                                echo ($i <= $fetch_review['rating']) ? '★' : '☆';
                            }
                            echo '</span>';
                            echo '</div>';
                            echo '<p class="comment">' . nl2br(htmlspecialchars($fetch_review['comment'])) . '</p>';
                            echo '<small class="review-date">Reviewed on: ' . $fetch_review['created_at'] . '</small>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No reviews yet. Be the first to review!</p>';
                    }
                ?>
            </div>




            <form action="" method="post" class="flex-btn">
                <input type="hidden" name="property_id" value="<?= $property_id; ?>">
                <?php
                    if($select_saved->rowCount() > 0){
                ?>
                <button type="submit" name="save" class="btn"><i class="fas fa-heart"></i><span>saved</span></button>
                <?php
                    }else{ 
                ?>
                <button type="submit" name="save" class="btn"><i class="far fa-heart"></i><span>save</span></button>
                <?php
                    }
                ?>
                <button type="submit" value="send enquiry" name="send" class="btn">send enquery</button>
            </form>
        </div>
        <?php
            }
        }else{
            echo '<p class="empty">property not found! <a href="listing.php" style="margin-top:1.5rem;" class="btn">add new</a></p>';
        }
        ?>

        </section>
        <!-- view property section ends -->
    </main>
    <?php include('./components/footer.php') ?>

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

        document.querySelectorAll('.view-property .details .thumb .small-images img').
            forEach(images => {
                images.onclick = () => {
                    src = images.getAttribute('src');
                    document.querySelector('.view-property .details .thumb .big-image img').
                        src = src;
                }
            });

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

        function SavedPage(){
        window.location.href = 'saved.php','_blank'
        }
    </script>
    <script src="./assets/js/script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
</body>

</html>