<?php
session_start();

// Check if the agent is logged in
$loggedIn = isset($_SESSION['agent_id']);

// Handle logout request
if (isset($_GET['logout'])) {
    // Clear the session data
    session_unset();
    session_destroy();
    header("Location: agents.php");
    exit();
}

// Include the header file
include "include/header.php";
?>


<?php
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

// Retrieve the agent ID from the URL parameter
$agentId = filter_input(INPUT_GET, 'agent_id', FILTER_VALIDATE_INT);

// Check if the agent ID is valid
if ($agentId === false || $agentId === null) {
    echo "Invalid agent ID";
    exit;
}

// Prepare and execute the SQL query to retrieve the agent details
$stmt = $db->prepare("SELECT * FROM agents WHERE agent_id = ?");
$stmt->bind_param("i", $agentId);
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Fetch the agent details
$agent = $result->fetch_assoc();

// Check if the agent exists
if (!$agent) {
    // Handle the case when the agent doesn't exist
    echo "Agent Not Found";
    exit;
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
    <title>Agents Page</title>
    <link rel="stylesheet" href="CSS/more.css">
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
<?php include 'include/links.php'; ?>

    <div class="my-2 px-4">
        <h2 class="fw-bold h-font text-center">Property Submission Page</h2>
        <div class="h-line"></div>
        <div class="h-line2"></div>
    </div>

    <div class="container ">
    <div class="row justify-content-center align-items-center">
        <div class="col-lg-8 col-md-6 mb-4 ">
        <div class="bg-white rounded shadow p-4">
            <h4 class="fw-bold text-center">Real Estate Mwanza</h4>

    <form action="property_submission.php" method="POST" enctype="multipart/form-data" >
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
            <label class="form-label" style="font-weight: 500;" for="location">Location:</label>
            <input class="form-control shadow-none" type="text" name="property_location" id="location">
        </div>
        <div class="mt-3">
            <label class="form-label" style="font-weight: 500;" for="price">Price:</label>
            <input class="form-control shadow-none" type="number" name="price" id="price">
        </div>
        <div class="mt-3">
        <label for="status">Status:</label>
            <select class="form-select shadow-none" name="property_status" id="status">
                <option value="For Rent">For Rent</option>
                <option value="For Sale">For Sale</option>
            </select>
        </div>
        <div class="mt-3">
            <label class="form-label" style="font-weight: 500;" for="description">Description:</label>
            <textarea class="form-control shadow-none" rows="5" style="resize: none;" name="description" id="description"></textarea>
        </div>
        <div class="mt-3">
            <label class="form-label" style="font-weight: 500;" for="images">Images:</label>
            <input class="form-control shadow-none" type="file" name="image_1" id="images" multiple>
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


    <?php include "include/footer.php"; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.2/js/bootstrap.bundle.min.js" integrity="sha512-pv5/5Dg7VruhN35C5NzvNjKZ5gkN5O5Wq3PpK5y83LGLJvy33kjzkW9V8FvKx5l5NSLEu5P5yljKUo00Mtrfww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
    $(document).ready(function () {
        $('.dropdown-toggle').dropdown();
    });
    </script>
</body>
</html>

