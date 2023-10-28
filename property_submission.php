<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    // Process the form data
    $propertyType = $_POST['property_type'];
    // Retrieve other property details here
    $propertyLocation = $_POST['property_location'];
    $price = $_POST['price'];
    $propertyStatus = $_POST['property_status'];
    $description = $_POST['description'];

    // Handle image uploads
    $propertyImage1 = $_FILES['image_1'];
    $propertyImage2 = $_FILES['image_2'];
    $propertyImage3 = $_FILES['image_3'];

    // Perform necessary validations on form data and images
    // Example validation: Check if property type is not empty
    if (empty($propertyType)) {
        die("Property type is required.");
    }
    if (empty($propertyLocation)) {
        die("Property location is required.");
    }
    if (empty($price)) {
        die("Price is required.");
    }
    if (empty($propertyStatus)) {
        die("Property status is required.");
    }
    if (empty($description)) {
        die("Property description is required.");
    }

    // Example validation: Check if at least one image is uploaded
    if (empty($propertyImage1['tmp_name']) || empty($propertyImage2['tmp_name']) || empty($propertyImage3['tmp_name'])) {
        die("Please upload at least one property image.");
    }

    // Save the property details to the database
    // Use prepared statements for security
    $insertQuery = "INSERT INTO submitted_properties (property_type, property_location, price, property_status, description) VALUES (?, ?, ?, ?, ?)";
    $stmt = $db->prepare($insertQuery);
    $stmt->bind_param("ssiss", $propertyType, $propertyLocation, $price, $propertyStatus, $description);
    $stmt->execute();
    $propertyId = $stmt->insert_id; // Get the last inserted property ID

    // Save property images to the server and database
    $uploadDir = 'images/submitted/'; // Specify your upload directory

    $imagePaths = array();
    $imagePaths[] = saveUploadedFile($propertyImage1, $uploadDir);
    $imagePaths[] = saveUploadedFile($propertyImage2, $uploadDir);
    $imagePaths[] = saveUploadedFile($propertyImage3, $uploadDir);

    // Insert image URLs and property ID into the property_images table
    $updateImageQuery = "UPDATE submitted_properties SET image_1 = ?, image_2 = ?, image_3 = ? WHERE property_id = ?";
    $stmt = $db->prepare($updateImageQuery);
    $stmt->bind_param("sssi", $imagePaths[0], $imagePaths[1], $imagePaths[2], $propertyId);
    
    foreach ($imagePaths as $imageUrl) {
        $stmt->execute();
    }

    echo '<script>alert("successful submission");</script>';
    echo '<script>window.location.href = "property_submission.php";</script>';
}

// Function to save uploaded files and return the file path
function saveUploadedFile($file, $uploadDir) {
    $fileName = basename($file['name']);
    $uploadPath = $uploadDir . $fileName;
    move_uploaded_file($file['tmp_name'], $uploadPath);
    return $uploadPath;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submission Result</title>
</head>
<body>
</body>
</html>
