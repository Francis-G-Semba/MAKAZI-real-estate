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

// Fetch image data for the selected ID from the database
$sql = "SELECT image_id, image_url, image_2, image_3 FROM property_images WHERE property_id = " . $propertyId;
$result = $db->query($sql);

// Create a variable to store the image URLs
$imageUrls = [];

if ($result->num_rows > 0) {
    // Retrieve the image URLs from the fetched row
    $row = $result->fetch_assoc();
    $imageUrls = [$row['image_url'], $row['image_2'], $row['image_3']];
}

// Close the database connection
$db->close();
?>
    


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Details</title>
    <link rel="stylesheet" href="CSS/more.css">
    <?php include 'include/links.php'; ?>

    <style>
    a{
      text-decoration: none !important;
    }
      .position-absolute {
          position: absolute;
      }

      .start-0 {
          left: 0;
      }

      .end-0 {
          right: 0;
      }

      .top-50 {
          top: 50%;
      }

      .translate-middle-y {
          transform: translateY(-50%);
      }
        button {
          text-decoration: none !important;
          display: inline-block;
          padding: 8px 16px;
          border: none !important;
        }

        button:hover{
          background-color: #ddd;
          color: black;
        }

        .previous{
          background-color: #04AA6D;
          color: white;

        }
        .next{
          background-color: #04AA6D;
          color: white;

        }

        .fix {
            max-width: 600px;
            word-wrap: break-word !important;
        }
    </style>
</head>

<body class="bg-light">
    <?php include "include/header.php"; ?>

    <div class="my-2 px-4">
        <h2 class="fw-bold h-font text-center">Property Details</h2>
        <div class="h-line"></div>
        <div class="h-line2"></div>
    </div>

    <div class="container">
        <div class="row">
        <div class="col-lg-8 col-md-6 col-sm-12 d-flex my-2 overflow-hidden position-relative justify-content-center align-items-center">
            <?php
                $currentImageIndex = 0; ?>

                <div id="imageContainer" class="w-100 d-flex justify-content-center" style="max-height: 500px;">
                  <img src="images/<?php echo $imageUrls[$currentImageIndex]; ?>" class="overflow-hidden rounded">
                </div>
                
                <button class="previous position-absolute start-0 top-50 translate-middle-y" onclick="showPreviousImage()">
                    &#8249
              </button>
              <button class="next position-absolute end-0 top-50 translate-middle-y" onclick="showNextImage()">
                    &#8250
              </button>               
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12 my-2 p-0 shadow overflow-hidden fix" style="max-width: 500px;">
                <div class="bg-white rounded p-4">
                    <h3 class="fw-bold text-center">Description</h3>
                    <h3 class="fw-bold ps-2 m-0" style="color:#32c48d;"><?php echo $property['property_status']; ?></h3>
                    <hr class="mt-0 mb-2">
                    <p class="fw-bold ps-2" style="max-width: 350px;">Description: <?php echo $property['description']; ?></p>
                    <p class="fw-bold ps-2">Location: <?php echo $property['location']; ?></p>
                    <p class="fw-bold ps-2">Price: <?php echo $property['price']; ?></p>
                    <hr class="mb-2">
                    <h3 class="fw-bold text-center">Contact</h3>
                    <p class="fw-bold ps-2">Call: <a href="tel:+255 768 808 083">+255 768 808 083</a> <i class="bi bi-telephone-fill"></i></p>
                    <p class="fw-bold ps-2">Whatsapp: <a href="https://wa.me/+255788880634?text=welcome">+255 788 880 634</a> <i class="bi bi-whatsapp"></i></p>
                    <p class="fw-bold ps-2">E-mail: <a href="makazi@gmail.com">makazi@gmail.com</a> <i class="bi bi-envelope-fill"></i></p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mt-4 px-4">
                <div class="bg-light rounded shadow p-2">
                    <h4 class="fw-bold text-center">More Properties</h4>
                </div>  
            </div>

            <?php include "carousel.php"; ?>
        </div>
    </div>

    <?php include "include/footer.php"; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.2/js/bootstrap.bundle.min.js" integrity="sha512-pv5/5Dg7VruhN35C5NzvNjKZ5gkN5O5Wq3PpK5y83LGLJvy33kjzkW9V8FvKx5l5NSLEu5P5yljKUo00Mtrfww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    var imageContainer = document.getElementById('imageContainer');
    var imageUrls = <?php echo json_encode($imageUrls); ?>;
    var currentImageIndex = <?php echo $currentImageIndex; ?>;

    // Function to display the next image
    function showNextImage() {
        currentImageIndex = (currentImageIndex + 1) % imageUrls.length;
        imageContainer.innerHTML = '<img src="images/' + imageUrls[currentImageIndex] + '" >';
    }

    // Function to display the previous image
    function showPreviousImage() {
        currentImageIndex = (currentImageIndex - 1 + imageUrls.length) % imageUrls.length;
        imageContainer.innerHTML = '<img src="images/' + imageUrls[currentImageIndex] + '" >';
    }

    // Add event listeners for keyboard navigation
    document.addEventListener('keydown', function (event) {
        if (event.key === 'ArrowRight') {
            showNextImage();
        } else if (event.key === 'ArrowLeft') {
            showPreviousImage();
        }
    });
</script>
<script>
  $(document).ready(function () {
    $('.dropdown-toggle').dropdown();
  });
</script>

</body>
</html>

