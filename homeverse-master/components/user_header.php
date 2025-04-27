<!-- 
    - #HEADER
  -->

  <header class="header" data-header>

    <div class="overlay" data-overlay></div>

    <div class="header-top">
      <div class="container">

        <ul class="header-top-list">

          <li>
            <a href="mailto:info@househunt.com" class="header-top-link">
              <ion-icon name="mail-outline"></ion-icon>

              <span>info@househunt.com</span>
            </a>
          </li>

          <li>
            <a href="#" class="header-top-link">
              <ion-icon name="location-outline"></ion-icon>

              <address>15/A, Rourkela, Main market place</address>
            </a>
          </li>

        </ul>

        <div class="wrapper">
          <ul class="header-top-social-list">

            <li>
              <a href="#" class="header-top-social-link">
                <ion-icon name="logo-facebook"></ion-icon>
              </a>
            </li>

            <li>
              <a href="#" class="header-top-social-link">
                <ion-icon name="logo-twitter"></ion-icon>
              </a>
            </li>

            <li>
              <a href="#" class="header-top-social-link">
                <ion-icon name="logo-instagram"></ion-icon>
              </a>
            </li>

            <li>
              <a href="#" class="header-top-social-link">
                <ion-icon name="logo-pinterest"></ion-icon>
              </a>
            </li>

          </ul>

          <button class="header-top-btn" onclick="ListingPage()">Add Listing</button>
        </div>

      </div>
    </div>

    <div class="header-bottom">
      <div class="container">

        <a href="#" class="logo">
          <img src="./assets/images/logo-househunt.png" alt="HOuseHunt logo">
        </a>

        <nav class="navbar" data-navbar>

          <div class="navbar-top">

            <a href="#" class="logo">
              <img src="./assets/images/logo-househunt.png" alt="HOuseHunt logo">
            </a>

            <button class="nav-close-btn" data-nav-close-btn aria-label="Close Menu">
              <ion-icon name="close-outline"></ion-icon>
            </button>

          </div>

          <div class="navbar-bottom">
            <ul class="navbar-list">

              <li>
                <a href="index.php" class="navbar-link" data-nav-link>Home</a>
              </li>

              <li>
                <a href="#about" class="navbar-link" data-nav-link>About</a>
              </li>

              <li>
                <a href="#service" class="navbar-link" data-nav-link>Service</a>
              </li>

              <li>
                <a href="property.php" class="navbar-link" data-nav-link>Property</a>
              </li>

              <li>
                <a href="contact.php" class="navbar-link" data-nav-link>Contact</a>
              </li>

            </ul>
          </div>

        </nav>

        <div class="header-bottom-actions">

          <button class="header-bottom-actions-btn" aria-label="Search" id="searchBtn">
            <ion-icon name="search-outline"></ion-icon>
            <span>Search</span>
          </button>

          <!-- Search Bar -->
          <div class="search-bar" id="searchBar">
            <input type="text" id="searchInput search_box" name="search_box" placeholder="Search properties...">
            <button class="search-submit submit" aria-label="Submit Search search_btn" name="search_btn">
                <ion-icon name="arrow-forward-outline"></ion-icon>
            </button>
        </div>

          <button class="header-bottom-actions-btn" aria-label="Profile" id="profile-btn">
            <ion-icon name="person-outline"></ion-icon>
            <span>Profile</span>
          </button>

          <div class="dropdown-menu" id="profile-dropdown">
            <ul>
                <li>
                    <a href="#" id="signInBtn">Sign In</a>
                    <div class="dropdown-content" id="dropdownMenu">
                        <a href="http://localhost/HOMEVERSE-MASTER/homeverse-master/admin/login.php">Admin Login</a>
                        <a href="login.php">User Login</a>
                    </div>
                </li>
              <?php if (isset($user_id)) { ?>
                <!-- If the user is logged in, show profile links -->
                <li><a href="user_dashboard.php">My Account</a></li>
                <li><a href="user_dashboard.php #update-profile">Update Profile</a></li>
                <li><a href="./components/user_logout.php" onclick="return confirm('Logout from this website?');">Logout</a></li>
              <?php } else { ?>
                <!-- If not logged in, show login links -->
                <li><a href="login.php">Sign In</a></li>
              <?php } ?>
            </ul>
          </div>

          <button class="header-bottom-actions-btn" aria-label="Cart" onclick="SavedPage()">
            <ion-icon name="heart-outline"></ion-icon>

            <span>wish list</span>
          </button>

          <button class="header-bottom-actions-btn" data-nav-open-btn aria-label="Open Menu">
            <ion-icon name="menu-outline"></ion-icon>

            <span>Menu</span>
          </button>

        </div>

      </div>
    </div>

  </header>

