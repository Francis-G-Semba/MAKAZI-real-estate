<?php session_start();

if (!isset($_SESSION['id'])) {
  // Redirect to the login form
  header("Location: index.php");
  exit();
}
// Set the cache control headers
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize the form inputs
    if (isset($_POST['property_type'], $_POST['status'], $_POST['location'], $_POST['bedrooms'], $_POST['price'], $_POST['description'])) {
        $propertyType = htmlspecialchars($_POST['property_type'], ENT_QUOTES, 'UTF-8');
        $status = htmlspecialchars($_POST['status'], ENT_QUOTES, 'UTF-8');
        $location = htmlspecialchars($_POST['location'], ENT_QUOTES, 'UTF-8');
        $bedrooms = intval($_POST['bedrooms']);
        $price = floatval($_POST['price']);
        $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');

        // Validate required fields
        if (empty($propertyType) || empty($status) || empty($location) || empty($price) || empty($description)) {
            // Handle validation error, display an error message or redirect back to the form with an error notification
            exit("Please fill in all required fields.");
        }

        // Connect to the database (replace with your database credentials)
        $host = 'localhost';
        $dbUsername = 'root';
        $dbPassword = '';
        $dbName = 'real_estate';

        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO properties (property_type, property_status, location, bedrooms, price, description) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssids", $propertyType, $status, $location, $bedrooms,  $price, $description);

        // ...

// Execute the statement and check for success
if ($stmt->execute()) {
  $propertyId = $stmt->insert_id;
  // Handle successful insertion, display success message or redirect to a success page
  echo "Property added successfully. Property ID: " . $propertyId;

  // Fetch the inserted row
  $stmt->close();
  $stmt = $conn->prepare("SELECT * FROM properties WHERE property_id = ?");
  $stmt->bind_param("i", $propertyId);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

  // Check if any file is uploaded
  if (isset($_POST['upload'])) {
      // Retrieve the file details for the main image
      $mainImageName = $_FILES["uploadfile"]["name"];
      $mainImageTempName = $_FILES["uploadfile"]["tmp_name"];
      $mainImageFolder = "../images/" . $mainImageName;

      // Retrieve the file details for image 1
      $image1Name = $_FILES["image_2"]["name"];
      $image1TempName = $_FILES["image_2"]["tmp_name"];
      $image1Folder = "../images/" . $image1Name;

      // Retrieve the file details for image 2
      $image2Name = $_FILES["image_3"]["name"];
      $image2TempName = $_FILES["image_3"]["tmp_name"];
      $image2Folder = "../images/" . $image2Name;

      // Prepare and execute the SQL statements
      $stmt2 = $conn->prepare("INSERT INTO property_images (property_id, image_url, image_2, image_3) VALUES (?, ?, ?, ?)");
      $stmt2->bind_param("isss", $propertyId, $mainImageName, $image1Name, $image2Name);

      if ($stmt2->execute()) {
          // Move the uploaded files to the designated folders
          move_uploaded_file($mainImageTempName, $mainImageFolder);
          move_uploaded_file($image1TempName, $image1Folder);
          move_uploaded_file($image2TempName, $image2Folder);

          echo "Images uploaded successfully.";
      } else {
          echo "Failed to upload images.";
      }

      $stmt2->close();
  }
} else {
  // Handle insertion failure, display error message or redirect back to the form with an error notification
  echo "Error inserting property: " . $stmt->error;
}

$stmt->close();
$conn->close();

    }
  }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/more.css">
    <?php  require('../include/links.php') ?>
    <title>ADD PROPERTY</title>
    <style>

      a{
        text-decoration: none;
        color: #32c48d;
      }

      a:hover{
        color: black;
      }

      #dashboard-menu {
        position: fixed;
        height: 100%;
      }

      @media screen and (max-width: 991px){
        #dashboard-menu {
          height: auto;
          width: 100%;
        }

        #main-content{
          margin-top: 60px;
        }
      }
      .navbar-dark .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e ") !important;
      }

      .dropdown-menu{
        background-color: whitesmoke !important;
      }
      
    </style>
</head>
<body class="bg-light">

    <div class="container-fluid bg-dark text-light p-3 d-flex align-items-center justify-content-between sticky-top">
      <h3 class="mb-0">Admin Dashboard</h3>
      <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
    </div>

  <div class="col-lg-2 bg-dark border-top border-3 border-secondary" id="dashboard-menu">
    <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container-fluid flex-lg-column align-items-stretch">
      <h4 class="mt-2 text-light"><a href="dashboard.php">Home</a></h4>
        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#adminDropdown" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="adminDropdown">
        <ul class="nav nav-pills flex-column">
          <li class="nav-item">
            <a  class="nav-link text-white" href="#" >Users</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" >Properties</a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li>
                  <a class="dropdown-item" href="add_property.php">Add Property</a>
                </li>
                <li>
                  <a class="dropdown-item" href="property_list.php">Property List</a>
                </li>
              </ul>
            </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="inquiries.php" >Inquiries</a>
          </li>
        </ul>
       </div>
      </div>
    </nav>
  </div>

  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-10 ms-auto p-4 overflow-hidden" id="main-content">

      <div class="container ">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-6 mb-5 px-4">
                <div class="bg-white rounded shadow p-4">
                    <h4 class="fw-bold text-center">
                        Real Estate Mwanza
                    </h4>

    <form action="add_property.php" method="POST" enctype="multipart/form-data" >
        <h5 class="fw-bold">Add Property</h5>
        <div class="mt-3">
        <label class="form-label" style="font-weight: 500;" for="property_type">Property Type:</label>
        <select class="form-select shadow-none" name="property_type" id="property_type">
            <option value="House">House</option>
            <option value="Land">Land</option>
            <option value="Office">Office</option>
        </select>
        </div>
        <div class="mt-3">
        <label for="status">Status:</label>
            <select class="form-select shadow-none" name="status" id="status">
                <option value="For Rent">For Rent</option>
                <option value="For Sale">For Sale</option>
            </select>
        </div>
        <div class="mt-3">
            <label class="form-label" style="font-weight: 500;" for="location">Location:</label>
            <input class="form-control shadow-none" type="text" name="location" id="location">
        </div>
        <div class="mt-3">
            <label class="form-label" style="font-weight: 500;" for="bedrooms">Bedrooms:</label>
            <input class="form-control shadow-none" type="number" name="bedrooms" id="bedrooms">
        </div>
        <div class="mt-3">
            <label class="form-label" style="font-weight: 500;" for="price">Price:</label>
            <input class="form-control shadow-none" type="number" name="price" id="price">
        </div>
        <div class="mt-3">
            <label class="form-label" style="font-weight: 500;" for="description">Description:</label>
            <textarea class="form-control shadow-none" rows="5" style="resize: none;" name="description" id="description"></textarea>
        </div>
        <div class="mt-3">
            <label class="form-label" style="font-weight: 500;" for="images">Images:</label>
            <input class="form-control shadow-none" type="file" name="uploadfile" id="images" multiple>
        </div>
        <div class="mt-3">
          <label class="form-label" style="font-weight: 500;" for="image1">Image 1:</label>
          <input class="form-control shadow-none" type="file" name="image_2" id="image1">
      </div>
      <div class="mt-3">
          <label class="form-label" style="font-weight: 500;" for="image2">Image 2:</label>
          <input class="form-control shadow-none" type="file" name="image_3" id="image2">
      </div>

        <input type="submit" name="upload" class="btn btn-dark shadow-none mt-3" value="Add Property">
    </form>


                </div>
            </div>
        </div>
    </div>
      </div>
    </div>
  </div>











   <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
