<?php
// Retrieve the property ID from the URL parameter
$propertyId = $_GET['id'];

// Connect to the database (replace with your database credentials)
$host = 'localhost';
$dbName = 'real_estate';
$username = 'root';
$password = '';

// Create a new MySQLi instance
$db = new mysqli($host, $username, $password, $dbName);

// Check the database connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Prepare and execute the SQL query to retrieve the property details
$stmt = $db->prepare("SELECT * FROM properties WHERE property_id = ?");
$stmt->bind_param("i", $propertyId);
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Fetch the property details
$property = $result->fetch_assoc();

// Check if the property exists
if (!$property) {
    // Handle the case when the property doesn't exist
    echo "Property not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Details</title>
    <link rel="stylesheet" href="CSS/more.css">
    <?php include('include/links.php') ?>
    <style>
        .swiper-container {
            width: 95%;
            margin: 0 auto;
        }
    </style>
</head>

<body class="bg-white">
    <?php include("include/header.php") ?>

    <div class="my-2 px-4">
        <h2 class="fw-bold h-font text-center">Property Details</h2>
        <div class="h-line "></div>
        <div class="h-line2 "></div>
    </div>

    <div class="container">
  <div class="row">
    <div class="col-lg-8 col-md-6 col-sm-12 d-flex my-2" id="1">
      <?php
      // Retrieve the property images associated with the current property
      $imagesQuery = "SELECT * FROM property_images WHERE property_id = ?";
      $stmt = $db->prepare($imagesQuery);
      $stmt->bind_param("i", $propertyId);
      $stmt->execute();
      $imagesResult = $stmt->get_result();

      // Check if any images are found
      if ($imagesResult->num_rows > 0) {
      ?>

        <div class="swiper-container">
          <div class="swiper-wrapper">
            <?php
            // Display the images in the Swiper carousel
            while ($image = $imagesResult->fetch_assoc()) {
            ?>
              <div class="swiper-slide overflow-hidden rounded">
                <img src="images/<?php echo $image['image_url']; ?>" class="w-100" style="max-height: 500px;">
              </div>
            <?php
            }
            ?>
          </div>
          <div class="swiper-pagination"></div>
        </div>

      <?php
      } else {
        // Display a default image if no images are found
      ?>
        <img src="default-image.jpg" class="w-100" style="max-height: 500px;">
      <?php
      }
      ?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12 my-2" id="2">
      <h1>Property Details</h1>
      <h2>Property Type: <?php echo $property['property_type']; ?></h2>
      <p>Location: <?php echo $property['location']; ?></p>
      <p>Price: <?php echo $property['price']; ?></p>
    </div>
  </div>
</div>


    <?php include("carousel.php")?>

    <?php include("include/footer.php") ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.2/js/bootstrap.bundle.min.js" integrity="sha512-pv5/5Dg7VruhN35C5NzvNjKZ5gkN5O5Wq3PpK5y83LGLJvy33kjzkW9V8FvKx5l5NSLEu5P5yljKUo00Mtrfww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
  var swiper = new Swiper(".swiper-container", {
    slidesPerView: 1,
    spaceBetween: 0,
    loop: true,
    autoplay: {
      delay: 7000, // Adjust the delay (in milliseconds) between slides
      disableOnInteraction: false, // Allow user interaction to stop autoplay
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });
</script>
</body>
</html>

