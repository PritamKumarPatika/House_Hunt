<?php  
include './backend/connect.php';

// Check if user is logged in, if not redirect to login page
if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    header('location:login.php');
    exit; // Make sure to exit after the redirect
}

if (isset($_POST['post'])) {
    $id = create_unique_id();
    $title = filter_var(trim($_POST['title']), FILTER_SANITIZE_STRING);
    $description = filter_var(trim($_POST['description']), FILTER_SANITIZE_STRING);
    $price = filter_var(trim($_POST['price']), FILTER_SANITIZE_STRING);
    $price_label = filter_var(trim($_POST['price_label']), FILTER_SANITIZE_STRING);

    // Get Category values
    $category_1 = filter_var(trim($_POST['property_type']), FILTER_SANITIZE_STRING);
    $category_2 = filter_var(trim($_POST['offer']), FILTER_SANITIZE_STRING);
    $category_3 = filter_var(trim($_POST['status']), FILTER_SANITIZE_STRING);

    // Get Listing Details
    $size = filter_var(trim($_POST['size']), FILTER_SANITIZE_STRING);
    $lot_size = filter_var(trim($_POST['lot_size']), FILTER_SANITIZE_STRING);
    $rooms = filter_var(trim($_POST['rooms']), FILTER_SANITIZE_STRING);
    $bedrooms = filter_var(trim($_POST['bedrooms']), FILTER_SANITIZE_STRING);
    $bathrooms = filter_var(trim($_POST['bathrooms']), FILTER_SANITIZE_STRING);
    $custom_id = filter_var(trim($_POST['custom_id']), FILTER_SANITIZE_STRING);
    $garages = filter_var(trim($_POST['garages']), FILTER_SANITIZE_STRING);
    $house_age = filter_var(trim($_POST['house_age']), FILTER_SANITIZE_STRING);
    $garage_size = filter_var(trim($_POST['garage_size']), FILTER_SANITIZE_STRING);
    $date = filter_var(trim($_POST['date_listed']), FILTER_SANITIZE_STRING);
    $basement = filter_var(trim($_POST['basement']), FILTER_SANITIZE_STRING);
    $bhk = filter_var(trim($_POST['bhk']), FILTER_SANITIZE_STRING);
    $structure_type = filter_var(trim($_POST['dropdown_structure_type']), FILTER_SANITIZE_STRING);
    $floors = filter_var(trim($_POST['dropdown_floors']), FILTER_SANITIZE_STRING);

    // Handle amenities (Checkboxes)
    $amenities = [];
    if (isset($_POST['equipped_kitchen'])) $amenities[] = 'Equipped Kitchen';
    if (isset($_POST['gym'])) $amenities[] = 'Gym';
    if (isset($_POST['laundry'])) $amenities[] = 'Laundry';
    if (isset($_POST['media_room'])) $amenities[] = 'Media Room';
    if (isset($_POST['back_yard'])) $amenities[] = 'Back Yard';
    if (isset($_POST['basketball_court'])) $amenities[] = 'Basketball Court';
    if (isset($_POST['front_yard'])) $amenities[] = 'Front Yard';
    if (isset($_POST['garage_attached'])) $amenities[] = 'Garage Attached';
    if (isset($_POST['hot_bath'])) $amenities[] = 'Hot Bath';
    if (isset($_POST['pool'])) $amenities[] = 'Pool';

    // Handle images
    $image_names = [];
    for ($i = 1; $i <= 5; $i++) {
        if (!empty($_FILES["image_0$i"]['name'])) {
            $image = $_FILES["image_0$i"]['name'];
            $image_ext = pathinfo($image, PATHINFO_EXTENSION);
            $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array(strtolower($image_ext), $allowed_ext)) {
                $rename_image = create_unique_id() . '.' . $image_ext;
                $image_tmp_name = $_FILES["image_0$i"]['tmp_name'];
                $image_size = $_FILES["image_0$i"]['size'];
                $image_folder = 'upload-images/' . $rename_image;

                if ($image_size <= 10000000) {
                    move_uploaded_file($image_tmp_name, $image_folder);
                    $image_names[] = $rename_image;
                } else {
                    $warning_msg[] = "Image 0$i size is too large!";
                }
            } else {
                $warning_msg[] = "Image 0$i has an invalid file extension!";
            }
        } else {
            $image_names[] = '';
        }
    }

    while (count($image_names) < 5) {
        $image_names[] = '';
    }


    // Get location details
    $address = filter_var(trim($_POST['adress']), FILTER_SANITIZE_STRING); // Fixed to 'adress'
    $country = filter_var(trim($_POST['country']), FILTER_SANITIZE_STRING);
    $state = filter_var(trim($_POST['state']), FILTER_SANITIZE_STRING);
    $city = filter_var(trim($_POST['city']), FILTER_SANITIZE_STRING);
    $zip = filter_var(trim($_POST['zip']), FILTER_SANITIZE_STRING);

    // Insert data into the database
    $insert_property = $conn->prepare("INSERT INTO `property` (id, user_id, title, description, price, price_label, property_type, offer, status, image_01, image_02, image_03, image_04, image_05, address, country, state, city, zip, size, lot_size, rooms, bedrooms, bathrooms, custom_id, garages, house_age, garage_size, date_listed, basement, bhk, structure_type, floors, amenities) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?,?,?)");
   
    $insert_property->execute([$id, $user_id, $title, $description, $price, $price_label, $category_1, $category_2, $category_3, $image_names[0], $image_names[1], $image_names[2], $image_names[3], $image_names[4], $address, $country, $state, $city, $zip, $size, $lot_size, $rooms, $bedrooms, $bathrooms, $custom_id, $garages, $house_age, $garage_size,$date, $basement, $bhk, $structure_type, $floors, json_encode($amenities)]);

    $success_msg[] = 'Property posted successfully!';
}


