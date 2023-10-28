<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAKAZI Real Estates</title>
    <link rel="stylesheet" href="path/to/swiper.min.css">
    <link rel="stylesheet" href="CSS/more.css">
    <?php include('include/links.php') ?>
    <style>
        .swiper-container {
            width: 95%;
            margin: 0 auto; /* to center the container */
        }

        .search_function {
            margin-top: -95px;
            z-index: 2;
            position: relative;
        }

        @media screen and (max-width: 575px) {
            .search_function {
                margin-top: 15px;
                padding: 0 10px;
            }
        }
    </style>
</head>

<body class="bg-light">

    <!-- CAROUSEL -->
    <div class="container-fluid px-lg-4 mt-4">
        <div class="swiper slider-content">
            <div class="slider-content">
                <div class="card-wrapper swiper-wrapper">
                    <?php

                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "real_estate";

                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT * FROM properties ORDER BY RAND()";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Generate property cards based on the fetched data
                        while ($row = $result->fetch_assoc()) {
                            ?>
			
                            <div class="col-lg-4 col-md-6 my-3">
                                <div class="card border-0 shadow" style="max-width: 350px; margin: auto; max-height: 500px; min-height: 400px;">
                                    <div style="height: 200px; overflow: hidden;">
                                        <?php
                                            // Retrieve the property images associated with the current property
                                            $propertyId = $row['property_id'];
                                            $imagesQuery = "SELECT * FROM property_images WHERE property_id = ?";
                                            $stmt = $conn->prepare($imagesQuery);
                                            $stmt->bind_param("i", $propertyId);
                                            $stmt->execute();
                                            $imagesResult = $stmt->get_result();

                                            // Display the first image if available
                                            if ($imagesResult->num_rows > 0) {
                                                $firstImage = $imagesResult->fetch_assoc();
                                                ?>
                                                <!-- Property Image -->
                                                <img src="images/<?php echo htmlspecialchars($firstImage['image_url']); ?>" class="card-img-top" style="height: 100%; object-fit: cover;">
                                            <?php
                                            } else {
                                                // Display a default image if no images are available
                                            ?>
                                                <img src="images/default.jpg" class="card-img-top" style="height: 100%; object-fit: cover;">
                                        <?php
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
                    } else {
                        echo "No properties found.";
                    }

                    $conn->close();
                    ?>
                </div>
                <div class="swipe-pagination"></div>
                <!-- <div class="swipe-button-next"></div>
                <div class="swipe-button-prev"></div> -->
            </div>
        </div>
    </div>

    <!-- Add your footer content here -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.2/js/bootstrap.bundle.min.js" integrity="sha512-pv5/5Dg7VruhN35C5NzvNjKZ5gkN5O5Wq3PpK5y83LGLJvy33kjzkW9V8FvKx5l5NSLEu5P5yljKUo00Mtrfww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

    <script>
        var swiper = new Swiper(".slider-content", {
            slidesPerView: 3,
            spaceBetween: 0,
            loop: true,
            autoplay: {
                delay: 7000, // Adjust the delay (in milliseconds) between slides
                disableOnInteraction: false, // Allow user interaction to stop autoplay
            },
            centerSlide: 'true',
            fade: 'true',
            grabCursor: 'true',
            pagination: {
                el: ".swipe-pagination",
                clickable: true,
                dynamicBullets: true,
            },
            navigation: {
                nextEl: ".swipe-button-next",
                prevEl: ".swipe-button-prev",
            },

            breakpoints: {
                0: {
                    slidesPerView: 1,
                },
                520: {
                    slidesPerView: 2,
                },
                950: {
                    slidesPerView: 3,
                },
            },
        });
    </script>
</body>

</html>
