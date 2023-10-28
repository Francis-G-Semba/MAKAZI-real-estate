    <?php
            // Check if the form is submitted
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Get the form data
            $name = $_POST['name'];
            $email = $_POST['email'];
            $number = $_POST['telno'];
            $textarea = $_POST['textarea'];
            $option = $_POST['options'];

            // Validate the form data (you can add more validations here)
            if (empty($name) || empty($email) || empty($number) || empty($textarea) || empty($option)) {
                echo "Please fill all the required fields";
                exit;
            }

            // Connect to the database
            $host = "localhost";
            $username = "root";
            $password = "";
            $database = "real_estate";
            $conn = mysqli_connect($host, $username, $password, $database);

            // Check if the connection was successful
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Insert the form data into the database
            $sql = "INSERT INTO Inquiries (name, email, number, textarea, options) VALUES ('$name', '$email', '$number', '$textarea', '$option')";
            if (mysqli_query($conn, $sql)) {
                echo " Form data sent successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }

            // Close the database connection
            mysqli_close($conn);
            }
    ?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- normal css style -->
   <link rel="stylesheet" href="CSS/more.css">
   <?php  require('include/links.php') ?>
  
    <title>Real Estate</title>
</head>


<body class="bg-light">
  <?php include('include/header.php')  ?>

  <div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">Contact Us</h2>
    <div class="h-line "></div>
    <div class="h-line2 "></div>
   
  </div>

    <div class="container ">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-6 mb-5 px-4">
                <div class="bg-white rounded shadow p-4">
                    <h4 class="fw-bold text-center">
                        Real Estate Mwanza
                    </h4>
                    <p class="mt-3 text-center">
                        Thank You for visiting our website. Please feel free to ask any question on the properties, products and services you are intersted in. We welcome any comments or suggestions to enhance your expirience.
                    </p>

                    <form method="POST">
                        <h5 class="fw-bold">Send a message</h5>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">Name (required)</label>
                            <input type="text" name="name" class="form-control shadow-none">
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">Telephone no. (required)</label>
                            <input type="number" name="telno" class="form-control shadow-none">
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">Email Address (required)</label>
                            <input type="email" name="email" class="form-control shadow-none">
                        </div>
                        <div class="mt-3">
                         <label class="form-label" style="font-weight: 500;" >Subject (required)</label>
                            <select name="options" class="form-select shadow-none">
                                <option value="" selected disabled>What would you like to inquire about?</option>
                                <option value="Purchasing/Renting Property">Purchasing/Renting Property</option>
                                <option value="Advertising">Advertising</option>
                                <option value="Agent Registration">Agent Registration</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">Your Message</label>
                            <textarea name="textarea"class="form-control shadow-none" rows="5" style="resize: none;"></textarea>
                        </div>

                        <button type="submit" class="btn btn-dark shadow-none mt-3" >SEND</button>

                        <hr>
                        <div class="text-center">
                            <h4 class="fw-bold text-center">Find Us On Social Media </h4>
                            <a href="#" class="d-inline-block mb-3 text-dark fs-5 me-2">
                                <i class="bi bi-twitter me-1"></i>
                            </a>
                            <a href="#" class="d-inline-block mb-3 text-dark fs-5 me-2">
                                <i class="bi bi-facebook me-1"></i>
                            </a>
                            <a href="#" class="d-inline-block mb-3 text-dark fs-5 me-2">
                                <i class="bi bi-instagram me-1"></i>
                            </a>
                            <a href="#" class="d-inline-block mb-3 text-dark fs-5 ">
                                <i class="bi bi-envelope-fill me-1"></i>
                            </a>
                        </div>

                    </form>
                </div>
            </div>
            
        </div>
    </div>

<?php include('include/footer.php') ?>
    <!-- <script src="java.js"></script> -->
   <!-- Swiper JS -->
   <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  
</body>
</html>