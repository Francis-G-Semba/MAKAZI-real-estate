<?php session_start();

if (!isset($_SESSION['id'])) {
  // Redirect to the login form
  header("Location: index.php");
  exit();
}
 

  // Set the cache control headers
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

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


// Check if the property ID and form data are submitted
if (isset($_POST['property_id']) && isset($_POST['property_type']) && isset($_POST['status']) && isset($_POST['location']) && isset($_POST['price'])) {
    $propertyId = $_POST['property_id'];
    $propertyType = $_POST['property_type'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $status = $_POST['status'];

    // Update the property details in the database
    $query = "UPDATE properties SET property_type = ?, location = ?, price = ?, property_status = ? WHERE property_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ssssi", $propertyType, $location, $price, $status, $propertyId);
    $stmt->execute();


    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        echo "Property updated successfully.";
    } else {
        echo "Failed to update property." . $stmt->error;
    }

    // Close the statement and database connection
    $stmt->close();
    $db->close();
} else {
    echo "Invalid request.";
}
?>
