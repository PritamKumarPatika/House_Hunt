<?php
include ('./backend/connect.php');

if(isset($_COOKIE['user_id'])){
  $user_id = $_COOKIE['user_id'];
}else{
  $user_id = '';
}


include './components/save_send.php';

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Househunt - Find your dream house</title>

  <!-- 
    - favicon
  -->
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">

  <!-- 
    - custom css link
  -->
  <link rel="stylesheet" href="./assets/css/style_copy.css">

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



<!-- header section starts  -->

  <?php include './components/user_header.php' ?>

<!-- header section ends -->


  <main>
    <article>

      <!-- 
        - #HERO
      -->

      <section class="hero" id="home">
        <div class="container">

          <div class="hero-content" data-aos="zoom-in-down">

            <p class="hero-subtitle">
              <ion-icon name="home"></ion-icon>

              <span>Real Estate Agency</span>
            </p>

            <h2 class="h1 hero-title">Find Your Dream House By Us</h2>

            <p class="hero-text">
              Your perfect home is just a click away. Explore our curated listings to discover the best properties that
              suit your lifestyle and budget.
            </p>

            <button class="btn" onclick="PropertyPage()">Make An Enquiry</button>

          </div>

          <figure class="hero-banner" data-aos="fade-left">
            <img src="./assets/images/Herobanner.png" alt="Modern house model" class="w-100">
          </figure>

        </div>
      </section>





      <!-- 
        - #ABOUT
      -->

      <section class="about" id="about">
        <div class="container">

          <figure class="about-banner">
            <img src="./assets/images/about-banner-1.png" alt="House interior" data-aos="fade-right">

            <img src="./assets/images/about-banner-2.jpg" alt="House interior" class="abs-img" data-aos="zoom-in">
          </figure>

          <div class="about-content">

            <p class="section-subtitle" data-aos="fade-down">About Us</p>

            <h2 class="h2 section-title" data-aos="fade-left">The Leading Real Estate Rental Marketplace.</h2>

            <p class="about-text" data-aos="fade-left">
              Over 39,000 people work for us in more than 70 countries all over the This breadth of global coverage,
              combined with
              specialist services
            </p>

            <ul class="about-list">

              <li class="about-item" data-aos="fade-left">
                <div class="about-item-icon">
                  <ion-icon name="home-outline"></ion-icon>
                </div>

                <p class="about-item-text" data-aos="fade-left">Smart Home Design</p>
              </li>

              <li class="about-item" data-aos="fade-left">
                <div class="about-item-icon">
                  <ion-icon name="leaf-outline"></ion-icon>
                </div>

                <p class="about-item-text" data-aos="fade-left">Beautiful Scene Around</p>
              </li>

              <li class="about-item" data-aos="fade-left">
                <div class="about-item-icon">
                  <ion-icon name="wine-outline"></ion-icon>
                </div>

                <p class="about-item-text" data-aos="fade-left">Exceptional Lifestyle</p>
              </li>

              <li class="about-item" data-aos="fade-left">
                <div class="about-item-icon">
                  <ion-icon name="shield-checkmark-outline"></ion-icon>
                </div>

                <p class="about-item-text" data-aos="fade-left">Complete 24/7 Security</p>
              </li>

            </ul>

            <p class="callout" data-aos="fade-left">
              Start your journey to the perfect home with us today! Explore top-rated listings, get personalized
              recommendations, and make your dream a reality.
            </p>

            <a href="#service" class="btn" data-aos="zoom-in">Our Services</a>

          </div>

        </div>
      </section>





      <!-- 
        - #SERVICE
      -->

      <section class="service" id="service">
        <div class="container">

          <p class="section-subtitle" data-aos="zoom-in-up">Our Services</p>

          <h2 class="h2 section-title" data-aos="zoom-in-up">Our Main Focus</h2>

          <ul class="service-list">

            <li data-aos="fade-up" data-aos-duration="250">
              <div class="service-card">

                <div class="card-icon">
                  <img src="./assets/images/service-1.png" alt="Service icon">
                </div>

                <h3 class="h3 card-title">
                  <a href="property.php">Buy a home</a>
                </h3>

                <p class="card-text">
                  over 1 million+ homes for sale available on the website, we can match you with a house you will want
                  to call home.
                </p>

                <a href="property.php" class="card-link">
                  <span>Find A Home</span>

                  <ion-icon name="arrow-forward-outline"></ion-icon>
                </a>

              </div>
            </li>

            <li data-aos="fade-up" data-aos-duration="600">
              <div class="service-card">

                <div class="card-icon">
                  <img src="./assets/images/service-2.png" alt="Service icon">
                </div>

                <h3 class="h3 card-title">
                  <a href="property.php">Rent a home</a>
                </h3>

                <p class="card-text">
                  over 1 million+ homes for sale available on the website, we can match you with a house you will want
                  to call home.
                </p>

                <a href="property.php" class="card-link">
                  <span>Find A Home</span>

                  <ion-icon name="arrow-forward-outline"></ion-icon>
                </a>

              </div>
            </li>

            <li data-aos="fade-up" data-aos-duration="900">
              <div class="service-card">

                <div class="card-icon">
                  <img src="./assets/images/service-3.png" alt="Service icon">
                </div>

                <h3 class="h3 card-title">
                  <a href="property.php">Sell a home</a>
                </h3>

                <p class="card-text">
                  over 1 million+ homes for sale available on the website, we can match you with a house you will want
                  to call home.
                </p>

                <a href="property.php" class="card-link">
                  <span>Find A Home</span>

                  <ion-icon name="arrow-forward-outline"></ion-icon>
                </a>

              </div>
            </li>

          </ul>

        </div>
      </section>





      <!-- 
        - #PROPERTY
      -->

      <section class="property" id="property">
        <div class="container">

          <p class="section-subtitle">Properties</p>

          <h2 class="h2 section-title">Featured Listings</h2>

          <ul class="property-list has-scrollbar">

            <li data-aos="zoom-in-down">
              <div class="property-card">

                <figure class="card-banner">

                  <a href="property.php">
                    <img src="./assets/images/property-1.jpg" alt="New Apartment Nice View" class="w-100">
                  </a>

                  <div class="card-badge green">For Rent</div>

                  <div class="banner-actions">

                    <button class="banner-actions-btn">
                      <ion-icon name="location"></ion-icon>

                      <address>Civil Township, Rourkela</address>
                    </button>

                    <button class="banner-actions-btn">
                      <ion-icon name="camera"></ion-icon>

                      <span>4</span>
                    </button>

                    <button class="banner-actions-btn">
                      <ion-icon name="film"></ion-icon>

                      <span>2</span>
                    </button>

                  </div>

                </figure>

                <div class="card-content">

                  <div class="card-price">
                    <strong><i class="fas fa-indian-rupee-sign"></i>34,900</strong>/Month
                  </div>

                  <h3 class="h3 card-title">
                    <a href="property.php">New Apartment Nice View</a>
                  </h3>

                  <p class="card-text">
                    Beautiful Huge 1 Family House In Heart Of Westbury. Newly Renovated With New Wood
                  </p>

                  <ul class="card-list">

                    <li class="card-item">
                      <strong>3</strong>

                      <ion-icon name="bed-outline"></ion-icon>

                      <span>Bedrooms</span>
                    </li>

                    <li class="card-item">
                      <strong>2</strong>

                      <ion-icon name="man-outline"></ion-icon>

                      <span>Bathrooms</span>
                    </li>

                    <li class="card-item">
                      <strong>3450</strong>

                      <ion-icon name="square-outline"></ion-icon>

                      <span>Square Ft</span>
                    </li>

                  </ul>

                </div>

                <div class="card-footer">

                  <div class="card-author">

                    <figure class="author-avatar">
                      <img src="./assets/images/author.jpg" alt="Pritam Patika" class="w-100">
                    </figure>

                    <div>
                      <p class="author-name">
                        <a href="#">Pritam Patika</a>
                      </p>

                      <p class="author-title">Estate Agents</p>
                    </div>

                  </div>

                  <div class="card-footer-actions">

                    <button class="card-footer-actions-btn">
                      <ion-icon name="resize-outline"></ion-icon>
                    </button>

                    <button class="card-footer-actions-btn">
                      <ion-icon name="heart-outline"></ion-icon>
                    </button>

                    <button class="card-footer-actions-btn">
                      <ion-icon name="add-circle-outline"></ion-icon>
                    </button>

                  </div>

                </div>

              </div>
            </li>

            <li data-aos="zoom-in-down">
              <div class="property-card">

                <figure class="card-banner">

                  <a href="property.php">
                    <img src="./assets/images/property-2.jpg" alt="Modern Apartments" class="w-100">
                  </a>

                  <div class="card-badge orange">For Sales</div>

                  <div class="banner-actions">

                    <button class="banner-actions-btn">
                      <ion-icon name="location"></ion-icon>

                      <address>Civil Township, Rourkela</address>
                    </button>

                    <button class="banner-actions-btn">
                      <ion-icon name="camera"></ion-icon>

                      <span>4</span>
                    </button>

                    <button class="banner-actions-btn">
                      <ion-icon name="film"></ion-icon>

                      <span>2</span>
                    </button>

                  </div>

                </figure>

                <div class="card-content">

                  <div class="card-price">
                    <strong><i class="fas fa-indian-rupee-sign"></i>34,900</strong>/Month
                  </div>

                  <h3 class="h3 card-title">
                    <a href="property.php">Modern Apartments</a>
                  </h3>

                  <p class="card-text">
                    Beautiful Huge 1 Family House In Heart Of Westbury. Newly Renovated With New Wood
                  </p>

                  <ul class="card-list">

                    <li class="card-item">
                      <strong>3</strong>

                      <ion-icon name="bed-outline"></ion-icon>

                      <span>Bedrooms</span>
                    </li>

                    <li class="card-item">
                      <strong>2</strong>

                      <ion-icon name="man-outline"></ion-icon>

                      <span>Bathrooms</span>
                    </li>

                    <li class="card-item">
                      <strong>3450</strong>

                      <ion-icon name="square-outline"></ion-icon>

                      <span>Square Ft</span>
                    </li>

                  </ul>

                </div>

                <div class="card-footer">

                  <div class="card-author">

                    <figure class="author-avatar">
                      <img src="./assets/images/author.jpg" alt="Sathwika" class="w-100">
                    </figure>

                    <div>
                      <p class="author-name">
                        <a href="#">Sathwika</a>
                      </p>

                      <p class="author-title">Estate Agents</p>
                    </div>

                  </div>

                  <div class="card-footer-actions">

                    <button class="card-footer-actions-btn">
                      <ion-icon name="resize-outline"></ion-icon>
                    </button>

                    <button class="card-footer-actions-btn">
                      <ion-icon name="heart-outline"></ion-icon>
                    </button>

                    <button class="card-footer-actions-btn">
                      <ion-icon name="add-circle-outline"></ion-icon>
                    </button>

                  </div>

                </div>

              </div>
            </li>

            <li data-aos="zoom-in-down">
              <div class="property-card">

                <figure class="card-banner">

                  <a href="property.php">
                    <img src="./assets/images/property-3.jpg" alt="Comfortable Apartment" class="w-100">
                  </a>

                  <div class="card-badge green">For Rent</div>

                  <div class="banner-actions">

                    <button class="banner-actions-btn">
                      <ion-icon name="location"></ion-icon>

                      <address>Civil Township, Rourkela</address>
                    </button>

                    <button class="banner-actions-btn">
                      <ion-icon name="camera"></ion-icon>

                      <span>4</span>
                    </button>

                    <button class="banner-actions-btn">
                      <ion-icon name="film"></ion-icon>

                      <span>2</span>
                    </button>

                  </div>

                </figure>

                <div class="card-content">

                  <div class="card-price">
                    <strong><i class="fas fa-indian-rupee-sign"></i>34,900</strong>/Month
                  </div>

                  <h3 class="h3 card-title">
                    <a href="property.php">Comfortable Apartment</a>
                  </h3>

                  <p class="card-text">
                    Beautiful Huge 1 Family House In Heart Of Westbury. Newly Renovated With New Wood
                  </p>

                  <ul class="card-list">

                    <li class="card-item">
                      <strong>3</strong>

                      <ion-icon name="bed-outline"></ion-icon>

                      <span>Bedrooms</span>
                    </li>

                    <li class="card-item">
                      <strong>2</strong>

                      <ion-icon name="man-outline"></ion-icon>

                      <span>Bathrooms</span>
                    </li>

                    <li class="card-item">
                      <strong>3450</strong>

                      <ion-icon name="square-outline"></ion-icon>

                      <span>Square Ft</span>
                    </li>

                  </ul>

                </div>

                <div class="card-footer">

                  <div class="card-author">

                    <figure class="author-avatar">
                      <img src="./assets/images/author.jpg" alt="Piyush" class="w-100">
                    </figure>

                    <div>
                      <p class="author-name">
                        <a href="#">Piyush chaudhry</a>
                      </p>

                      <p class="author-title">Estate Agents</p>
                    </div>

                  </div>

                  <div class="card-footer-actions">

                    <button class="card-footer-actions-btn">
                      <ion-icon name="resize-outline"></ion-icon>
                    </button>

                    <button class="card-footer-actions-btn">
                      <ion-icon name="heart-outline"></ion-icon>
                    </button>

                    <button class="card-footer-actions-btn">
                      <ion-icon name="add-circle-outline"></ion-icon>
                    </button>

                  </div>

                </div>

              </div>
            </li>

            <li data-aos="zoom-in-down">
              <div class="property-card">

                <figure class="card-banner">

                  <a href="property.php">
                    <img src="./assets/images/property-4.png" alt="Luxury villa in Rego Park" class="w-100">
                  </a>

                  <div class="card-badge green">For Rent</div>
                  <div class="banner-actions">

                    <button class="banner-actions-btn">
                      <ion-icon name="location"></ion-icon>

                      <address>Civil Township, Rourkela</address>
                    </button>

                    <button class="banner-actions-btn">
                      <ion-icon name="camera"></ion-icon>

                      <span>4</span>
                    </button>

                    <button class="banner-actions-btn">
                      <ion-icon name="film"></ion-icon>

                      <span>2</span>
                    </button>

                  </div>

                </figure>

                <div class="card-content">

                  <div class="card-price">
                    <strong><i class="fas fa-indian-rupee-sign"></i>34,900</strong>/Month
                  </div>

                  <h3 class="h3 card-title">
                    <a href="property.php">Luxury villa in Rego Park</a>
                  </h3>

                  <p class="card-text">
                    Beautiful Huge 1 Family House In Heart Of Westbury. Newly Renovated With New Wood
                  </p>

                  <ul class="card-list">

                    <li class="card-item">
                      <strong>3</strong>

                      <ion-icon name="bed-outline"></ion-icon>

                      <span>Bedrooms</span>
                    </li>

                    <li class="card-item">
                      <strong>2</strong>

                      <ion-icon name="man-outline"></ion-icon>

                      <span>Bathrooms</span>
                    </li>

                    <li class="card-item">
                      <strong>3450</strong>

                      <ion-icon name="square-outline"></ion-icon>

                      <span>Square Ft</span>
                    </li>

                  </ul>

                </div>

                <div class="card-footer">

                  <div class="card-author">

                    <figure class="author-avatar">
                      <img src="./assets/images/author.jpg" alt="Pritam " class="w-100">
                    </figure>

                    <div>
                      <p class="author-name">
                        <a href="#">Pritam kumar Patika</a>
                      </p>

                      <p class="author-title">Estate Agents</p>
                    </div>

                  </div>

                  <div class="card-footer-actions">

                    <button class="card-footer-actions-btn">
                      <ion-icon name="resize-outline"></ion-icon>
                    </button>

                    <button class="card-footer-actions-btn">
                      <ion-icon name="heart-outline"></ion-icon>
                    </button>

                    <button class="card-footer-actions-btn">
                      <ion-icon name="add-circle-outline"></ion-icon>
                    </button>

                  </div>

                </div>

              </div>
            </li>

          </ul>

        </div>
      </section>





      <!-- 
        - #FEATURES
      -->

      <section class="features">
        <div class="container">

          <p class="section-subtitle">Our Aminities</p>

          <h2 class="h2 section-title">Building Aminities</h2>

          <ul class="features-list">

            <li>
              <a href="property.php" class="features-card">

                <div class="card-icon">
                  <ion-icon name="car-sport-outline"></ion-icon>
                </div>

                <h3 class="card-title">Parking Space</h3>

                <div class="card-btn">
                  <ion-icon name="arrow-forward-outline"></ion-icon>
                </div>

              </a>
            </li>

            <li>
              <a href="property.php" class="features-card">

                <div class="card-icon">
                  <ion-icon name="water-outline"></ion-icon>
                </div>

                <h3 class="card-title">Swimming Pool</h3>

                <div class="card-btn">
                  <ion-icon name="arrow-forward-outline"></ion-icon>
                </div>

              </a>
            </li>

            <li>
              <a href="property.php" class="features-card">

                <div class="card-icon">
                  <ion-icon name="shield-checkmark-outline"></ion-icon>
                </div>

                <h3 class="card-title">Private Security</h3>

                <div class="card-btn">
                  <ion-icon name="arrow-forward-outline"></ion-icon>
                </div>

              </a>
            </li>

            <li>
              <a href="property.php" class="features-card">

                <div class="card-icon">
                  <ion-icon name="fitness-outline"></ion-icon>
                </div>

                <h3 class="card-title">Medical Center</h3>

                <div class="card-btn">
                  <ion-icon name="arrow-forward-outline"></ion-icon>
                </div>

              </a>
            </li>

            <li>
              <a href="property.php" class="features-card">

                <div class="card-icon">
                  <ion-icon name="library-outline"></ion-icon>
                </div>

                <h3 class="card-title">Library Area</h3>

                <div class="card-btn">
                  <ion-icon name="arrow-forward-outline"></ion-icon>
                </div>

              </a>
            </li>

            <li>
              <a href="property.php" class="features-card">

                <div class="card-icon">
                  <ion-icon name="bed-outline"></ion-icon>
                </div>

                <h3 class="card-title">King Size Beds</h3>

                <div class="card-btn">
                  <ion-icon name="arrow-forward-outline"></ion-icon>
                </div>

              </a>
            </li>

            <li>
              <a href="property.php" class="features-card">

                <div class="card-icon">
                  <ion-icon name="home-outline"></ion-icon>
                </div>

                <h3 class="card-title">Smart Homes</h3>

                <div class="card-btn">
                  <ion-icon name="arrow-forward-outline"></ion-icon>
                </div>

              </a>
            </li>

            <li>
              <a href="property.php" class="features-card">

                <div class="card-icon">
                  <ion-icon name="football-outline"></ion-icon>
                </div>

                <h3 class="card-title">Kid’s Playland</h3>

                <div class="card-btn">
                  <ion-icon name="arrow-forward-outline"></ion-icon>
                </div>

              </a>
            </li>

          </ul>

        </div>
      </section>


      <!-- 
        - #CTA
      -->

      <section class="cta">
        <div class="container">

          <div class="cta-card">
            <div class="card-content">
              <h2 class="h2 card-title">Looking for a dream home?</h2>

              <p class="card-text">We can help you realize your dream of a new home</p>
            </div>

            <button class="btn cta-btn" onclick="PropertyPage()">
              <span>Explore Properties</span>

              <ion-icon name="arrow-forward-outline"></ion-icon>
            </button>
          </div>

        </div>
      </section>

    </article>



  </main>





 

  <!-- footer section starts -->

  <?php include './components/footer.php'; ?>

  <!-- footer section ends -->

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

  function SavedPage(){
        window.location.href = 'user_dashboard.php','_blank'
        }

  function PropertyPage(){
        window.location.href = 'property.php','_blank'
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

  </script>

  <!-- 
    - custom js link
  -->
  <script src="./assets/js/script.js"></script>


  <!-- 
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
  <?php 
      include './components/message.php';
    ?>
</>
</body>
</html>