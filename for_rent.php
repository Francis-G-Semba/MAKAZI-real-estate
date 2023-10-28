<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rocks Real Estates</title>
    <link rel="stylesheet" href="CSS/more.css">
    <?php  include('include/links.php') ?>
   <style>
    .swiper-container {
        width: 95%;
        margin: 0 auto; /* to center the container */
        }
     
    </style>

</head>
<body class="bg-white">

<?php include("include/header.php") ?>


<div class="my-4 px-4 ">
        <h2 class="fw-bold h-font text-center">Properties For Rent</h2>
        <div class="h-line "></div>
        <div class="h-line2 "></div>
        <p class="text-center mt-3">
            Lorem ipsum dolor sit amet consectetur adipisicing  <br>
            cum accusantium, modi tenetur laudantium rem minus <br>
        </p>
    </div>

<div class="container">
    <div class="row">
    <?php
// Establish database connection (replace with your database credentials)
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

// Pagination settings
$resultsPerPage = 9;
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($currentPage - 1) * $resultsPerPage;

// Retrieve the "For Rent" properties from the database with pagination
$query = "SELECT * FROM properties WHERE property_status = 'For Rent' ORDER BY property_id DESC LIMIT $offset, $resultsPerPage";
$result = $db->query($query);

// Check if any properties are found
if ($result->num_rows > 0) {
    // Display the properties
    while ($row = $result->fetch_assoc()) {
        ?>
            <div class="col-lg-4 col-md-6 my-3">
  <div class="card border-0 shadow" style="max-width: 350px; margin: auto; max-height: 500px; min-height: 400px;">
    <div style="height: 200px; overflow: hidden;">
    <?php
        // Retrieve the property images associated with the current property
        $propertyId = $row['property_id'];
        $imagesQuery = "SELECT * FROM property_images WHERE property_id = ?";
        $stmt = $db->prepare($imagesQuery);
        $stmt->bind_param("i", $propertyId);
        $stmt->execute();
        $imagesResult = $stmt->get_result();

        // Display the first image if available
        if ($imagesResult->num_rows > 0) {
            $firstImage = $imagesResult->fetch_assoc();
            ?>
            <!-- Property Image -->
            <img src="images/<?php echo htmlspecialchars($firstImage['image_url']); ?>" class="card-img-top" style="height: 100%; object-fit: cover;">            <?php
        } else {
            // Display a default image if no images are available
            ?>
        <img src="images/default.jpg" class="card-img-top" style="height: 100%; object-fit: cover;">            <?php
        }
        ?>
        </div>
    <div class="card-body" style="overflow-y: auto;">
            <!-- Property Type -->
            <h4 style="color:#32c48d;"><?php echo htmlspecialchars($row['property_type']); ?> <?php echo htmlspecialchars($row['property_status']); ?></h4>
            <!-- Location -->
            <p><?php echo htmlspecialchars($row['location']); ?></p>
            <!-- Price -->
            <p>Price: <?php echo htmlspecialchars($row['price']); ?></p>
            <!-- Description -->
            <p><?php echo htmlspecialchars($row['description']); ?></p>
            <!-- Add more property details as needed -->
            <hr>
            <!-- View Details Button -->
            <div class="d-flex justify-content-between">
                <div class="agent">
                    <div class="text-capitalize"><i class="bi bi-person-vcard-fill p-1 " style="font-size: 1.2rem;"></i>Agent</div>
                </div>
                <a href="property_details.php?id=<?php echo $row['property_id']; ?>" class="btn btn-primary">View Details</a>
            </div>
        </div>
    </div>
</div>
            
        <?php
    }

    // Pagination
    $totalPropertiesQuery = "SELECT COUNT(*) as total FROM properties WHERE property_status = 'For Rent'";
    $totalPropertiesResult = $db->query($totalPropertiesQuery);
    $totalProperties = $totalPropertiesResult->fetch_assoc()['total'];
    $totalPages = ceil($totalProperties / $resultsPerPage);

    if ($totalPages > 1) {
        ?>
        <div class="col-12">
            <nav aria-label="Properties Pagination" class="mt-4">
                <ul class="pagination justify-content-center">
                    <?php
                    if ($currentPage > 1) {
                        ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>">Previous</a>
                        </li>
                        <?php
                    }

                    for ($i = 1; $i <= $totalPages; $i++) {
                        ?>
                        <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                        <?php
                    }

                    if ($currentPage < $totalPages) {
                        ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>">Next</a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </nav>
        </div>
        <?php
    }
} else {
    echo "No properties available for rent.";
}

// Close the database connection
$db->close();
?>


    </div>
</div>






<!-- FOOTER -->
<?php include('include/footer.php') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.2/js/bootstrap.bundle.min.js" integrity="sha512-pv5/5Dg7VruhN35C5NzvNjKZ5gkN5O5Wq3PpK5y83LGLJvy33kjzkW9V8FvKx5l5NSLEu5P5yljKUo00Mtrfww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper(".swiper-container", {
      slidesPerView: 1,
      spaceBetween: 30,
      loop: true,
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
<script>
    var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
    dropdownElementList.map(function (dropdownToggleEl) {
        return new bootstrap.Dropdown(dropdownToggleEl)
    })
  </script>


</body>
</html>