include('./components/save_send.php')
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HouseHunt - Listing Page</title>
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">
  <link rel="stylesheet" href="./assets/css/style_copy.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
  <?php include ('./components/user_header.php') ?>
  <main>
    <div class="listing-hero-content" style="background-image: url('./assets/images/Bg-image.jpg'); height: 20em; background-repeat: no-repeat;">
      <div id="listing-hero-container">
        <h2>Add Listing</h2>
        <p class="listing-hero-subtitle">
          <ion-icon name="home"></ion-icon>
          <span><a href="index.html">Home</a></span>
          <ion-icon name="chevron-forward-outline"></ion-icon>
          <span>Add listing</span>
        </p>
      </div>
    </div>

    <form method="POST" enctype="multipart/form-data" class="add-listings">

      <div class="tabs">
        <ul class="tab-list">
          <li class="tab-item active">1. Description</li>
          <li class="tab-item">2. Media</li>
          <li class="tab-item">3. Location</li>
          <li class="tab-item">4. Details</li>
          <li class="tab-item">5. Amenities</li>
        </ul>
      </div>

      <h3>Property Description</h3>
      <div class="form-group">
        <label for="title">*Title (mandatory)</label>
        <input type="text" id="title" name="title" placeholder="Enter title" required>
      </div>
      <div class="form-group">
        <label for="description">Description</label>
        <textarea id="description" name="description" placeholder="Enter description"></textarea>
      </div>

      <!-- First Row -->
      <div class="row">
        <div class="form-group">
          <label for="price">Price in $ (only numbers)</label>
          <input type="text" id="price" placeholder="Price in $ (only numbers)" name="price">
        </div>
        <div class="form-group">
          <label for="afterPrice">After Price Label (ex: /month)</label>
          <input type="text" name="price_label" placeholder="ex: /month">
        </div>
      </div>
          <!-- Category Section -->
          <h3>Select Categories</h3>
          <div class="row">
            <div class="form-group">
              <select name="property_type">
                <option>None</option>
                <option>Appartment</option>
                <option>House</option>
                <option>flat</option>
                <option>Office</option>
                <option>Shop</option>
                <option>Villa</option>
              </select>
            </div>
            <div class="form-group">
              <select name="offer">
                <option>None</option>
                <option>Rental</option>
                <option>Sales</option>
              </select>
            </div>
            <div class="form-group">
              <select name="status">
                <option>No Status</option>
                <option>Active</option>
                <option>Sold</option>
              </select>
            </div>
          </div>
          <div class="form-section">
        <h3>Listing Details</h3>
          <!-- First Row -->
          <div class="row">
            <div class="form-group">
              <input type="text" placeholder="Size in ft² (*only numbers)" name="size">
            </div>
            <div class="form-group">
              <input type="text" placeholder="Lot Size in ft² (*only numbers)" name="lot_size">
            </div>
          </div>
          <!-- Second Row -->
          <div class="row">
            <div class="form-group">
              <input type="text" placeholder="Rooms (*only numbers)" name="rooms">
            </div>
            <div class="form-group">
              <input type="text" placeholder="Bedrooms (*only numbers)" name="bedrooms">
            </div>
          </div>
          <div class="row">
            <div class="form-group">
              <input type="text" placeholder="Bathrooms (*only numbers)" name="bathrooms">
            </div>
            <div class="form-group">
              <input type="text" placeholder="Custom ID (*text)" name="custom_id">
            </div>
          </div>
          <div class="row">
            <div class="form-group">
              <input type="text" placeholder="Garages (*text)" name="garages">
            </div>
            <div class="form-group">
              <input type="text" placeholder="Age of House (*numeric)" name="house_age">
            </div>
          </div>
          <div class="row">
            <div class="form-group">
              <input type="text" placeholder="Garage Size (*text)" name="garage_size">
            </div>
            <div class="form-group">
              <input type="date" placeholder="Date_Listed" name="date_listed">
            </div>
          </div>
          <div class="row">
            <div class="form-group">
              <input type="text" placeholder="Basement (*text)" name="basement">
            </div>
            <div class="form-group">
              <input type="text" placeholder="Enter BHK" name="bhk">
            </div>
          </div>
          <div class="row">
            <div class="form-group">
              <select name="dropdown_structure_type" id="dropdown structure_type">
                <option value="Not Available">Structure Type</option>
                <option value="Bricks">Bricks</option>
                <option value="Wood">Wood</option>
                <option value="Cement">cement</option>
              </select>
            </div>

            <div class="form-group">
              <select name="dropdown_floors" id="dropdown floors">
                <option value="Not Available">Floors No.</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
              </select>
            </div>

            
          </div>
          <div class="form-group">
        <h3>Amenities</h3>
          <div class="section">
            <div class="checkbox-group" id="amenity_name">
              <label><input type="checkbox" name="equipped_kitchen"> Equipped Kitchen</label>
              <label><input type="checkbox" name="gym"> Gym</label>
              <label><input type="checkbox" name="laundry"> Laundry</label>
              <label><input type="checkbox" name="media_room"> Media Room</label>
              <label><input type="checkbox" name="back_yard"> Back yard</label>
              <label><input type="checkbox" name="basketball_court"> Basketball court</label>
              <label><input type="checkbox" name="front_yard"> Front yard</label>
              <label><input type="checkbox" name="garage_attached"> Garage Attached</label>
              <label><input type="checkbox" name="hot_bath"> Hot Bath</label>
              <label><input type="checkbox" name="pool"> Pool</label>
            </div>
          </div>
      </div>
      <h3>Listing Media</h3>
        <div class="form-group">
          <label for="file1" class="custom-file-upload">Choose image 1</label>
          <input id="file1" type="file" name="image_01" required >
          <span class="file-name">No file chosen</span>
          
          <label for="file2" class="custom-file-upload">Choose image 2</label>
          <input id="file2" type="file" name="image_02"  >
          <span class="file-name2">No file chosen</span>

          <label for="file3" class="custom-file-upload">Choose image 3</label>
          <input id="file3" type="file" name="image_03" >
          <span class="file-name3">No file chosen</span>

          <label for="file4" class="custom-file-upload">Choose image 4</label>
          <input id="file4" type="file" name="image_04" >
          <span class="file-name4">No file chosen</span>

          <label for="file5" class="custom-file-upload">Choose image 5</label>
          <input id="file5" type="file" name="image_05">
          <span class="file-name5">No file chosen</span>
          
          <p>* At least 1 image is required for a valid submission. Minimum size is 500/500px.</p>
          <p>* Images might take longer to be processed.</p>
        </div>

        <h3>Video Option</h3>
        <div class="form-group">
          <label for="file-video" class="custom-file-upload">Choose File</label>
          <input id="file-video" type="file" />
          <span class="file-name">No file chosen</span>
          <p>* Videos might take longer to be processed.</p>
        </div>


        <h3>Listing Location</h3>
        <div class="form-group">
          <input type="text" id="adress" name="adress" placeholder="*Adress" required>
          </div>
          <!-- First Row -->
          <div class="row">
            <div class="form-group">
              <input type="text" id="country" name="country" placeholder="Country">

            </div>
            <div class="form-group">
              <input type="text" id="state" name="state" placeholder="state">
            </div>
          </div>
          <!-- Second Row -->
          <div class="row">
            <div class="form-group">
              <input type="text" id="City" name="city" placeholder="City">
            </div>
            <div class="form-group">
              <input type="text" id="Zip" name="zip" placeholder="Zip Code">
            </div>
          </div>
          <button type="submit" class="btn" name="post">Submit</button>
    </form>

  </main>
  <?php include ('./components/footer.php') ?>
  <?php include ('./components/message.php') ?>
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

    document.addEventListener('DOMContentLoaded', function() {
  function updateFileName(inputElement, fileNameElement) {
    inputElement.addEventListener('change', function(event) {
      const fileInfo = event.target.files[0] ? event.target.files[0].name : 'No file chosen';
      fileNameElement.textContent = fileInfo;
    });
  }

  const fileInputs = [
    { input: document.getElementById('file1'), nameElement: document.querySelector('.file-name') },
    { input: document.getElementById('file2'), nameElement: document.querySelector('.file-name2') },
    { input: document.getElementById('file3'), nameElement: document.querySelector('.file-name3') },
    { input: document.getElementById('file4'), nameElement: document.querySelector('.file-name4') },
    { input: document.getElementById('file5'), nameElement: document.querySelector('.file-name5') },
    { input: document.getElementById('file-video'), nameElement: document.querySelector('.file-name') }
  ];

  fileInputs.forEach(fileInput => {
    updateFileName(fileInput.input, fileInput.nameElement);
  });
});

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
  <script src="./assets/js/script.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
</body>

</html>